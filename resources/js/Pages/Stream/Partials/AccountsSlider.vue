<script setup>
import {inject, onMounted, reactive, ref, watch, nextTick, computed} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import Button from "@/Components/Actions/Button.vue";
import {PhArrowLeft, PhArrowRight, PhPlusCircle} from "@phosphor-icons/vue";
import AccountCard from "@/Pages/Stream/Partials/AccountCard.vue";
import {useFlash} from "@/Utils/useFlash.js";
import StreamCard from "@/Pages/Stream/Partials/StreamCard.vue";
import Slider from "@/Components/Common/Slider.vue";
import NoSubsciption from "@/Pages/Stream/Partials/NoSubsciption.vue";

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    accounts: Object
})
const page = usePage();

const type = computed(() => page.props.type)
const subscription = computed(() => page.props.subscription)
const allowAccountAdding = computed(() => subscription.value.max_accounts_count - props.accounts.length > 0);


const swiperOptions = {
    modules: [Navigation],
    init: false,
    slidesPerView: 1,
    spaceBetween: 16,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 2 },
        992: { slidesPerView: 2 },
        1200: { slidesPerView: 3 }
    }
};
const openAttach = inject('openAttach')

function openStreamCreator(account_id) {
    if (page.props.videoCount === 0) {
        useFlash().error('У вас нет ни одного видео. Добавьте их на домашней странице')
    } else {
        router.visit(route('streams.create', { type: page.props.type, account_id: account_id}))
    }
}

onMounted(() => {

})
</script>

<template>
    <section v-if="subscription">
        <Slider class="accounts-swiper" :default-navigation="false" :options="swiperOptions">
            <template #before>
                <header class="flex items-center justify-between mb-4">
                    <h3 class="text-lg md:text-2xl font-serif font-medium">{{ title }}</h3>
                    <div class="flex gap-5">
                        <div class="swiper-button-prev">
                            <PhArrowLeft class="size-6"/>
                        </div>
                        <div class="swiper-button-next">
                            <PhArrowRight class="size-6"/>
                        </div>
                    </div>
                </header>
            </template>

            <div class="swiper-slide flex flex-col space-y-4" v-for="account in accounts">
                <AccountCard :account="account"/>
                <StreamCard v-for="stream in account.streams" :stream="stream" :key="stream.id"/>
                <button v-if="subscription.max_streams_count - account.streams.length > 0" @click="openStreamCreator(account.id)" class="flex items-center justify-center box border-2 rounded-xl p-4 duration-300 hover:bg-primary-800">
                    <PhPlusCircle class="size-8"/>
                </button>
            </div>
            <div v-if="allowAccountAdding" class="swiper-slide">
                <button @click="openAttach" class="w-full flex items-center box p-3 rounded-xl border-2 duration-300 hover:bg-primary-800">
                    <PhPlusCircle class="size-10"/>
                    <span class="ml-2">Добавить аккаунт</span>
                </button>
            </div>
        </Slider>
    </section>
    <NoSubsciption v-else :type="type"/>
</template>

<style scoped>

</style>
