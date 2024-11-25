<script setup>
import { Link } from '@inertiajs/vue3';
import {computed} from "vue";

const props = defineProps({
    href: String,
    as: String,
});

const component = computed(() => {
    return props.as === 'button' ? 'button' : props.as === 'a' ? 'a' : Link;
})
</script>

<template>
    <div>
        <component :is="component" :href="href" class="w-full text-left block px-4 py-2 text-sm leading-5 text-gray-200 hover:bg-gray-100/50 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </component>
    </div>
</template>
