<script setup>
import {router, usePage} from "@inertiajs/vue3";
import Button from "@/Components/Actions/Button.vue";

const props = defineProps({
    account: Object
})

const type = usePage().props.type;
const detachAccount = () => {
    router.post(route('streams.detachAccount', type), {
        account_id: props.account.id
    });
}
</script>

<template>
    <div class="box bg-primary-900 p-4 rounded-xl border-2">
        <div class="flex items-center font-medium text-white w-full">
            <img :src="account.avatar" class="size-8 mr-5 rounded-full shrink-0" alt="profile">
            <span class="block mr-2 truncate">{{ account.name }}</span>
            <Button class="shrink-0 ml-auto " @click="detachAccount" color="danger" size="xs" text-size="sm">
                Открепить
            </Button>
        </div>
    </div>
</template>

<style scoped>

</style>
