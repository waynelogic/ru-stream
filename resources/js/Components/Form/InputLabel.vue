<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="block font-medium">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
