<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Auth/Welcome.vue';
import VideoCard from "@/Components/VideoCard.vue";
import {computed, ref} from "vue";
import {PhDotsThree, PhLink, PhMoney, PhUsers, PhVideo, PhVideoCamera} from "@phosphor-icons/vue";
import Button from "@/Components/Actions/Button.vue";
import {money} from "@/Utils/money.js";
import {usePage} from "@inertiajs/vue3";
import Column from "@/Components/Tables/Column.vue";
import DefaultTable from "@/Components/Tables/DefaultTable.vue";
import TextColumn from "@/Components/Tables/TextColumn.vue";
import ImageColumn from "@/Components/Tables/ImageColumn.vue";
import PaymentForm from "@/Pages/Dashboard/PaymentForm.vue";
import PromoCodeForm from "@/Pages/Dashboard/PromoCodeForm.vue";
import Dropdown from "@/Components/Actions/Dropdown.vue";
import DropdownLink from "@/Components/Auth/DropdownLink.vue";
import SubscriptionCard from "@/Pages/Dashboard/SubscriptionCard.vue";
import StoryCard from "@/Components/StoryCard.vue";

const props = defineProps({
    videos: Object,
    stories: Object
})

const user = computed(() => usePage().props.auth.user);

const clients = [
    {
        id: 1,
        name: 'Tuple',
        imageUrl: 'https://tailwindui.com/img/logos/48x48/tuple.svg',
        lastInvoice: { date: 'December 13, 2022', dateTime: '2022-12-13', amount: '$2,000.00', status: 'Overdue' },
    },
    {
        id: 2,
        name: 'SavvyCal',
        imageUrl: 'https://tailwindui.com/img/logos/48x48/savvycal.svg',
        lastInvoice: { date: 'January 22, 2023', dateTime: '2023-01-22', amount: '$14,000.00', status: 'Paid' },
    },
    {
        id: 3,
        name: 'Reform',
        imageUrl: 'https://tailwindui.com/img/logos/48x48/reform.svg',
        lastInvoice: { date: 'January 23, 2023', dateTime: '2023-01-23', amount: '$7,600.00', status: 'Paid' },
    },
]


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

const people = [
    {
        name: 'Lindsay Walton',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'lindsay.walton@example.com',
        role: 'Member',
        image:
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Lindsay Walton',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'lindsay.walton@example.com',
        role: 'Member',
        image:
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Lindsay Walton',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'lindsay.walton@example.com',
        role: 'Member',
        image:
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
]
</script>

<template>
    <AppLayout title="Дом">
        <section class="space-y-4 lg:space-y-6">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <PaymentForm/>
                <PromoCodeForm/>
                <div class="lg:col-span-2">
<!--                    <Certificates/>-->
                </div>
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Текущие</span> подписки</h2>

                <ul role="list" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                    <SubscriptionCard v-for="subscription in clients" :subscription="subscription" :key="subscription.id"/>
                </ul>
            </div>
<!--            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">-->
<!--                &lt;!&ndash; Подписки &ndash;&gt;-->
<!--                <div>-->
<!--                    <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Текущие</span> подписки</h2>-->
<!--                    <SubscriptionsTable :subscriptions="subscriptions"/>-->
<!--                </div>-->
<!--                &lt;!&ndash; Приглашенные пользователи &ndash;&gt;-->
<!--                <div>-->
<!--                    <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Приглашенные</span> пользователи</h2>-->
<!--                    <PartnersTable :items="referred" :login="user.login"/>-->
<!--                </div>-->
<!--            </div>-->

            <div>
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Приглашенные</span> пользователи</h2>
                <div class="box overflow-hidden bg-primary-950/50 min-w-full align-middle">
                    <DefaultTable :rows="people">
                        <TextColumn column="name" label="Название"/>
                        <TextColumn column="department" label="Отдел"/>
                        <TextColumn column="role" label="Роль" badge/>
                    </DefaultTable>
                </div>
            </div>


            <div>
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Ваши</span> видео</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                    <VideoCard v-for="video in videos" :video="video"/>
                    <VideoCard :video="{}" is-new/>
                </div>
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Ваши</span> истории</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                    <StoryCard v-for="stories in stories" :story="stories"/>
                    <StoryCard :story="{}" is-new/>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
