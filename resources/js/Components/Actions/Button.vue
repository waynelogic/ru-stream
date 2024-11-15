<script setup lang="ts">
import {tv} from "tailwind-variants";
import {PropType} from "vue";
const props = defineProps({
    color: {
        type: String as PropType<"primary" | "secondary" | "success" | "danger" | "warning" | "info" | "gray">,
        default: 'primary'
    },
    size: {
        type: String as PropType<"xs" | "sm" | "md" | "lg" | "square">,
        default: 'md'
    },
    textSize: {
        type: String as PropType<"sm" | "md" | "lg">,
        default: 'md'
    }
})
const btn = tv({
    base: "inline-flex items-center justify-center rounded-md text-sm font-semibold leading-6 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 transition-colors duration-150",
    variants: {
        color: {
            primary: "theme-gradient hover:bg-indigo-500 focus-visible:outline-indigo-600",
            secondary: "bg-gray-600 hover:bg-gray-500 focus-visible:outline-gray-600",
            info: "bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600",
            success: "bg-green-600 hover:bg-green-500 focus-visible:outline-green-600",
            warning: "bg-gradient-to-r from-orange-400 to-yellow-500 hover:bg-yellow-500 focus-visible:outline-yellow-600",
            danger: "bg-gradient-to-r from-[#ea2840] to-[#FF7772FF] hover:bg-red-500 focus-visible:outline-red-600",
            gray: "bg-gray-600 hover:bg-gray-500 focus-visible:outline-gray-600"
        },
        size: {
            xs: "px-2 py-1",
            sm: "px-2 py-1",
            md: "px-4 py-2",
            lg: "px-6 py-3",
            square: "p-2 aspect-square"
        },
        textSize: {
            sm: "text-sm",
            md: "text-md",
            lg: "text-lg"
        }
    }
})
</script>

<template>
    <button :class="btn({color, size, textSize})">
        <slot />
    </button>
</template>

<style scoped>

</style>
