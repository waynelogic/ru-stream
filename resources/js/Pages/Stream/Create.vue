<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {intervals} from "@/Utils/intervals.js";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {computed, onMounted, ref} from "vue";
import Button from "@/Components/Actions/Button.vue";
import VideoPlayer from "@/Components/Common/VideoPlayer.vue";
import Slider from "@/Components/Common/Slider.vue";
import {tips} from "@/Utils/tips.js";
import {streamType} from "@/Utils/streamType.js";
import VKStories from "@/Pages/Stream/Create/VKStories.vue";
import dayjs from "dayjs";
import Loader from "@/Pages/Stream/Partials/Loader.vue";

const props = defineProps({
    videos: {
        type: Object,
        required: true
    },
    account: {
        type: Object,
    },
    type: {
        type: String,
        required: true
    },
})

const obType = streamType[props.type]

const randomTip = ref(null);

onMounted(() => {
    function setRandomTip() {
        randomTip.value = tips[Math.floor(Math.random() * tips.length)];
    }
    setRandomTip();
    setInterval(setRandomTip, 10000)
})

const sliderOptions  = {
    slidesPerView: 1,
    spaceBetween: 20,
    breakpoints: {
        640: {slidesPerView: 2,},
        768: {slidesPerView: 2,},
        992: {slidesPerView: 2,},
        1100: {slidesPerView: 2,},
        1200: {slidesPerView: 3,},
        1400: {slidesPerView: 4,},
        1800: {slidesPerView: 5,},
    }
}

const form = useForm({
    account_id: props.account.id,
    title: null,
    description: null,
    repeat_interval: intervals[0].value,
    video_id: props.videos[0].id,
    start_at: dayjs().format('YYYY-MM-DDTHH:mm'),
    start_immediately: true,
    options: {}
})

const selectedVideo = computed(() => {
    let video = props.videos.find(video => video.id === form.video_id)
    form.title = video.title
    console.log(form)
    return video
})

const isLocked = ref(false)
const submit = () => {
    form.post(route('streams.store', props.type), {
        onBefore: () => isLocked.value = true,
        onSuccess: () => isLocked.value = false
    });
}
</script>

<template>
    <AppLayout :title="'Создание стрима - ' + obType.name">
        <transition appear enter-active-class="duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <Loader v-if="isLocked"/>
        </transition>
        <div class="max-w-screen-2xl mx-auto space-y-6 pb-12">
        <h3 class="text-lg md:text-2xl font-serif font-medium mb-4">{{ obType.name }}</h3>
            <!-- Верхний блок: Видео и форма -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <!-- Текущее видео -->
                <div class="box overflow-hidden rounded-xl">
                    <VideoPlayer :src="selectedVideo.video_url" :poster="selectedVideo.poster_url" :key="selectedVideo.id"/>
                    <div class="px-6 py-3 flex items-center font-medium text-white w-full border-b border-white/20">
                        <img :src="account.avatar_url" class="size-8 mr-5 rounded-full" alt="profile">
                        <span>Вы используете аккаунт - <b>{{ account.first_name }} {{ account.last_name }}</b></span>
                    </div>
                    <div class="px-6 py-4 flex space-x-4 w-full">
                        <img class="animate-bulb" width="25" height="25" src="/images/common/bulb.svg" alt="Tip">
                        <p class="font-semibold" v-html="randomTip"></p>
                    </div>
                </div>
                <!-- Форма -->
                <div class="box rounded-xl shadow-md">
                    <form @submit.prevent="submit" :class="[isLocked ? 'opacity-90 pointer-events-none scale-95' : '', 'space-y-3 p-6 duration-300']">
                        <div>
                            <InputLabel>Заголовок трансляций: максимум 50-55 символов</InputLabel>
                            <TextInput v-model="form.title" type="text" required autofocus maxlength="55" class="mt-1 block w-full" placeholder="Название трансляции" />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <component v-if="obType.creatorComponent" :is="obType.creatorComponent" v-model="form.options"/>
                        <fieldset>
                            <span class="mg:text-lg text-white font-bold mb-2">Настройка запуска трансляции</span>
                            <div class="flex gap-4 flex-wrap mt-1">
                                <label class="box shrink-0 py-2 px-4 has-[:checked]:bg-primary-700 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow cursor-pointer">
                                    Сразу
                                    <input class="sr-only" type="radio" name="showDatePicker" v-model="form.start_immediately" :value="true">
                                </label>
                                <label class="box shrink-0 py-2 px-4 has-[:checked]:bg-primary-700 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow cursor-pointer">
                                    По дате
                                    <input class="sr-only" type="radio" name="showDatePicker" v-model="form.start_immediately" :value="false">
                                </label>
                                <template v-if="!form.start_immediately">
                                    <label class="flex flex-col grow">
                                        <TextInput type="datetime-local" :required="!form.start_immediately" :min="new Date().toISOString().slice(0, 16)" v-model="form.start_at" placeholder="Введите время"/>
                                    </label>
                                </template>
                            </div>
                        </fieldset>
                        <fieldset class="flex flex-col">
                            <span class="mg:text-lg text-white font-bold mb-2">Выберите интервал автоповтора трансляций</span>
                            <div class="grid grid-cols-4 gap-2">
                                <label v-for="item in intervals" class="text-white text-sm p-2 text-center border border-white/50 rounded-xl cursor-pointer duration-300 hover:bg-primary-800 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow">
                                    <span class="shrink-0">{{ item.label }}</span>
                                    <input name="repeat_interval" :value="item.value" v-model="form.repeat_interval" type="radio" class="sr-only">
                                </label>
                            </div>
                        </fieldset>
                        <Button type="submit" color="primary" class="w-full">
                            Запуск трансляции
                        </Button>
                    </form>
                </div>
            </div>
            <div class="rounded-lg shadow-md">
                <h2 class="text-3xl font-bold mb-6"><span class="theme-gradient-text">Ваши</span> видео</h2>
                <Slider :options="sliderOptions">
                    <div class="swiper-slide p-1" v-for="video in videos">
                        <label :class="[selectedVideo.id === video.id ? 'bg-white/5 ring-2 ring-indigo-500' : 'bg-primary-900/40 ring-2 ring-white/10', 'flex flex-col rounded-xl overflow-hidden cursor-pointer']">
                            <VideoPlayer class="rounded-md overflow-hidden" :src="video.video_url" :poster="video.poster_url"/>
                            <span class="flex items-center gap-2 p-4">
                                <input type="radio" v-model="form.video_id" name="video" :value="video.id" class="size-5 peer border-white/20 text-indigo-500 bg-primary-900 focus:ring-0 focus:border-0 duration-300">
                                <span class="ml-2 text-base font-medium text-white line-clamp-1">{{ video.title }}</span>
                            </span>
                        </label>
                    </div>
                </Slider>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
