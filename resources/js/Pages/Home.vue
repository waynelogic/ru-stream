<script setup>
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import {PhCaretDown, PhPlayCircle} from "@phosphor-icons/vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Button from "@/Components/Actions/Button.vue";
import {intervals} from "@/Utils/intervals.js";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import VKVideoPlayer from "@/Components/Common/VKVideoPlayer.vue";
import CaseItem from "@/Components/CaseItem.vue";
import Modal from "@/Components/Actions/Modal.vue";

const props = defineProps({
    cases: Object,
    intervals: Object
});

const showModal = ref(false);

const isBgShowing = ref(false);
let arSteps = [
    'Загрузи готовое видео',
    'Выбери интервал автоповтора',
    'Запусти автотрансляцию'
];

const testForm = ref({
    start_immediately: true,
    repeat_interval: intervals[0].value
})

let arFaq = [
    {
        title: 'Чем занимается платформа RU:STREAM?',
        icon: '/images/home/faq/camera.png',
        text: '<p>Сервис позволяет пользователям загружать заранее подготовленные видеоролики, выбирать интервал воспроизведения (например, повторять каждый час) и запускать их в прямом эфире на страницы ВКонтакте, Telegram и других платформах.</p>'
    },
    {
        title: 'Могу ли я заработать на RU:STREAM',
        icon: 'images/home/faq/cache.png',
        text: `
            <p>Партнерская программа сервиса, позволяет зарабатывать Бонусные рубли (1 БР = 1 РУБ) за привлечение новых пользователей. Вы получите комиссию в размере 10% от всех платежей привлеченных партнеров, которая сразу поступит на ваш баланс.</p>
            <p>Партнерские начисления могут использоваться только для оплаты услуг сервиса без возможности вывода или передачи другому пользователю. Вашу партнерскую ссылку можно найти в личном кабинете.</p>
            <h4>ВАЖНАЯ ИНФОРМАЦИЯ:</h4>
            <p>
                Сервис RU:STREAM не предлагает заработок на продажах, инвестиции или доверительное управление. Мы призываем пользоваться нашими услугами, а за рекомендации друзьям предусмотрен бонус.
            </p>
            <p>
                Если у вас есть вопросы, задавайте их в чате. <a href="https://t.me/+S6qQvXprClE1NTZi" target="_blank">https://t.me/+S6qQvXprClE1NTZi</a>
            </p>
        `,
    },
    {
        title: 'Какие есть ограничения',
        icon: '/images/home/faq/document.png',
        text: `<p>
            Ограничения просты и довольно банальны. Запрещено запускать в прямой эфир видео с содержанием:
        </p>
        <p>
            Реклама и продажа оружия, петард, пневматики Распространение и приобретение табака, наркотиков, алкоголя Предложение и оказание сексуальных услуг Материалы частных лиц без их согласия Накрутки, взломы, хакерские услуги Казино, игры на деньги, ставки (все, кроме покера запрещено законодательством РФ) и так далее.
        </p>
        <p>
            Отдельно выносим пункт о видео, которые в той или иной степени могут расчитываться как дескридитация власти и армии. Так же, не забываем про чувства верующих! Всё что запрещенно в вк, youtube и телеграмм - запрещено и у нас
        </p>
        <p>
            Аккаунты на которых будут замечены видео с запрещённым содержанием будут удалены из системы, ваш аккаунт вк будет добавлен в чёрный список. Даже если вы поменяете почту, аккаунт соцсети вы поменять не сможете. По этому не рискуйте.
        </p>`
    },
    {
        title: 'Кому полезен сервис RU:STREAM?',
        icon: '/images/home/faq/pc.png',
        text:
            `<ul>
                <li>Среднему и малому бизнесам</li>
                <li>Блогерам, маркетологам и SMM-специалистам</li>
                <li>Любому автору в Интернете</li>
            </ul>
            <p>Запускайте в эфир вебинары и конкурсы. Автоматизируйте рекламу и продажи ваших товаров и услуг. Повышайте лояльность аудитории и узнаваемость бренда</p>
            `
    },
];

// <meta property="og:title"
//       content="Как быстро и бесплатно сделать инфографику: 4 онлайн-сервиса с доступным функционалом"/>

</script>

