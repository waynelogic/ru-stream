<script setup>
const props = defineProps({
    value: String,
    message: String
})
</script>

<template>
    <label :class="[value ? 'flex flex-col' : 'block font-medium']">
        <span v-if="value" class="block font-medium mb-1">{{ value }}</span>
        <slot />
        <span v-if="message" class="text-base text-red-400 drop-shadow mt-1">
            {{ message }}
        </span>
    </label>
</template>

<style scoped>

</style>
