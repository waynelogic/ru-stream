<script setup>
import {router} from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import CaseItem from "@/Components/CaseItem.vue";
import {onMounted} from "vue";

defineProps({
    cases: Object
});

onMounted(() => {
    router.reload({
        only: ['cases'],
    })
})
</script>
<template>
    <GuestLayout title="Кейсы" :breadcrumbs="[
            { title: 'Главная', url: route('home') },
            { title: 'Кейсы', url: $page.url },
        ]">
        <section class="h-full">
            <div class="container grid grid-cols-1 lg:grid-cols-3 gap-6 py-12">
                <CaseItem v-for="caseItem in cases" :key="caseItem.id" :item="caseItem"/>
            </div>
        </section>
    </GuestLayout>
</template>

<style scoped>

</style>
