<script setup>
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    subscriptions: Object
})
</script>

<template>
    <div class="border border-white/20 bg-primary-900/20 text-sm rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead class="max-md:hidden">
                <tr class="border-b border-white/20 bg-primary-900/50">
                    <th class="p-2" scope="col" v-for="(name, index) in ['Сервис', 'Статус', 'Дата окончания']" :key="index">
                        {{ name }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="max-md:flex max-md:flex-col border-b border-white/20 last:border-0" v-for="(item, key, index) in subscriptions" :key="index">
                    <th scope="row" class="max-md:pb-0 p-4 text-left align-middle">
                        <span class="whitespace-nowrap">{{ item.label }}</span>
                    </th>
                    <td class="p-4 lg:text-center align-middle">
                        {{ item.current ? item.current.name : 'Не активна' }}
                    </td>
                    <td class="max-md:p-4 max-md:pt-0 pr-2 text-right align-middle">
                        <template v-if="item.current">
                            <span class="block w-full text-end"> {{ new Date(item.current.end_at).toLocaleDateString() }}</span>
                            <div class="flex items-center">
                                <span class="mr-2">{{  item.current.percentage }}%</span>
                                <div class="relative w-full">
                                    <div :class="{'bg-red-200': item.current.percentage < 30, 'bg-yellow-200': item.current.percentage >= 30 && item.current.percentage < 60, 'bg-green-200': item.current.percentage >= 60}"
                                        class="overflow-hidden h-2 text-xs flex rounded bg-blue-200">
                                        <div :class="{'bg-red-500': item.current.percentage < 30, 'bg-yellow-500': item.current.percentage >= 30 && item.current.percentage < 60, 'bg-green-500': item.current.percentage >= 60}" :style="`width: ${item.current.percentage}%`"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <Link :href="route('plans.index') + '#' + item.value" class="btn btn-primary px-2 py-1 text-sm w-full" type="button">
                                Оформить
                            </Link>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
