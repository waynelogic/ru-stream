<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch, PropType } from 'vue';
import {PhX} from "@phosphor-icons/vue";

const props = defineProps({
    title: {
        type: String,
        default: null,
    },
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String as PropType<'sm' | 'md' | 'lg' | 'xl' | '2xl'>,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);
const dialog = ref();
const showSlot = ref(props.show);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
        showSlot.value = true;
        dialog.value?.showModal();
    } else {
        document.body.style.overflow = null;
        setTimeout(() => {
            dialog.value?.close();
            showSlot.value = false;
        }, 200);
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        e.preventDefault();

        if (props.show) {
            close();
        }
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <dialog class="fixed inset-0 flex items-center justify-center bg-transparent backdrop:bg-transparent z-50" ref="dialog">
        <div class="relative w-full">
            <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
            </transition>

            <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <div
                    v-show="show"
                    class="box bg-primary-950 text-white rounded-lg overflow-hidden shadow-2xl transform transition-all sm:w-full sm:mx-auto"
                    :class="maxWidthClass"
                >
                    <header class="flex items-center justify-between gap-4 px-2 py-2 border-b border-white/20">
                        <div class="pl-3 text-white text-lg font-semibold text-center">
                            {{ title }}
                        </div>
                        <button class="btn btn-dark text-white text-lg font-semibold p-3 !outline-none" @click="$emit('close')">
                            <PhX class="size-6"/>
                        </button>
                    </header>
                    <slot v-if="showSlot"></slot>
                </div>
            </transition>
        </div>
    </dialog>
</template>
