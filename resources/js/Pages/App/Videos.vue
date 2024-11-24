<script setup>
import StoryCard from "@/Components/StoryCard.vue";
import VideoCard from "@/Components/VideoCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    videos: Object,
    stories: Object
})
</script>

<template>
    <AppLayout>
        <section>
            <header class="mb-6">
                <h2 class="text-3xl font-bold mb-2"><span class="theme-gradient-text">Ваши</span> видео</h2>
            </header>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                <VideoCard v-for="video in videos" :video="video"/>
                <VideoCard :video="{}" is-new/>
            </div>
        </section>
        <section>
            <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Ваши</span> истории</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                <StoryCard v-for="stories in stories" :story="stories"/>
                <StoryCard :story="{}" is-new/>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>

</style>
