<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/Auth/AuthenticationCardLogo.vue';
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineProps({
    policy: String,
});
</script>

<template>
    <GuestLayout title="Обработка персональных данных" :breadcrumbs="[ { title: 'Главная', url: route('home') }, { title: 'Обработка персональных данных', url: $page.url }, ]">
        <div class="container pb-12">
            <div class="w-full mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose max-w-none" v-html="policy" />
        </div>
    </GuestLayout>
</template>