<template>
    <Head>
        <meta property="og:title" content="Ru:Stream - Платформа для рестрима ваших видео"/>
    </Head>
    <GuestLayout fixed-header>
        <section class="hero-section relative isolate">
            <!--Задний фон-->
            <img :class="isBgShowing ? 'opacity-50' : ''" class="absolute opacity-0 w-full z-[-1] duration-[1000ms]" @load="isBgShowing = true"  :src="'/images/home/home-gradient.png'" alt="">
            <div class="container pb-12 pt-36">
                <div class="relative text-center flex flex-col items-center justify-center">
                    <!-- Анимировання полоска -->
                    <img class="w-full absolute left-0 right-0" src="/images/home_decor.gif" alt="background wave">
                    <h2 class="relative text-3xl md:text-4xl font-semibold font-serif mb-4"><span><img class="absolute -top-10 inline animate-bounce" decoding="async" src="https://themegenix.net/nerko/wp-content/uploads/2022/12/ethereum-01.png" width="44" alt=""></span> Авто Стриминговая Платформа</h2>
                    <p class="text-2xl mb-4">Автоматизируйте прямые эфиры с помощью RU:STREAM</p>
                    <div class="group relative flex items-center justify-center w-full lg:w-1/2 isolate cursor-pointer" tabindex="0" @click="showModal = true">

                        <PhPlayCircle class="absolute text-white top-[calc(50%_-_55px)] duration-300 group-hover:text-black size-20 z-10 drop-shadow"/>
                        <!-- Анимиррованный кругляш-->
                        <div class="absolute right-0 bottom-0 flex hero-wrapper-circle d-none d-sm-block isolate">
                            <img class="size-10 m-6" src="/images/home/hero-circle.png" alt="">
                            <div class="absolute size-full object-center backdrop-blur-sm bg-white/20 rounded-full z-[-1]">
                                <svg class="size-full animate-[spin_6s_linear_infinite]" viewBox="0 0 100 100" width="100" height="100">
                                    <defs><path id="circle" fill="currentColor" fill-opacity=" 0.12" d="M 50, 50 m -37.5, 0 a 37.5,37.5 110 1,1 75,0 a 37.5,37.5 110 1,1 -75,0"></path></defs>
                                    <text font-size="12" textLength="230">
                                        <textPath xlink:href="#circle">RU STREAM - FIST RESTRIM PLATFORM</textPath>
                                    </text>
                                </svg>
                            </div>
                        </div>

                        <!-- Ноутбук-->
                        <svg width="1008" height="100%" viewBox="0 0 1008 635" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_f_4_49)">
                                <ellipse cx="504.5" cy="586" rx="452.5" ry="5" fill="black"/>
                            </g>
                            <path d="M99 28C99 13.0883 111.088 1 126 1H886C900.912 1 913 13.0883 913 28V550C913 551.657 911.657 553 910 553H102C100.343 553 99 551.657 99 550V28Z" fill="#1A202C" stroke="#4A5568" stroke-width="2"/>
                            <path d="M103 27C103 14.8497 112.85 5 125 5H887C899.15 5 909 14.8497 909 27V533H103V27Z" fill="black"/>
                            <image x="119" y="31" width="770" height="480"  preserveAspectRatio="xMinYMin slice" xlink:href="/images/home/home_main_hero.jpg"></image>
                            <rect x="119" y="31" width="770" height="480" class="fill-black/30 duration-300 group-hover:opacity-0"/>
                            <path d="M464.173 535.545V545H465.816V538.491H465.904L468.517 544.972H469.745L472.358 538.505H472.445V545H474.089V535.545H471.993L469.186 542.396H469.075L466.269 535.545H464.173ZM477.921 545.143C479.033 545.143 479.698 544.621 480.003 544.026H480.058V545H481.665V540.254C481.665 538.38 480.137 537.817 478.784 537.817C477.293 537.817 476.148 538.482 475.779 539.774L477.339 539.996C477.505 539.511 477.976 539.096 478.793 539.096C479.569 539.096 479.993 539.493 479.993 540.19V540.217C479.993 540.697 479.49 540.721 478.239 540.854C476.863 541.002 475.548 541.413 475.548 543.01C475.548 544.404 476.568 545.143 477.921 545.143ZM478.355 543.915C477.657 543.915 477.159 543.597 477.159 542.983C477.159 542.341 477.718 542.073 478.465 541.967C478.904 541.907 479.781 541.796 479.998 541.621V542.456C479.998 543.246 479.361 543.915 478.355 543.915ZM486.438 545.138C488.22 545.138 489.356 544.081 489.476 542.576H487.878C487.735 543.338 487.186 543.777 486.452 543.777C485.409 543.777 484.735 542.904 484.735 541.455C484.735 540.023 485.422 539.165 486.452 539.165C487.255 539.165 487.749 539.682 487.878 540.365H489.476C489.36 538.828 488.16 537.817 486.429 537.817C484.351 537.817 483.04 539.317 483.04 541.482C483.04 543.629 484.319 545.138 486.438 545.138ZM490.922 545H492.565V543.883H492.662C492.925 544.4 493.475 545.125 494.693 545.125C496.365 545.125 497.616 543.8 497.616 541.464C497.616 539.1 496.328 537.817 494.689 537.817C493.438 537.817 492.916 538.569 492.662 539.082H492.593V535.545H490.922V545ZM492.561 541.455C492.561 540.079 493.152 539.188 494.227 539.188C495.34 539.188 495.912 540.134 495.912 541.455C495.912 542.784 495.331 543.754 494.227 543.754C493.161 543.754 492.561 542.83 492.561 541.455ZM502.129 545.138C504.207 545.138 505.527 543.675 505.527 541.482C505.527 539.285 504.207 537.817 502.129 537.817C500.052 537.817 498.732 539.285 498.732 541.482C498.732 543.675 500.052 545.138 502.129 545.138ZM502.139 543.8C500.989 543.8 500.426 542.775 500.426 541.478C500.426 540.18 500.989 539.142 502.139 539.142C503.27 539.142 503.833 540.18 503.833 541.478C503.833 542.775 503.27 543.8 502.139 543.8ZM510.039 545.138C512.116 545.138 513.436 543.675 513.436 541.482C513.436 539.285 512.116 537.817 510.039 537.817C507.961 537.817 506.641 539.285 506.641 541.482C506.641 543.675 507.961 545.138 510.039 545.138ZM510.048 543.8C508.898 543.8 508.335 542.775 508.335 541.478C508.335 540.18 508.898 539.142 510.048 539.142C511.179 539.142 511.742 540.18 511.742 541.478C511.742 542.775 511.179 543.8 510.048 543.8ZM514.855 545H516.526V542.618L517.135 541.967L519.305 545H521.304L518.396 540.97L521.142 537.909H519.19L516.641 540.757H516.526V535.545H514.855V545ZM525.555 545H527.267V541.805H529.077C531.261 541.805 532.433 540.494 532.433 538.675C532.433 536.87 531.274 535.545 529.1 535.545H525.555V545ZM527.267 540.397V536.977H528.837C530.12 536.977 530.688 537.669 530.688 538.675C530.688 539.682 530.12 540.397 528.846 540.397H527.267ZM533.847 545H535.518V540.831C535.518 539.931 536.197 539.294 537.115 539.294C537.397 539.294 537.748 539.345 537.891 539.391V537.854C537.739 537.826 537.475 537.808 537.291 537.808C536.478 537.808 535.8 538.269 535.541 539.091H535.467V537.909H533.847V545ZM541.802 545.138C543.88 545.138 545.2 543.675 545.2 541.482C545.2 539.285 543.88 537.817 541.802 537.817C539.725 537.817 538.405 539.285 538.405 541.482C538.405 543.675 539.725 545.138 541.802 545.138ZM541.812 543.8C540.662 543.8 540.099 542.775 540.099 541.478C540.099 540.18 540.662 539.142 541.812 539.142C542.943 539.142 543.506 540.18 543.506 541.478C543.506 542.775 542.943 543.8 541.812 543.8Z" fill="#A0AEC0"/>
                            <path d="M0 552C0 550.895 0.895431 550 2 550H1006C1007.1 550 1008 550.895 1008 552V568H0V552Z" fill="#A3ACB1"/>
                            <path d="M0 552C0 550.895 0.895431 550 2 550H1006C1007.1 550 1008 550.895 1008 552V568H0V552Z" fill="url(#paint0_linear_4_49)"/>
                            <path d="M0 568H1008L987.646 572.105C961.613 577.355 935.123 580 908.566 580H97.9089C68.724 580 39.6267 576.806 11.1367 570.475L0 568Z" fill="#647279"/>
                            <path d="M0 568H1008L987.646 572.105C961.613 577.355 935.123 580 908.566 580H97.9089C68.724 580 39.6267 576.806 11.1367 570.475L0 568Z" fill="url(#paint1_linear_4_49)"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M421.033 550C421.547 557.818 428.052 564 436 564H573C580.948 564 587.453 557.818 587.967 550H421.033Z" fill="#96A1A8"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M421.033 550C421.547 557.818 428.052 564 436 564H573C580.948 564 587.453 557.818 587.967 550H421.033Z" fill="url(#paint2_linear_4_49)"/>
                            <defs>
                                <filter id="filter0_f_4_49" x="8" y="537" width="993" height="98" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                    <feGaussianBlur stdDeviation="22" result="effect1_foregroundBlur_4_49"/>
                                </filter>
                                <linearGradient id="paint0_linear_4_49" x1="-1.94452e-10" y1="559" x2="1008" y2="559" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#0D1012"/>
                                    <stop offset="0.0295345" stop-color="#CAD4DB"/>
                                    <stop offset="0.0625" stop-color="#242729"/>
                                    <stop offset="0.133609" stop-color="#A3ACB1"/>
                                    <stop offset="0.865967" stop-color="#A3ACB1"/>
                                    <stop offset="0.941937" stop-color="#242729"/>
                                    <stop offset="0.971275" stop-color="#CAD4DB"/>
                                    <stop offset="0.996436" stop-color="#0D1012"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear_4_49" x1="504" y1="568" x2="504" y2="580" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7A7F83"/>
                                    <stop offset="1" stop-color="#0B0B0E"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear_4_49" x1="437.5" y1="558.5" x2="574.5" y2="558.5" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3C3C3C"/>
                                    <stop offset="0.317518" stop-color="#3C3C3C" stop-opacity="0"/>
                                    <stop offset="0.660584" stop-color="#3C3C3C" stop-opacity="0"/>
                                    <stop offset="1" stop-color="#444444"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <Button :href="route('register')" class="mt-10" color="primary" radius="full" size="lg" text-size="lg">
                        Присоединиться
                    </Button>
                </div>
            </div>
        </section>

        <Modal title="Намного о нашем сервисе" max-width="2xl" :show="showModal" @close="showModal = !showModal">
            <template v-if="showModal">
                <VKVideoPlayer class="w-full" src="https://vk.com/video_ext.php?oid=-215374743&id=456239178&hd=2&js_api=1"/>
            </template>
        </Modal>

        <section class="relative steps">
            <div class="container py-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div>
                        <div class="text-2xl font-serif font-semibold theme-gradient text-transparent bg-clip-text mb-4">Все должно быть просто</div>
                        <h2 class="font-serif font-semibold text-2xl md:text-4xl mb-4">Интуитивно понятный интерфейс</h2>
                        <p class="text-lg mb-6">Для того что бы начать пользоваться нашим сервисом вам нужно выполнить всего лишь 3 простых шага.</p>
                        <div class="flex flex-col space-y-5">
                            <div class="flex items-center space-x-4" v-for="(step , index) in arSteps" :key="index">
                                <div class="flex items-center justify-center theme-gradient rounded-xl text-xl font-serif font-bold size-10 shrink-0">
                                    {{ index + 1 }}
                                </div>
                                <p class="text-xl font-serif">{{ step }}</p>
                            </div>
                        </div>
                        <Button color="primary" size="lg" text-size="lg" radius="full" :href="route('register')" class="mt-6">
                            Попробовать
                        </Button>
                    </div>

                    <div class="box rounded-xl shadow-md self-start">
                        <form @submit.prevent="submit" class="space-y-4 p-4 sm:p-6 duration-300">
                            <div>
                                <InputLabel>Заголовок трансляций: максимум 50-55 символов</InputLabel>
                                <TextInput type="text" required maxlength="55" class="mt-1 block w-full" placeholder="Название трансляции" />
                            </div>
                            <div>
                                <InputLabel>Описание трансляции: максимум 100-120 символов</InputLabel>
                                <TextArea type="text" maxlength="120" class="mt-1 block w-full" placeholder="Описание трансляции"/>
                            </div>
                            <fieldset>
                                <span class="font-medium">Настройка запуска трансляции</span>
                                <div class="flex gap-4 flex-wrap mt-2">
                                    <label class="box shrink-0 py-2 px-4 has-[:checked]:bg-primary-700 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow cursor-pointer">
                                        Сразу
                                        <input class="sr-only" type="radio" name="showDatePicker" v-model="testForm.start_immediately" :value="true">
                                    </label>
                                    <label class="box shrink-0 py-2 px-4 has-[:checked]:bg-primary-700 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow cursor-pointer">
                                        По дате
                                        <input class="sr-only" type="radio" name="showDatePicker" v-model="testForm.start_immediately" :value="false">
                                    </label>
                                    <label v-if="!testForm.start_immediately" class="flex flex-col grow">
                                        <TextInput type="datetime-local" :min="new Date().toISOString().slice(0, 16)" placeholder="Введите время"/>
                                    </label>
                                </div>
                            </fieldset>
                            <fieldset class="flex flex-col">
                                <span class="font-medium">Выберите интервал автоповтора трансляций</span>
                                <div class="grid grid-cols-4 gap-2 mt-2">
                                    <label v-for="item in intervals" class="text-white text-sm p-2 text-center border border-white/50 rounded-xl cursor-pointer duration-300 hover:bg-primary-800 has-[:checked]:theme-gradient has-[:checked]:animate-gradient-glow">
                                        <span class="shrink-0">{{ item.label }}</span>
                                        <input name="repeat_interval" :value="item.value" v-model="testForm.repeat_interval" type="radio" class="sr-only">
                                    </label>
                                </div>
                            </fieldset>
                            <Button type="submit" color="primary" class="w-full" text-size="lg">
                                Запуск трансляции
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="interview">
            <div class="container py-12">
                <h2 class="font-serif font-semibold text-2xl md:text-4xl mb-12 text-center text-white">
                    <span class="theme-gradient-text">Доверяй</span> свой бизнес профессионалам
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="rounded-2xl overflow-hidden box aspect-video">
                        <VKVideoPlayer src="https://vk.com/video_ext.php?oid=-215374743&id=456239209&hd=2"/>
                    </div>
                    <div class="flex flex-col justify-center lg:items-end lg:text-end">
                        <div class="flex flex-col space-y-5">
                            <p class="text-xl font-serif" :key="index"
                               v-for="(interview , index) in [
                                   'Интервью с сооснователем сервиса.',
                                   'Ответы на самые важные вопросы.',
                                   'RU:STREAM от идеи до реализации.',
                                   'Единственный в стране и мире.'
                               ]">
                                {{ interview }}
                            </p>
                        </div>
                        <Button :href="route('register')" text-size="lg" size="lg" radius="full" class="max-lg:self-start mt-6">
                            Попробовать
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative">
            <div class="container py-12">
                <h2 class="font-serif font-semibold text-4xl mb-12 text-center text-white">
                    <span class="theme-gradient-text">Вопросы</span> и ответы
                </h2>
                <div class="flex flex-col space-y-6">
                    <details class="group box overflow-hidden" v-for="(item , index) in arFaq" :key="index">
                        <summary class="flex items-center p-4 duration-300 hover:bg-white/20 cursor-pointer select-none rounded-t-2xl">
                            <img width="50px" height="50px" class="size-12 object-contain" :src="item.icon" alt="">
                            <span class="font-semibold font-serif ml-4">{{ item.title }}</span>
                            <PhCaretDown class="size-6 mx-4 ml-auto duration-75 group-open:rotate-180"/>
                        </summary>
                        <div class="max-w-none prose prose-invert prose-p:mt-0 prose-p:mb-1 p-6 border-t border-white/20" v-html="item.text"></div>
                    </details>
                </div>
            </div>
        </section>

        <section class="reviews">
            <div class="container py-12">
                <h2 class="font-serif font-semibold text-4xl mb-12 text-center text-white">
                    <span class="theme-gradient-text">Кейсы</span> наших клиентов
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <CaseItem v-for="caseItem in cases" :key="caseItem.id" :item="caseItem"/>
                </div>
            </div>
        </section>

    </GuestLayout>
</template>

<style scoped>

</style>
