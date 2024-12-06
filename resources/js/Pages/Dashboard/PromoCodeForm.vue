<script setup>
import {PhBarcode} from "@phosphor-icons/vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/Form/InputError.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Button from "@/Components/Actions/Button.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";

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
        <FormLabel :message="form.errors.code">
            <TextInput v-model="form.code" type="number" placeholder="Введите промокод"/>
        </FormLabel>
        <Button color="primary" text-size="lg" type="submit">Активировать</Button>
    </form>
</template>

<style scoped>

</style>
