<script setup>
import {Link} from "@inertiajs/vue3";
import {PhAirplay, PhCreditCard, PhHouse, PhVideoCamera} from "@phosphor-icons/vue";
import Svg from "@/Components/Common/Svg.vue";
import {streamType} from "@/Utils/streamType.js";
import {ref} from "vue";

const servicesOpen = ref(false);

const isItemActive = (link) => {
    return window.location.pathname.startsWith(link);
}
</script>

<template>
    <footer class="text-white md:hidden sticky bottom-0 bg-primary-950 border-t border-white/50 shadow-out z-[9999]">
        <div :class="{ 'active': servicesOpen }" class="grid grid-rows-[0fr] [&.active]:grid-rows-[1fr] duration-300">
            <div class="flex flex-col overflow-hidden">
                <ul class="px-4 py-4 space-y-3 border-b">
                    <li v-for="item in streamType">
                        <Link :href="`/streams/${item.handler}`" :class="{ 'bg-primary-800': isItemActive(`/streams/${item.handler}`) }" class="flex items-center space-x-3 border border-white/50 rounded-lg p-3 text-white text-sm">
                            <Svg class="shrink-0 size-6" :icon="item.handler"/>
                            <span>{{ item.name }}</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="w-full flex items-center">
            <li class="w-full flex flex-col items-center duration-200 hover:text-blue-400 py-3">
                <Link v-vibrate href="/dashboard" :class="{ 'text-primary-300': isItemActive('/dashboard') }">
                    <PhHouse class="size-8"/>
                </Link>
            </li>
            <li class="w-full flex flex-col items-center duration-200 hover:text-blue-400 py-2">
                <Link v-vibrate href="/instructions" :class="{ 'text-primary-300': isItemActive('/instructions') }">
                    <PhAirplay class="size-8"/>
                </Link>
            </li>
            <li class="w-full flex flex-col items-center hover:text-blue-400 ">
<!--                <button :disabled="!VkWidget" @click="VKOpened = !VKOpened" :class="{'bg-blue-900': VKOpened}" class="absolute bottom-2 shadow-2xl rounded-full border-2 border-gray-50 hover:border-blue-500 theme-gradient animate-gradient-glow p-3 duration-200">-->
<!--                    <Svg icon="vk-white" class="size-8"/>-->
<!--                </button>-->
            </li>
            <li class="w-full flex flex-col items-center duration-200 hover:text-blue-400 py-2">
                <Link v-vibrate href="/plans" :class="{ 'text-primary-300': isItemActive('/plans') }">
                    <PhCreditCard class="size-8"/>
                </Link>
            </li>
            <li class="w-full flex flex-col items-center duration-200 hover:text-blue-400 py-2" :class="{ 'text-primary-300': isItemActive('/streams') }">
                <button @click="servicesOpen = !servicesOpen">
                    <PhVideoCamera class="size-8"/>
                </button>
            </li>
        </ul>
    </footer>
</template>

<style scoped>

</style>
