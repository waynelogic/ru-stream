<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
    },
    breadcrumbs: {
        type: Array,
    },
})

</script>

<template>
    <div class="text-white border-b border-white/10">
        <div class="container py-6">
            <div class=" flex flex-wrap items-center justify-between">
                <h1 class="text-2xl text-center font-bold ">{{ title }}</h1>
                <ol class="breadcrumbs-list flex items-center" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" v-for="(item, index) in breadcrumbs">
                        <span v-if="index > 0" class="mx-2">-</span>
                        <Link :href="item.url" itemprop="item" class="hover:text-indigo-500">
                            <span itemprop="name">{{ item.title }}</span>
                        </Link>
                        <meta itemprop="position" :content="index + 1"/>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>
