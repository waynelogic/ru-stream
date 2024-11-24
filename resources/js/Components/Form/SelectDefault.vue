<script setup>
const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null,
    },
    options: {
        type: Array,
        required: true,
        // Example format for options: [{ value: 'option1', label: 'Option 1' }]
    },
    placeholder: {
        type: String,
        default: '-',
    },
})
const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <select @change="$emit('update:modelValue', $event.target.value)" class="text-primary-950 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            :selected="option.value === modelValue"
        >
            {{ option.label }}
        </option>
    </select>
</template>

<style scoped>

</style>
