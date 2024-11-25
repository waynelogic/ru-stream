<script setup>
import {computed, provide, ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import {PhUserCirclePlus} from "@phosphor-icons/vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import AccountsSlider from "@/Pages/Stream/Partials/AccountsSlider.vue";
import Modal from "@/Components/Actions/Modal.vue";
import Button from "@/Components/Actions/Button.vue";

const title = 'Страница VK';

const props = defineProps({
    accounts: Object,
    type: String
})
const attachedAccounts = computed(() => props.accounts.filter(account => account.is_in_page));
const notAttachedAccounts = computed(() => props.accounts.filter(account => !account.is_in_page));

const form = useForm({
    account_id: '',
})
const submit = () => {
    if (form.account_id === 'new') {
        window.location.href = route('auth.vk.redirect', props.type);
    } else {
        form.post(route('streams.attachAccount', props.type), {
            onSuccess: () => isShowAttach.value = false
        });
    }
}

const isShowAttach = ref(false)
const openAttach = () => isShowAttach.value = true
provide('openAttach', openAttach)
</script>

<template>
    <AppLayout :title="title">
        <AccountsSlider :title="title" :accounts="attachedAccounts"/>

        <Modal :show="isShowAttach" title="Прикрепить аккаунт" closeable max-width="2xl" @close="isShowAttach = false">
            <form @submit.prevent="submit" class="p-4">
                <h3 class="font-serif font-medium mb-4">Выберите аккаунт</h3>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-4">
                        <label class="flex items-center gap-4 box rounded-md px-4 py-2 has-[:checked]:bg-primary-800 duration-300 cursor-pointer" v-for="account in notAttachedAccounts">
                            <input v-model="form.account_id" class="hidden" type="radio" name="account" :value="account.id">
                            <img :src="account.view_avatar" class="size-8 rounded-full" alt="profile">
                            <span class="font-serif font-semibold">{{ account.view_name }}</span>
                        </label>
                        <label class="flex items-center gap-4 box rounded-md px-4 py-2 has-[:checked]:bg-primary-800 duration-300 cursor-pointer">
                            <input v-model="form.account_id" class="hidden" type="radio" name="account" value="new">
                            <PhUserCirclePlus class="size-8"/>
                            <span class="font-serif font-semibold">Подключить новый</span>
                        </label>
                        <Button type="submit" class="w-full" :disabled="form.processing || !form.account_id">Прикрепить</Button>
                    </div>
                </div>
            </form>
        </Modal>
    </AppLayout>
</template>

<style scoped>

</style>
