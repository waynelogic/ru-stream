<script setup>
import {PhMoney} from "@phosphor-icons/vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import Button from "@/Components/Actions/Button.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";

const form = useForm({
    amount: null
})
const submitPayment = () => {
    form.post(route('dashboard.payment'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>
    <form @submit.prevent="submitPayment" class="box flex flex-col space-y-4 p-4">
        <h3 class="font-serif font-semibold">Пополнение баланса</h3>
        <FormLabel :message="form.errors.amount">
            <TextInput class="mt-auto" v-model="form.amount" type="number" placeholder="Сумма пополнения"/>
        </FormLabel>
        <Button color="primary" text-size="lg" type="submit">Пополнить</Button>
    </form>
</template>

<style scoped>

</style>
