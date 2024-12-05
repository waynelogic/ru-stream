<script setup>
import {Head, router, usePage} from "@inertiajs/vue3";
import DropdownLink from "@/Components/Auth/DropdownLink.vue";
import Dropdown from "@/Components/Actions/Dropdown.vue";
import {PhBell, PhCaretDown, PhGear} from "@phosphor-icons/vue";
import AsideNav from "@/Layouts/AppLayout/AsideNav.vue";
import Flash from "@/Components/Actions/Flash.vue";
import Button from "@/Components/Actions/Button.vue";
import AsidePanel from "@/Components/Actions/AsidePanel.vue";
import {computed, ref} from "vue";
import Footer from "@/Layouts/AppLayout/Footer.vue";
import AppIcon from "@/Pages/App/AppIcon.vue";
import Notifications from "@/Layouts/AppLayout/Notifications.vue";
import Snow from "@/Components/Common/Snow.vue";

const props = defineProps({
    title: String,
    meta: Object
})
const showNotifications = ref(false);
const page = usePage();
const notifications = computed(() => page.props.notifications.filter(notification => ! notification.read_at));

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <Head>
        <title v-if="title">{{ title }}</title>
        <meta v-for="(value, key) in meta" :key="key" :name="key" :content="value">
    </Head>
    <Flash/>
<!--    <Snow/>-->

    <div class="min-h-screen bg-primary-950 text-white">
        <AsideNav/>
        <AsidePanel align="right" width="sm" :open="showNotifications" @close="showNotifications = false">
            <Notifications :notifications="notifications" @close="showNotifications = false"/>
        </AsidePanel>

        <div class="lg:pl-60">
            <div class="sticky top-0 z-40 flex h-14 shrink-0 items-center gap-x-3 lg:gap-x-4 border-b border-white/20 bg-primary-900 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

                <AppIcon class="lg:hidden"/>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
<!--                    <form class="relative flex flex-1" action="#" method="GET">-->
<!--                        <label for="search-field" class="sr-only">Search</label>-->
<!--                        <svg class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
<!--                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />-->
<!--                        </svg>-->
<!--                        <input id="search-field" class="bg-transparent block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Поиск..." type="search" name="search">-->
<!--                    </form>-->
                    <div class="flex items-center gap-x-4 lg:gap-x-6 ml-auto">
                        <button @click="showNotifications = ! showNotifications" type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <div :class="[notifications.length ? 'mr-3' : '', 'relative']">
                                <PhBell :class="[ notifications.length ? 'text-primary-200' : '', 'size-6']"/>
                                <div v-if="notifications.length" class="absolute -top-1 left-full px-1 flex items-center justify-center text-xs border border-white/50 rounded">
                                    {{ notifications.length }}
                                </div>
                            </div>
                        </button>

                        <!-- Separator -->
                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-white/50" aria-hidden="true"></div>

                        <!-- Profile dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <Button color="primary" size="sm" radius="full" type="button" class="-m-1.5 flex items-center " id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <span class="flex items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6" aria-hidden="true">{{ $page.props.auth.user.login }}</span>
                                        <PhCaretDown weight="bold" class="ml-2 mr-3 size-3"/>
                                    </span>
                                </Button>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Управление аккаунтом
                                </div>
                                <DropdownLink :href="route('profile.show')">
                                    Профиль
                                </DropdownLink>
                                <div class="border-t border-white/20" />
                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        Выйти
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>

            <main class="p-4 lg:p-6 lg:pl-0 min-w-[0px] grow">
                <slot/>
            </main>
        </div>
    </div>
    <Footer/>
</template>

<style scoped>

</style>
