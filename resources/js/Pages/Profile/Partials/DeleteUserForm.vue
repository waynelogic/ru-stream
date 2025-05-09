<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/Auth/ActionSection.vue';
import DangerButton from '@/Components/Auth/DangerButton.vue';
import DialogModal from '@/Components/Auth/DialogModal.vue';
import InputError from '@/Components/Form/InputError.vue';
import SecondaryButton from '@/Components/Auth/SecondaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import Button from "@/Components/Actions/Button.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title>
            Удалить аккаунт
        </template>

        <template #description>
            Удалите свой аккаунт навсегда.
        </template>

        <template #content>
            <div class="max-w-xl text-sm">
                После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления. Прежде чем удалять свою учетную запись, загрузите все данные или информацию, которую вы хотите сохранить.
            </div>

            <div class="mt-5">
                <Button color="danger" text-size="sm" @click="confirmUserDeletion">
                    Удалить аккаунт
                </Button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <DialogModal title="Удалить аккаунт" :show="confirmingUserDeletion" @close="closeModal">
                <template #content>
                    Вы уверены, что хотите удалить свою учетную запись? После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.

                    <div class="mt-4">
                        <TextInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Пароль"
                            autocomplete="current-password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Отмена
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Удалить аккаунт
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
