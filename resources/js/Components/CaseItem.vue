<script setup>
import VKVideoPlayer from "@/Components/Common/VKVideoPlayer.vue";

defineProps({
    item: Object
})
</script>

<template>
    <div class="box duration-300 lg:hover:scale-[1.01]">
        <VKVideoPlayer :src="item.frame_src" class="rounded-2xl overflow-hidden p-2"/>
        <div class="px-4 pb-2">
            <h3 class="text-lg font-semibold">{{ item.title }}</h3>
            <p class="mt-1" v-if="item.description">{{ item.description }}</p>
        </div>
    </div>
</template>

<style scoped>

</style>
