<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Link class="inline select-none underline text-sm text-primary-100 hover:text-primary-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <slot/>
    </Link>
</template>

<style scoped>

</style>
