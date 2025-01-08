<script setup lang="ts">
import { computed, defineProps } from 'vue';

const props = defineProps({
    value: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    modelValue: {
        type: String,
        default: '',
    },
})

defineEmits(['update:modelValue']);

const isChecked = computed(() => {
    return props.modelValue === props.value;
});
</script>

<template>
    <div @click="$emit('update:modelValue', value)" :class="['first:rounded-tl-md first:rounded-tr-md last:rounded-bl-md last:rounded-br-md', isChecked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer flex-col border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6']">
        <input type="radio" :value="value" :checked="isChecked" :class="[isChecked ? 'border-transparent bg-indigo-600' : 'border-gray-300 bg-white', isChecked ? 'ring-2 ring-indigo-600 ring-offset-2' : '', 'flex h-4 w-4 items-center justify-center rounded-full border']">
        <span class="flex items-center text-sm">
            <span :class="[isChecked ? 'text-indigo-900' : 'text-gray-900', 'ml-3 font-medium']">
                {{ label }}
            </span>
        </span>
    </div>
</template>
