<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputError from "@/Components/Form/InputError.vue";
import Button from "@/Components/Actions/Button.vue";

const step = ref(1);

const sendPhoneForm = useForm({
    phone: '+79895123444',
});
function sendPhoneNumber() {
    sendPhoneForm.post(route('auth.telegram', 'sendPhoneNumber'),{
        onSuccess: () => {
            step.value = 2;
        }
    });
}
const codeForm = useForm({
    code: '',
})
function completePhoneLogin() {
    codeForm.post(route('auth.telegram', 'completePhoneLogin'),{
        onSuccess: () => {
            step.value = 3;
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
async function complete2faLogin() {
    await axios.post('/api/telegram/complete-2fa', { password: this.password });
    alert('Logged in');
}
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
                <TextInput v-model="sendPhoneForm.phone" placeholder="Enter your phone number"/>
                <InputError :message="sendPhoneForm.errors.phone"/>
                <Button color="primary" type="submit">Получить код</Button>
            </form>

            <form class="flex flex-col" v-if="step === 2" @submit.prevent="completePhoneLogin">
                <InputLabel>Код</InputLabel>
                <TextInput v-model="codeForm.code" placeholder="Enter your phone number"/>
                <InputError :message="codeForm.errors.code"/>
                <Button color="primary" type="submit">Отправить код</Button>
            </form>

            <form v-if="step === 3" @submit.prevent="complete2faLogin">
                <input v-model="password" placeholder="Enter your 2FA password">
                <button type="submit">Complete 2FA Login</button>
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
