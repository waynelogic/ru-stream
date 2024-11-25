<script setup>
import {computed, provide, ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import {PhCheck, PhUserCirclePlus} from "@phosphor-icons/vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import AccountsSlider from "@/Pages/Stream/Partials/AccountsSlider.vue";
import Modal from "@/Components/Actions/Modal.vue";
import Button from "@/Components/Actions/Button.vue";
import CustomSelect from "@/Components/Form/CustomSelect.vue";

const title = 'Страница VK';

const props = defineProps({
    accounts: Object,
    vkAccounts: Object,
    type: String
})
const attachedAccounts = computed(() => props.accounts.filter(account => account.in_dashboard));
const notAttachedAccounts = computed(() => props.accounts.filter(account => !account.in_dashboard));

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
        only: ['vkAccounts'],
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
                            <label class="flex items-center gap-4 box rounded-md px-4 py-2 has-[:checked]:bg-primary-800 duration-300 cursor-pointer" v-for="account in notAttachedAccounts">
                                <input v-model="form.account_id" class="hidden" type="radio" name="account" :value="account.id">
                                <img :src="account.view_avatar" class="size-8 rounded-full" alt="profile">
                                <span class="font-serif font-semibold">{{ account.view_name }}</span>
                            </label>
                            <button type="button" @click="toggleNewAccount" class="flex items-center gap-4 box rounded-md p-2 has-[:checked]:bg-primary-900 duration-300 cursor-pointer">
                                <PhUserCirclePlus class="size-8"/>
                                <span class="font-serif font-semibold">Подключить новый</span>
                            </button>
                            <Button type="submit" class="w-full" :disabled="form.processing || !form.account_id">Прикрепить</Button>
                        </div>
                    </div>
                </form>
            </template>
            <template v-else>
                <div class="flex flex-col gap-6 p-4">
                    <CustomSelect placeholder="Выберите аккаунт" v-if="vkAccounts && vkAccounts.length" v-model="addForm.account_id" :options="vkAccounts ? vkAccounts.map(account => ({value: account.id, label: account.view_name, icon: account.view_avatar})) : []"/>

                    <template v-for="account in vkAccounts">
                        <transition enter-active-class="ease-out duration-300" enter-from-class="scale-0 opacity-0" enter-to-class="scale-100 opacity-100" leave-active-class="ease-in duration-200" leave-from-class="scale-100 opacity-100" leave-to-class="scale-0 opacity-0">
                            <div v-if="addForm.account_id === account.id" class="flex flex-col gap-4">
                                <label v-if="addForm.account_id === account.id" class="flex items-center gap-4 box rounded-md p-2 has-[:checked]:bg-primary-800 duration-300 cursor-pointer" v-for="group in account.api_groups">
                                    <input v-model="addForm.group_id" class="hidden" type="radio" name="account" :value="group.id">
                                    <img :src="group.photo_200" class="size-8 rounded-full" alt="profile">
                                    <span class="font-serif font-semibold">{{ group.name }}</span>
                                </label>
                            </div>
                        </transition>
                    </template>
                    <label class="flex items-center gap-4 box rounded-md p-2 has-[:checked]:bg-primary-900 duration-300 cursor-pointer">
                        <input v-model="addForm.account_id" class="hidden" type="radio" name="account" value="new">
                        <span>
                            <PhUserCirclePlus class="size-8"/>
                        </span>
                        <span class="font-serif font-semibold">Новый аккаунт ВКонтакте </span>
                    </label>
                    <Button :disabled="!addForm.account_id || !addForm.group_id && addForm.account_id !== 'new'" @click="addGroup" class="w-full">
                        Добавить
                        <PhCheck class="size-6 ml-2"/>
                    </Button>
                </div>
            </template>
        </Modal>
    </AppLayout>
</template>

<style scoped>

</style>
