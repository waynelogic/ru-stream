<script setup lang="ts">
import {computed, PropType, watch} from "vue";

const props = defineProps({
    open: {
        type: Boolean,
        default: false
    },
    align: {
        type: String as PropType<"left" | "right">,
        default: 'left',
    },
    width: {
        type: String as PropType<"xs" | "sm" | "md" | "lg">,
        default: 'xs',
    },
})

const widthClass = computed(() => {
    return {
        'xs': 'max-w-xs',
        'sm': 'max-w-sm',
        'md': 'max-w-md',
        'lg': 'max-w-lg',
    }[props.width.toString()];
});

const classEnterLeave = computed(() => {
    return props.align === 'right' ? 'translate-x-full' : '-translate-x-full'
})

watch(() => props.open, () => {
    if (props.open) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})
</script>

<template>
    <div class="relative z-[999]">
        <transition
            enter-active-class="ease-in-out duration-500"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in-out duration-500"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="open" @click="$emit('close')" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity cursor-pointer" aria-hidden="true"></div>
        </transition>

        <transition
            enter-active-class="transform transition ease-in-out duration-500"
            :enter-from-class="classEnterLeave"
            enter-to-class="translate-x-0"
            leave-active-class="transform transition ease-in-out duration-500"
            leave-from-class="translate-x-0"
            :leave-to-class="classEnterLeave"
        >
            <div v-if="open" class="flex fixed inset-0">
                <div @click="$emit('close')" :class="{'order-last': align === 'left'}" class="size-full"></div>
                <div :class="widthClass" class="w-full h-full bg-primary-900 shrink-0 overflow-y-scroll">
                    <slot/>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>

</style>
