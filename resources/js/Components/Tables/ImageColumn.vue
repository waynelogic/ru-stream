<script setup>
import {computed} from "vue";
import {money} from "@/Utils/money.js";

const props = defineProps({
    row: Object,
    column: [String, Number],
})
const image = computed(() => {
    let val = props.row[props.column];

    return val
})
</script>

<template>
    <img :src="image" alt="" class="w-12 h-12 object-cover rounded-full">
</template>

<style scoped>

</style>
