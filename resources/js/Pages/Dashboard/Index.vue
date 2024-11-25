<script setup>
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";
import {PhLink, PhMoney, PhPlusCircle, PhUsers, PhVideoCamera} from "@phosphor-icons/vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import VideoCard from "@/Components/VideoCard.vue";
import DefaultTable from "@/Components/Tables/DefaultTable.vue";
import TextColumn from "@/Components/Tables/TextColumn.vue";
import PaymentForm from "@/Pages/Dashboard/PaymentForm.vue";
import PromoCodeForm from "@/Pages/Dashboard/PromoCodeForm.vue";
import SubscriptionCard from "@/Pages/Dashboard/SubscriptionCard.vue";
import StoryCard from "@/Components/StoryCard.vue";
import {usePage} from "@inertiajs/vue3";
import {money} from "@/Utils/money.js";
import Button from "@/Components/Actions/Button.vue";
import Certificates from "@/Pages/Dashboard/Certificates.vue";
import LinkButton from "@/Components/Actions/LinkButton.vue";
import PartnersTable from "@/Pages/Dashboard/PartnersTable.vue";

const props = defineProps({
    videos: Object,
    stories: Object,
    referred: Object,
    partner: Object
})

const user = computed(() => usePage().props.auth.user);
const subscriptions = computed(() => usePage().props.subscriptions);

const statItems = computed(() => {
    return [
        {
            name: 'Текущий баланс',
            content: money(user.value.balance),
            icon: PhMoney
        },
        {
            name: 'Вас пригласил',
            content: user.value.partner ? user.value.partner.name : 'Администратор',
            icon: PhUsers
        },
        {
            name: 'Переходов по реф. ссылке',
            content: user.value.referral_link_count,
            icon: PhLink
        },
        {
            name: 'Активные трансляции',
            content: '0 шт.',
            icon: PhVideoCamera
        },
    ]
})
</script>

<template>
    <AppLayout title="Дом">
        <div class="space-y-4 lg:space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="flex items-center bg-primary-600 shadow-lg rounded-2xl p-3 border-b-4 border-primary-800 text-white font-medium"
                     v-for="item in statItems">
                    <div class="inline-flex shrink-0 text-purple-600 bg-purple-100 rounded-full p-3 mr-4 shadow-lg">
                        <component :is="item.icon" class="size-6 lg:size-8"/>
                    </div>
                    <div class="w-full truncate">
                        <p class="block text-lg font-bold truncate">{{ item.content }}</p>
                        <span>{{ item.name }}</span>
                    </div>
                </div>
            </div>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-start">
                <PaymentForm/>
                <PromoCodeForm/>
                <div class="sm:col-span-2">
                    <Certificates/>
                </div>
            </section>
            <section>
                <header class="mb-6">
                    <h2 class="text-3xl font-bold"><span class="theme-gradient-text">Приглашенные</span> пользователи</h2>
                </header>
                <PartnersTable :user="user" :items="referred"/>
            </section>
            <section>
                <header class="flex items-center justify-between">
                    <h2 class="text-3xl font-bold"><span class="theme-gradient-text">Текущие</span> подписки</h2>
                    <LinkButton :href="route('plans.index')">Перейти к тарифам</LinkButton>
                </header>
                <div role="list" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                    <SubscriptionCard v-if="subscriptions.length" v-for="subscription in subscriptions" :subscription="subscription" :key="subscription.id"/>
                    <Link v-else :href="route('plans.index')" class="box flex items-center justify-center gap-6 p-6 w-full duration-300 hover:bg-primary-800">
                        <PhPlusCircle class="size-10"/>
                        <span class="font-semibold text-lg">Добавить подписку</span>
                    </Link>
                </div>
            </section>


            <section>
                <header class="mb-6">
                    <h2 class="text-3xl font-bold mb-2"><span class="theme-gradient-text">Ваши</span> видео</h2>
                </header>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                    <VideoCard v-for="video in videos" :video="video"/>
                    <VideoCard :video="{}" is-new/>
                </div>
            </section>
            <section>
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Ваши</span> истории</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                    <StoryCard v-for="stories in stories" :story="stories"/>
                    <StoryCard :story="{}" is-new/>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
