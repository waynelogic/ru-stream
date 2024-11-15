<script setup>
import {defineAsyncComponent} from "vue";

const props = defineProps({
    icon: {
        type: String,
        required: true
    },
})

const svgIcon = defineAsyncComponent(() => import(`../../../images/svg-icons/${props.icon}.svg`))
</script>

<template>
    <component :is="svgIcon"/>
</template>
