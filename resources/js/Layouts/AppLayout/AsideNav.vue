<script setup>
import {Link} from "@inertiajs/vue3";
import {PhAirplay, PhGear, PhHouse, PhShoppingCart, PhUser} from "@phosphor-icons/vue";
import {computed} from "vue";
import Svg from "@/Components/Common/Svg.vue";
import {streamType} from "@/Utils/streamType.js";
import AppIcon from "@/Pages/App/AppIcon.vue";

const mainNav = computed(() => {
    return [
        {
            name: 'Главное',
            type: 'group',
            items: [
                {
                    name: 'Дом',
                    link: '/dashboard',
                    icon: PhHouse,
                },
                {
                    name: 'Инструкции',
                    link: '/instructions',
                    icon: PhAirplay,
                },
                {
                    name: 'Подписки',
                    link: '/plans',
                    icon: PhShoppingCart,
                },
            ]
        },
        {
            name: 'Стримы',
            type: 'streams',
            items: streamType
        },
        {
            name: 'Настройки',
            type: 'group',
            items: [
                // {
                //     name: 'Уведомления',
                //     link: '/notifications',
                //     count: notifications.value.filter(n => n.read_at === null).length,
                //     icon: PhBell,
                // },
                {
                    name: 'Профиль',
                    link: '/user/profile',
                    icon: PhUser,
                },
            ]
        }
    ];
})

const bottomNav = [
    {
        name: 'Профиль',
        link: '/user/profile',
        icon: PhGear,
    },
]

const isItemActive = (item) => {
    return window.location.pathname.startsWith(item.link);
}
</script>

<template>
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-60 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto px-5 pb-4">
            <div class="flex h-14 shrink-0 items-center border-b border-white/20 bg-primary-900 p-5 -mx-5">
                <AppIcon/>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li v-for="group in mainNav" :key="group.name">
                        <div class="text-base font-semibold leading-6 text-gray-400 mb-1">{{group.name }}</div>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li v-for="item in group.items" :key="item.name">
                                <Link :href="item.link" :class="[isItemActive(item) ? 'bg-primary-800 text-white' : 'text-gray-400 hover:text-white', 'group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold leading-6 hover:bg-primary-700 duration-150']">
                                    <Svg class="shrink-0 size-6" :icon="item.icon" v-if="group.type === 'streams'"/>
                                    <component v-else :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                    {{ item.name }}
                                </Link>
                            </li>
                        </ul>
                    </li>
<!--                    <li class="mt-auto">-->
<!--                        <ul role="list" class="-mx-2 space-y-1">-->
<!--                            <li v-for="item in bottomNav" :key="item.name">-->
<!--                                <Link :href="item.link" :class="[isItemActive(item) ? 'bg-primary-800 text-white' : 'text-gray-400 hover:text-white', 'group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm font-semibold leading-6 hover:bg-primary-700 duration-150']">-->
<!--                                    <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />-->
<!--                                    {{ item.name }}-->
<!--                                </Link>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
                </ul>
            </nav>
        </div>
    </div>
</template>

<style scoped>

</style>
