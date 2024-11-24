<script setup>
import {router} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import CaseItem from "@/Components/CaseItem.vue";
import {computed, onMounted} from "vue";

const props = defineProps({
    instructions: Object
})
onMounted(() => {
    router.reload({
        only: ['instructions'],
    })
})
</script>

<template>
    <AppLayout title="Инструкции">
        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            <CaseItem v-for="caseItem in instructions" :key="caseItem.id" :item="caseItem"/>
        </section>
    </AppLayout>
</template>

<style scoped>

</style>
