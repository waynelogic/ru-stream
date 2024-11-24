<script setup lang="ts">
import {PropType} from "vue";
const props = defineProps({
    src: {
        type: String,
        required: true
    },
    poster: {
        type: String,
        default: null
    },
    controls: {
        type: Boolean,
        default: true
    },
    aspect: {
        type: String as PropType<'video' | 'story' | 'square'>,
        default: 'video'
    }
})
</script>


<template>
    <video :class="{'aspect-video': aspect === 'video', 'aspect-square': aspect === 'square', 'aspect-[9/16]': aspect === 'story'}" class="w-full" width="100%" height="auto" :poster="poster" :controls="controls">
        <source :src="src" type="video/mp4">
    </video>
</template>

<style scoped>

</style>
