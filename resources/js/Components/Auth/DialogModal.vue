<script setup>
import Modal from '../Actions/Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="px-6 py-4">
            <div v-if="$slots.title" class="text-lg font-medium ">
                <slot name="title" />
            </div>

            <div :class="[$slots.title && 'mt-4', 'text-sm text-gray-200']">
                <slot name="content" />
            </div>
        </div>

        <div v-if="$slots.footer" class="flex flex-row justify-end px-6 py-4 bg-primary-900 text-end border-t border-white/20">
            <slot name="footer" />
        </div>
    </Modal>
</template>
