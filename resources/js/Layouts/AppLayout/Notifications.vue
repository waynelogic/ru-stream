<script setup>

import {router, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import {PhShoppingCart, PhWrench, PhX} from "@phosphor-icons/vue";
import LinkButton from "@/Components/Actions/LinkButton.vue";

const props = defineProps({
    notifications: {
        type: Object,
    }
})
const emit = defineEmits(['close'])

const getIcon = (category) => {
    switch (category) {
        case 'subscription':
            return PhShoppingCart;
        case 'system':
            return PhWrench;
    }
}

const markAsRead = (notification) => {
    router.post(route('notifications.read', notification.id));
}
</script>

<template>
    <div class="flex items-start justify-between p-6 border-b border-white/20">
        <div class="inline-flex relative">
            <h3 class="text-base font-semibold font-serif">Уведомления</h3>
            <div class="absolute -top-1 left-full translate-x-1 px-1 flex items-center justify-center text-xs border rounded">
                {{ notifications.length }}
            </div>
        </div>
        <button @click="$emit('close')">
            <PhX class="size-4 lg:size-6" aria-hidden="true"/>
        </button>
    </div>
    <div class="flex flex-col divide-y divide-white/20">
        <div v-for="item in notifications" :key="item.id">
            <div class="flex items-start gap-4 p-4 border-l-2">
                <component :is="getIcon(item.data.category)" class="size-5 lg:size-7 shrink-0" aria-hidden="true"/>
                <div class="flex flex-col gap-1.5">
                    <div class="font-semibold">{{ item.data.title }}</div>
                    <div class="text-xs text-gray-400">{{ new Date(item.created_at).toLocaleString() }}</div>
                    <p class="text-sm">{{ item.data.message }}</p>
                    <LinkButton :href="item.data.link.url" v-if="item.data.link">
                        Подробнее
                    </LinkButton>
                </div>
                <button @click="markAsRead(item)">
                    <PhX class="size-4 lg:size-6" aria-hidden="true"/>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
