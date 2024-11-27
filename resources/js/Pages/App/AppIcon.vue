<script setup>

import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Link href="/" class="group font-bold text-2xl md:text-3xl drop-shadow-[0_2px_5px_rgba(255,255,255,0.1)]">
        <span class="theme-gradient text-transparent bg-clip-text animate-gradient-glow">RU:</span>
        <span class="theme-gradient bg-clip-text animate-gradient-glow">
            <span :style="{transitionDelay: `${i * 0.04}s`}" class="group-hover:text-transparent duration-150" v-for="(letter, i) in ['S', 'T', 'R', 'E', 'A', 'M']" :key="i">
                {{ letter }}
            </span>
        </span>
    </Link>
</template>

<style scoped>

</style>
