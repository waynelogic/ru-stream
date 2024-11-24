<script setup>
import { Link } from '@inertiajs/vue3';
import {PhList} from "@phosphor-icons/vue";
import {computed, onMounted, ref} from "vue";
import AnimatedLogo from "@/Layouts/GuestLayout/AnimatedLogo.vue";
import Button from "@/Components/Actions/Button.vue";

const props = defineProps({
    headerPosition: {
        type: String,
        default: 'sticky',
    }
})

const menuOpen = ref(false);
const decorated = ref(false);

function decoration() {
    if (menuOpen.value) {
        decorated.value = true;
        return;
    }
    decorated.value = window.scrollY > 0;
}

function toggleMenu() {
    menuOpen.value = !menuOpen.value;
    decoration()
}

onMounted(() => {
    window.addEventListener('scroll', decoration);
    decoration();
});


const arMenuItems = computed(() => [
    {
        title : 'Главная',
        url : 'home'
    },
    {
        title : 'Тарифы',
        url : 'plans.index'
    },
    {
        title : 'Кейсы',
        url : 'cases'
    },
    {
        title : 'Блог',
        url : 'blog.index'
    },
]);
</script>

<template>
    <header :class="{ 'decorated': decorated, 'menuOpen': menuOpen, 'sticky border-b': headerPosition === 'sticky', 'fixed [&.decorated]:border-b': headerPosition === 'fixed' }" class="group header w-full top-0 text-white border-white/10 z-50">
        <div class="absolute inset-0 bg-[#00031c]/50 backdrop-blur-[20px] backdrop-saturate-[180%] shadow-lg z-[-1] opacity-0 group-[.decorated]:opacity-100 duration-300"></div>
        <div class="container flex max-lg:flex-wrap items-center justify-between py-3">
            <Link :href="route('home')" class="max-md:text-2xl text-white font-bold text-3xl drop-shadow-[0_2px_5px_rgba(255,255,255,0.1)]">
                <!--                <span class="theme-gradient text-transparent bg-clip-text animate-gradient-glow">RU:</span><span>STREAM</span>-->
                <AnimatedLogo/>
            </Link>
            <nav class="max-lg:grid max-lg:grid-rows-[0fr] group-[.menuOpen]:grid-rows-[1fr] max-lg:w-full max-lg:order-last">
                <div class="overflow-hidden w-full">
                    <ul class="flex lg:items-center font-semibold text-lg max-lg:flex-col max-lg:space-y-3 max-lg:mt-5 w-full ">
                        <li class="max-lg:border border-white/50 rounded-lg max-lg:w-full" v-for="item in arMenuItems">
                            <Link :href="route(item.url)" :class="{ 'text-indigo-400': route().current(item.url) }" class="flex px-4 max-lg:py-2 hover:text-indigo-500 duration-300">{{ item.title }}</Link>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="flex items-center space-x-2">
                <button title="Меню" @click="toggleMenu()" class="lg:hidden">
                    <ph-list class="size-7 text-white mr-4"/>
                </button>
                <template v-if="$page.props.auth.user">
                    <Button :href="route('dashboard')" radius="full" text-size="sm" class="">{{ $page.props.auth.user.login }}</Button>
                </template>
                <template v-else>
                    <Button radius="full" :href="route('login')">Вход</Button>
                    <Button color="secondary" radius="full" :href="route('register')" class="max-lg:hidden">Регистрация</Button>
                </template>
            </div>
        </div>
    </header>
</template>
