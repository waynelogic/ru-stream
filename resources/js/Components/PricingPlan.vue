<script setup>
import {PhCheck, PhUserCircle, PhVideoCamera} from "@phosphor-icons/vue";
import Button from "@/Components/Actions/Button.vue";
import Prose from "@/Components/Common/Prose.vue";
import {money} from "@/Utils/money.js";
import {router} from "@inertiajs/vue3";
const props = defineProps({
    plan: Object,
    currentTypePlan: Object,
    type: Object,
    frequency: Object
})

const submit = () => {
    router.post(route('subscriptions.store'), {
        plan: props.plan.id,
        frequency: props.frequency.value
    }, {
        preserveScroll: true
    })
}
const toggleAutorenew = () => {
    router.patch(route('subscriptions.update', props.currentTypePlan.id), {
        auto_renew: !props.currentTypePlan.auto_renew
    }, {
        preserveScroll: true
    })
}
</script>

<template>
    <div :class="[plan.most_popular ? 'bg-white/5 ring-2 ring-indigo-500' : 'bg-primary-900/40 ring-2 ring-white/10', 'flex flex-col rounded-3xl p-6 xl:p-8']">

        <div class="flex flex-wrap items-center justify-between gap-2">
            <h2 :id="plan.id" class="text-lg font-serif font-semibold leading-8 text-white">{{ plan.name }}</h2>
            <p v-if="plan.most_popular" class="rounded-full bg-indigo-500 px-2.5 py-1 text-xs font-semibold leading-5 text-white whitespace-nowrap">Популярный</p>
        </div>

        <Prose class="mt-4 text-base leading-6 text-gray-300 mb-6" v-html="plan.description"/>

        <dl role="list" class="text-sm space-y-3.5 lg:space-y-4 mb-4">
            <div role="listitem" class="flex items-center justify-between">
                <dt role="term" class="flex items-center font-semibold space-x-4">
                    <PhUserCircle class="size-6"/>
                    <span>{{ type.labels.accounts }}:</span>
                </dt>

                <dd role="definition" class="font-bold">
                    <span class="text-base border border-white/50 py-1 px-2 rounded">{{ plan.max_accounts_count }}</span>
                </dd>
            </div>
            <div class="flex items-center justify-between">
                <dt role="term" class="flex items-center font-semibold space-x-4">
                    <PhVideoCamera class="size-6"/>
                    <span>{{ type.labels.streams }}:</span>
                </dt>
                <dd role="definition" class="font-bold">
                    <span class="text-base border border-white/50 py-1 px-2 rounded">{{ plan.max_streams_count }}</span>
                </dd>
            </div>
        </dl>


        <p class="flex items-baseline gap-x-1 font-serif mt-auto">
            <span class="text-3xl font-bold tracking-tight text-white">{{ money(plan.price[frequency.value]) }}</span>
            <span class="text-sm font-semibold leading-6 text-gray-300">{{ frequency.priceSuffix }}</span>
        </p>
        <Button v-if="!currentTypePlan || currentTypePlan.pp_id !== plan.id" @click="submit" color="primary" class="mt-6 w-full">
            {{ currentTypePlan ? 'Переоформить' : 'Подписаться' }}
        </Button>
        <Button v-else :color="currentTypePlan.auto_renew ? 'gray' : 'danger'" @click="toggleAutorenew" class="mt-6 w-full">
            <span class="text-primary-950">
                {{ currentTypePlan.auto_renew ? 'Отменить автопродление' : 'Включить автопродление' }}
            </span>
        </Button>
    </div>
</template>

<style scoped>

</style>
