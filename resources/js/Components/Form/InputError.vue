<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div v-show="message">
        <p class="text-base text-red-400 drop-shadow">
            {{ message }}
        </p>
    </div>
</template>
