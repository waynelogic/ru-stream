<template>
    <div class="flex items-center">
        <img
            v-if="imageValue"
            class="size-11 rounded-full"
            :src="imageValue"
            alt="Картинка"
        />
        <div :class="imageValue ? 'ml-4' : ''">
            <span :class="spanClass">{{ value }}</span>
            <p v-if="descriptionValue" class="mt-1 text-sm text-gray-500">
                {{ descriptionValue }}
            </p>
        </div>
    </div>
</template>

<script setup>
import {computed} from "vue";
import {money} from "@/Utils/money.js";

const props = defineProps({
    row: Object,
    column: [String, Number],
    money: Boolean,
    badge: Boolean,
    image: String,
    date: {
        type: Boolean,
        default: null
    },
    description: String
})
const spanClass = computed(() => {
    if (props.badge) {
        return 'inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20';
    }
    return '';
})

const imageValue = computed(() => props.image ? props.row[props.image] : null);
const descriptionValue = computed(() => props.description ? props.row[props.description] : null);
const value = computed(() => {
    let val = props.row[props.column];

    if (props.money) {
        return money(val);
    }

    if (props.date) {
        return new Date(val).toLocaleDateString();
    }

    return val;
})
</script>
