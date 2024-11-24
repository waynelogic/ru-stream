<script setup>
import {PhBarcode} from "@phosphor-icons/vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/Form/InputError.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Button from "@/Components/Actions/Button.vue";

const form = useForm({
    code: null
})
function submit() {
    form.post(route('actions', 'usePromoCode'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>

    <form @submit.prevent="submit" class="box flex flex-col space-y-4 p-4">
        <h3 class="font-serif font-semibold">Активация промокода</h3>
        <TextInput class="mt-auto" v-model="form.code" type="number" placeholder="Введите промокод"/>
        <InputError :message="form.errors.code" class="mt-2"/>
        <Button color="primary" text-size="lg" type="submit">Активировать</Button>
    </form>
</template>

<style scoped>

</style>
