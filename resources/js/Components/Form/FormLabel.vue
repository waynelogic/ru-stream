<script setup>
import {watch} from "vue";

const props = defineProps({
    value: String,
    message: String
})

watch(() => props.message, () => {
    if (props.message) {
        if ('vibrate' in navigator) {
            navigator.vibrate([ 50, 0, 50 ]);
        }
    }
})
</script>

<template>
    <label class="flex flex-col">
        <span v-if="value" class="block font-medium mb-1">{{ value }}</span>
        <slot />
        <span v-if="message" class="text-base text-red-400 drop-shadow mt-2">
            {{ message }}
        </span>
    </label>
</template>

<style scoped>

</style>
