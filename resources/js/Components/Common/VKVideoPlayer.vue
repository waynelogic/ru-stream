<script setup>
const props = defineProps({
    title: {
        type: String,
        default: 'iframe',
    },
    src: {
        type: String,
        required: true
    }
})
</script>

<template>
    <iframe :title="title" ref="frame" class="aspect-video" loading="lazy" :src="src" width="100%" height="auto" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;"></iframe>
</template>
