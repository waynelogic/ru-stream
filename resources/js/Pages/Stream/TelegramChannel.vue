<script setup>
import {computed, provide, ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import {PhCheck, PhUserCirclePlus} from "@phosphor-icons/vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import AccountsSlider from "@/Pages/Stream/Partials/AccountsSlider.vue";
import Modal from "@/Components/Actions/Modal.vue";
import Button from "@/Components/Actions/Button.vue";
import CustomSelect from "@/Components/Form/CustomSelect.vue";
import Radio from "@/Pages/Stream/Partials/Radio.vue";

const title = 'Каналы Telegram';

const props = defineProps({
    accounts: Object,
    tgChats: Object,
    type: String
})
const attachedAccounts = computed(() => props.accounts.filter(account => account.is_in_page));
const notAttachedAccounts = computed(() => props.accounts.filter(account => !account.is_in_page));

const form = useForm({
    account_id: '',
})
const submit = () => {
    form.post(route('streams.attachAccount', props.type), {
        onSuccess: () => isShowAttach.value = false
    });
}
const isShowAttach = ref(false)
const openAttach = () => isShowAttach.value = true
provide('openAttach', openAttach)


const addForm = useForm({
    account_id: null,
    group_id: null
})
const showNewAccount = ref(false);
const toggleNewAccount = () => {
    router.reload({
        only: ['tgChats'],
        onSuccess: () => showNewAccount.value = true
    })
}

function addGroup() {
    if (addForm.account_id === 'new') {
        window.location.href = route('auth.vk.redirect', props.type);
    } else if (addForm.account_id && addForm.group_id) {
        addForm.post(route('auth.vk.addGroup'), {
            onSuccess: () => {
                addForm.reset();
                showNewAccount.value = false;
                isShowAttach.value = false
            },
        });
    } else {
        alert('Выберите аккаунт и группу')
    }
}
</script>

<template>
    <AppLayout :title="title">
        <AccountsSlider :title="title" :accounts="attachedAccounts"/>

        <Modal :show="isShowAttach" title="Прикрепить аккаунт" closeable max-width="2xl" @close="isShowAttach = false">
            <template v-if="!showNewAccount">
                <form @submit.prevent="submit" class="p-4">
                    <h3 class="font-serif font-medium mb-4">Выберите аккаунт</h3>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-4">
                            <label class="flex items-center gap-4 box rounded-md px-4 py-2 has-[:checked]:bg-primary-800 duration-300 cursor-pointer"
                                v-for="account in notAttachedAccounts">
                                <input v-model="form.account_id" class="hidden" type="radio" name="account"
                                       :value="account.id">
                                <img :src="account.view_avatar" class="size-8 rounded-full" alt="profile">
                                <span class="font-serif font-semibold">{{ account.view_name }}</span>
                            </label>
                            <button type="button" @click="toggleNewAccount"
                                    class="flex items-center gap-4 box rounded-md p-2 has-[:checked]:bg-primary-900 duration-300 cursor-pointer">
                                <PhUserCirclePlus class="size-8"/>
                                <span class="font-serif font-semibold">Подключить новый</span>
                            </button>
                            <Button type="submit" class="w-full" :disabled="form.processing || !form.account_id">
                                Прикрепить
                            </Button>
                        </div>
                    </div>
                </form>
            </template>
            <template v-else>
                <div class="flex flex-col gap-6 p-4">
                    {{ addForm.group_id }}
                    <CustomSelect placeholder="Выберите аккаунт" v-if="tgChats && tgChats.length" v-model="addForm.account_id" :options="tgChats ? tgChats.map(account => ({value: account.id, label: account.view_name})) : []"/>
                    <Radio v-model="addForm.group_id" value="1" label="Канал"/>
                    <Radio v-model="addForm.group_id" value="2" label="Канал"/>
                </div>
            </template>
        </Modal>
    </AppLayout>
</template>

<style scoped>

</style>
