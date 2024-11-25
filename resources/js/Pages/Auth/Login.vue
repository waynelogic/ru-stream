<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/Auth/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/Auth/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Form/Checkbox.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import LinkButton from "@/Components/Actions/LinkButton.vue";
import Button from "@/Components/Actions/Button.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";
import {ref} from "vue";
import {PhEye, PhEyeClosed} from "@phosphor-icons/vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const showPassword = ref(false);
</script>

<template>

    <GuestLayout>
        <AuthenticationCard>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="" autocomplete="on">
                <h4 class="text-2xl font-serif font-semibold mb-4">Вход</h4>
                <div>
                    <FormLabel value="E-mail" :message="form.errors.email">
                        <TextInput
                            id="email"
                            v-model="form.email"
                            placeholder="info@example.ru"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="username"
                        />
                    </FormLabel>
                </div>

                <div class="mt-4">
                    <FormLabel value="Пароль" :message="form.errors.password">
                        <div class="relative isolate mt-1">
                            <TextInput
                                id="password"
                                v-model="form.password"
                                placeholder="********"
                                :type="showPassword ? 'text' : 'password'"
                                class="block w-full pr-12"
                                required
                                autocomplete="current-password"
                            />
                            <button type="button" class="text-primary-950 absolute right-2 top-1/2 -translate-y-1/2 p-2 cursor-pointer">
                                <component :is="showPassword ? PhEye : PhEyeClosed" @click="showPassword = !showPassword" class="size-5"/>
                            </button>
                        </div>
                    </FormLabel>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center select-none">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ms-2 text-sm">Запомнить меня</span>
                    </label>
                    <LinkButton v-if="canResetPassword" :href="route('password.request')">
                        Забыли пароль?
                    </LinkButton>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Button radius="full" class="w-full" :disabled="form.processing">
                        Войти
                    </Button>
                </div>
            </form>
            <div class="rounded-lg py-4 text-center text-sm/5 ring-1 ring-white/20 mt-6">
                Нет аккаунта? <LinkButton href="/register">Создать новый</LinkButton>
            </div>
        </AuthenticationCard>
    </GuestLayout>
</template>
