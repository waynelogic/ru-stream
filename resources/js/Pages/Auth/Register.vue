<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/Auth/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/Auth/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Form/Checkbox.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";
import LinkButton from "@/Components/Actions/LinkButton.vue";
import Button from "@/Components/Actions/Button.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout title="Регистрация">
        <AuthenticationCard>
            <form @submit.prevent="submit" class="flex flex-col gap-3">
                <h4 class="text-2xl font-serif font-semibold mb-4">Регистрация</h4>
                <FormLabel value="Имя" :message="form.errors.name">
                    <TextInput
                        id="name"
                        v-model="form.name"
                        placeholder="Имя"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                    />
                </FormLabel>

                <FormLabel value="E-mail" :message="form.errors.email">
                    <TextInput
                        id="email"
                        v-model="form.email"
                        placeholder="E-mail"
                        type="email"
                        class="mt-1 block w-full"
                        required
                        autocomplete="username"
                    />
                </FormLabel>

                <FormLabel value="Пароль" :message="form.errors.password">
                    <TextInput
                        id="password"
                        v-model="form.password"
                        placeholder="******"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                </FormLabel>

                <FormLabel value="Подтверждение пароля" :message="form.errors.password_confirmation">
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        placeholder="******"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                </FormLabel>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="">
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                            <div class="ms-4">
                                Я согласен с <LinkButton target="_blank" :href="route('terms.show')">Условиями предоставления услуг</LinkButton> и <LinkButton target="_blank" :href="route('policy.show')">Обработкой персональных данных</LinkButton>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.terms" />
                    </InputLabel>
                </div>

                <Button  color="primary" class="w-full" :disabled="form.processing">
                    Зарегистрироваться
                </Button>
            </form>
            <div class="align-middle rounded-lg py-4 text-center text-sm/5 ring-1 ring-white/20 mt-6">
                Уже зарегистрированы? <LinkButton :href="route('login')">Войти</LinkButton>
            </div>
        </AuthenticationCard>
    </GuestLayout>
</template>
