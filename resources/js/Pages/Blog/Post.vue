<script setup>
import Prose from "@/Components/Common/Prose.vue";
import { Link, Head } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
defineProps(
    { post: Object, navPosts: Object }
);
</script>
<template>
    <GuestLayout :title="post.title">
<!--        <template #breadcrumbs>-->
<!--            <Breadcrumbs :title="post.title" :breadcrumbs="[-->
<!--                { title: 'Главная', url: route('home') },-->
<!--                { title: 'Блог', url: $page.url },-->
<!--            ]"/>-->
<!--        </template>-->
        <div class="container">
            <div class="flex flex-col lg:flex-row">

                <div class="max-lg:order-last lg:sticky lg:h-[calc(100vh-55px)] max-lg:border-t lg:border-r border-white/20 lg:top-[55px] lg:block pt-12">
                    <div class="lg:w-64 pb-5 lg:px-5 overflow-y-auto h-[calc(100%-53px)] ">
                        <ul class="space-y-5">
                            <li v-for="item in navPosts">
                                <Link class="font-semibold hover:text-indigo-500" :class="{ 'theme-gradient text-transparent bg-clip-text' : item.slug === post.slug }" :href="route('blog.show', item.slug)">
                                    {{ item.title }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex-1 max-w-3xl mx-auto w-full">
                    <div class="lg:container mx-auto lg:px-5 py-10">
                        <Prose class="text-white" v-html="post.content"/>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>

</style>
