<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineProps({
    terms: String,
});
</script>

<template>
    <GuestLayout title="Пользовательское соглашение" :breadcrumbs="[ { title: 'Главная', url: route('home') }, { title: 'Пользовательское соглашение', url: $page.url }, ]">
        <div class="container pb-12">
            <div class="w-full mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose max-w-none" v-html="terms" />
        </div>
    </GuestLayout>
</template>
