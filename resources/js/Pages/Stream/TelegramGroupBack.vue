<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed, ref} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
import Button from "@/Components/Actions/Button.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";
import { vMaska } from "maska/vue"


const page = usePage();
const data = computed(() => page.props.data);

const step = ref(1);

const sendPhoneForm = useForm({
    phone: '+79895123444',
});
const sendPhoneNumber = () => {
    sendPhoneForm.post(route('auth.telegram', 'sendPhoneNumber'),{
        onError: () => {
            sendPhoneForm.reset();
            step.value = 1;
        },
        onSuccess: () => {
            step.value = 2;
        },
    });
}

const codeForm = useForm({
    code: '',
})
function completePhoneLogin() {
    codeForm.post(route('auth.telegram', 'completePhoneLogin'),{
        onSuccess: () => {
            if (data.value.status === '2FA required') {
                step.value = 3;
            } else if (data.value.status === 'Signup required') {
                step.value = 4;
            } else {
                alert('Logged in');
            }
        },
        onError: () => {
            codeForm.reset();
            step.value = 2;
        }
    });
}

const passwordForm = useForm({
    password: '',
})
const complete2faLogin = () => {
    passwordForm.post(route('auth.telegram', 'complete2faLogin'),{
        onSuccess: () => {
            alert('Logged in');
        }
    });
}


const phoneCode = ref('');
const password = ref('');
const firstName = ref('');
const lastName = ref('');

// async function completePhoneLogin() {
//     const response = await axios.post('/api/telegram/complete-login', { phone_code: phoneCode.value });
//     if (response.data.status === '2FA required') {
//         this.hint = response.data.hint;
//         this.step = 3;
//     } else if (response.data.status === 'Signup required') {
//         this.step = 4;
//     } else {
//         alert('Logged in');
//     }
// }

async function completeSignup() {
    await axios.post('/api/telegram/signup', { first_name: firstName, last_name: lastName });
    alert('Signed up and logged in');
}
</script>

<template>
    <AppLayout title="Telegram группа">
        <div class="box p-10">
            <form class="flex flex-col" v-if="step === 1" @submit.prevent="sendPhoneNumber">
                <InputLabel>Телефон</InputLabel>
                <TextInput v-maska="'+7 (###) ###-##-##'" v-model="sendPhoneForm.phone" placeholder="Enter your phone number"/>
                <InputError :message="sendPhoneForm.errors.phone"/>
                <Button color="primary" type="submit">Получить код</Button>
            </form>

            <form class="flex flex-col" v-if="step === 2" @submit.prevent="completePhoneLogin">
                <InputLabel>Код</InputLabel>
                <TextInput v-model="codeForm.code" placeholder="Enter your phone number"/>
                <InputError :message="codeForm.errors.code"/>
                <Button color="primary" type="submit">Отправить код</Button>
            </form>

            <form class="flex flex-col" v-if="step === 3" @submit.prevent="complete2faLogin">
                <InputLabel>Ппароль</InputLabel>
                <FormLabel value="Введите облачный пароль" :message="passwordForm.errors.password">
                    <TextInput v-model="passwordForm.password" placeholder="Enter your phone number"/>
                </FormLabel>
                <Button color="primary" type="submit">Подтвердить пароль</Button>
            </form>

            <form v-if="step === 4" @submit.prevent="completeSignup">
                <input v-model="firstName" placeholder="First Name">
                <input v-model="lastName" placeholder="Last Name">
                <button type="submit">Complete Signup</button>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
