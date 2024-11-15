<script setup>
import {PhDotsThree} from "@phosphor-icons/vue";
import Button from "@/Components/Actions/Button.vue";
import Dropdown from "@/Components/Actions/Dropdown.vue";
import DropdownLink from "@/Components/Auth/DropdownLink.vue";
const props = defineProps({
    subscription: Object
})

const statuses = {
    Paid: 'text-green-400 bg-green-900 ring-green-500/20',
    Withdraw: 'text-gray-400 bg-gray-900 ring-gray-500/20',
    Overdue: 'text-red-100 bg-red-900 ring-red-600/20',
}
</script>

<template>
    <li class="overflow-hidden box">
        <div class="flex items-center gap-x-4 border-b border-gray-700 bg-primary-950 p-6">
            <img src="https://tailwindui.com/img/logos/48x48/savvycal.svg" alt="SavvyCal" class="h-12 w-12 flex-none rounded-lg bg-primary-800 object-cover ring-1 ring-gray-700"/>
            <div class="text-base font-serif font-medium leading-6 text-gray-100">SavvyCal</div>
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
        <dl class="-my-3 divide-y divide-gray-700 px-6 py-4 text-sm leading-6">
            <div class="flex justify-between gap-x-4 py-3">
                <dt class="text-gray-400">Last invoice</dt>
                <dd class="text-gray-200">
                    <time :datetime="subscription.lastInvoice.dateTime">{{ subscription.lastInvoice.date }}</time>
                </dd>
            </div>
            <div class="flex justify-between gap-x-4 py-3">
                <dt class="text-gray-400">Amount</dt>
                <dd class="flex items-start gap-x-2">
                    <div class="font-medium text-gray-100">{{ subscription.lastInvoice.amount }}</div>
                    <div :class="[statuses[subscription.lastInvoice.status], 'rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">{{ subscription.lastInvoice.status }}</div>
                </dd>
            </div>
        </dl>
    </li>
</template>

<style scoped>

</style>
