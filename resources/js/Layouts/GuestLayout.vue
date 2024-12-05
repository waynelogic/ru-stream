<script setup>
import Flash from "@/Components/Actions/Flash.vue";
import {Head} from "@inertiajs/vue3";
import Header from "@/Layouts/GuestLayout/Header.vue";
import Footer from "@/Layouts/GuestLayout/Footer.vue";
import Breadcrumbs from "@/Layouts/AppLayout/Breadcrumbs.vue";
import Snow from "@/Components/Common/Snow.vue";

const props = defineProps({
    title: String,
    meta: Object,
    fixedHeader: {
        type: Boolean,
        default: false
    },
    breadcrumbs: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <Head>
        <title v-if="title">{{ title }}</title>
        <meta v-for="(value, key) in meta" :key="key" :name="key" :content="value">
    </Head>
    <Flash/>
<!--    <Snow/>-->
    <div class="flex flex-col min-h-screen bg-primary-950 text-white">
        <Header :header-position="fixedHeader ? 'fixed' : 'sticky'"/>
        <Breadcrumbs v-if="breadcrumbs.length" :title="title" :breadcrumbs="breadcrumbs"/>
        <section class="breadcrumbs" v-if="$slots.breadcrumbs">
            <slot name="breadcrumbs"/>
        </section>
        <main class="grow">
            <slot />
        </main>
        <Footer/>
    </div>
</template>

<style scoped>

</style>
