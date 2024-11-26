<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/Auth/ActionMessage.vue';
import FormSection from '@/Components/Auth/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/Auth/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import FormLabel from "@/Components/Form/FormLabel.vue";
import Button from "@/Components/Actions/Button.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Обновить пароль
        </template>

        <template #description>
            Чтобы обеспечить безопасность, в вашей учетной записи используется длинный случайный пароль.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <FormLabel value="Текущий пароль" :message="form.errors.current_password">
                    <TextInput
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="current-password"
                    />
                </FormLabel>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <FormLabel value="Новый пароль" :message="form.errors.password">
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                </FormLabel>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <FormLabel value="Подтверждение пароля" :message="form.errors.password_confirmation">
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                </FormLabel>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Сохранено.
            </ActionMessage>

            <Button text-size="sm" :disabled="form.processing">
                Сохранить
            </Button>
        </template>
    </FormSection>
</template>
