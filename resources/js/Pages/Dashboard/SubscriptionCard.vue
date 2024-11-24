<script setup>
import {PhDotsThree} from "@phosphor-icons/vue";
import Button from "@/Components/Actions/Button.vue";
import Dropdown from "@/Components/Actions/Dropdown.vue";
import DropdownLink from "@/Components/Auth/DropdownLink.vue";
import {streamType} from "@/Utils/streamType.js";
import Svg from "@/Components/Common/Svg.vue";
import {router} from "@inertiajs/vue3";
const props = defineProps({
    subscription: Object
})

const type = streamType[props.subscription.type]

const renew = {
    true: 'text-lime-400 bg-lime-900 ring-lime-500/20',
    false: 'text-rose-100 bg-rose-900 ring-rose-600/20',
}

const getColor = (percentage) => {
    if (percentage >= 60) {
        return 'bg-lime-500'
    }
    if (percentage >= 30 && percentage < 60) {
        return 'bg-yellow-500'
    }
    if (percentage < 30) {
        return 'bg-rose-500'
    }
    return 'bg-rose-900'
}

const toggleAutorenew = () => {
    router.patch(route('subscriptions.update', props.subscription.id), {
        auto_renew: !props.subscription.auto_renew
    }, {
        preserveScroll: true
    })
}
</script>

<template>
    <div role="listitem" class="overflow-hidden box">
        <div class="flex items-center gap-x-4 border-b border-gray-700 bg-primary-950 p-4">
            <div class="rounded-lg bg-primary-800 ring-1 ring-gray-700 p-2">
                <Svg class="shrink-0 size-6" :icon="type.icon"/>
            </div>
            <div class="text-sm font-serif font-medium leading-6 text-gray-100">{{ type.name }}</div>
<!--            <Dropdown class="ml-auto">-->
<!--                <template #trigger>-->
<!--                    <button type="button">-->
<!--                        <span class="sr-only">Open options</span>-->
<!--                        <PhDotsThree class="size-6" aria-hidden="true" />-->
<!--                    </button>-->
<!--                </template>-->
<!--                <template #content>-->
<!--                    <DropdownLink>View</DropdownLink>-->
<!--                    <DropdownLink>Send message</DropdownLink>-->
<!--                </template>-->
<!--            </Dropdown>-->
        </div>
        <dl class="-my-3 px-6 py-4 text-sm leading-6">
            <div class="flex justify-between gap-x-4 py-3 border-b border-white/20">
                <dt class="text-gray-300">Тариф</dt>
                <dd class="text-gray-200">
                    <span>
                        {{ subscription.name }}
                    </span>
                </dd>
            </div>
            <div class="flex justify-between gap-x-4 py-3">
                <dt class="text-gray-300">Дата окончания</dt>
                <dd class="text-gray-200">
                    <time :datetime="subscription.ends_at">{{ new Date(subscription.ends_at).toLocaleDateString() }}</time>
                </dd>
            </div>
            <div class="relative">
                <div class="w-full bg-primary-800 h-1 rounded-full overflow-hidden">
                    <div class="h-1"
                         :class="getColor(subscription.percentage)"
                         :style="{ width: `${subscription.percentage}%` }"></div>
                </div>
            </div>
            <div class="flex justify-between gap-x-4 py-3">
                <dt class="text-gray-400">Автопродление</dt>
                <dd class="flex items-start gap-x-2">
                    <button type="button"  @click="toggleAutorenew" :class="[renew[subscription.auto_renew], 'rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">
                        {{ subscription.auto_renew ? 'Включено' : 'Выключено' }}
                    </button>
                </dd>
            </div>
        </dl>
    </div>
</template>

<style scoped>

</style>
