<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {streamType} from "@/Utils/streamType.js";
import PricingPlan from "@/Components/PricingPlan.vue";
import {computed, ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    pricingPlans: Object
})


const subscriptions = computed(() => usePage().props.subscriptions)

function getCurrentPlan(planType) {
    return subscriptions.value.find(plan => plan.type === planType)
}

const frequencies = [
    { value: 'monthly', label: 'Месяц', priceSuffix: '/мес.' },
    { value: 'annually', label: 'Год', priceSuffix: '/год' },
];
const frequency = ref(frequencies[0])

function getPricingPlans(type) {
    return props.pricingPlans.filter(plan => plan.type === type)
}
</script>

<template>
    <GuestLayout title="Подписки" :breadcrumbs="[ { title: 'Главная', url: route('home') }, { title: 'Тарифы', url: $page.url }, ]">
        <section class="py-12">
            <!-- Pricing section -->
            <div class="mx-auto max-w-7xl">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="text-base font-semibold leading-7 text-indigo-400">Подписки</h1>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl">Тарифные планы</p>
                </div>
                <!--                <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-300">Выберите доступный план, который оснащен лучшими функциями для привлечения вашей аудитории, повышения лояльности клиентов и увеличения продаж.</p>-->
                <div class="mt-8 flex justify-center">
                    <fieldset aria-label="Payment frequency">
                        <div class="grid grid-cols-2 gap-x-1 rounded-full bg-white/10 p-2 text-center text-sm font-serif font-semibold leading-5 text-white">
                            <label class="cursor-pointer rounded-full px-4 py-2 has-[:checked]:bg-indigo-500" v-for="option in frequencies" :key="option.value">
                                <span class="drop-shadow">{{ option.label }}</span>
                                <input type="radio" name="frequency" :value="option" v-model="frequency" class="sr-only">
                            </label>
                        </div>
                    </fieldset>
                </div>
                <div class="flex flex-col gap-6 mt-6" v-for="(group, index) in streamType" :key="group">
                    <h2 class="font-serif font-semibold text-2xl text-white"><span class="text-indigo-500">{{ group.name }}</span></h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-8">
                        <PricingPlan v-for="plan in getPricingPlans(group.handler)" :key="plan.id" :plan="plan" :type="group" :frequency="frequency" :current-type-plan="getCurrentPlan(group.handler)"/>
                    </div>
                </div>
            </div>

            <!-- Testimonial section -->
            <div class="mx-auto max-w-7xl px-6 pt-10 lg:px-8">
                <div class="mx-auto grid max-w-2xl grid-cols-1 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                    <div class="flex flex-col pb-10 sm:pb-16 lg:pb-0 lg:pr-8 xl:pr-20">
                        <img class="h-12 self-start" src="https://tailwindui.com/img/logos/tuple-logo-white.svg" alt="" />
                        <figure class="mt-10 flex flex-auto flex-col justify-between">
                            <blockquote class="text-lg leading-8 text-white">
                                <p>“Amet amet eget scelerisque tellus sit neque faucibus non eleifend. Integer eu praesent at a. Ornare arcu gravida natoque erat et cursus tortor consequat at. Vulputate gravida sociis enim nullam ultricies habitant malesuada lorem ac. Tincidunt urna dui pellentesque sagittis.”</p>
                            </blockquote>
                            <figcaption class="mt-10 flex items-center gap-x-6">
                                <img class="h-14 w-14 rounded-full bg-gray-800" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                <div class="text-base">
                                    <div class="font-semibold text-white">Judith Black</div>
                                    <div class="mt-1 text-gray-400">CEO of Tuple</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="flex flex-col border-t border-white/10 pt-10 sm:pt-16 lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0 xl:pl-20">
                        <img class="h-12 self-start" src="https://tailwindui.com/img/logos/reform-logo-white.svg" alt="" />
                        <figure class="mt-10 flex flex-auto flex-col justify-between">
                            <blockquote class="text-lg leading-8 text-white">
                                <p>“Excepteur veniam labore ullamco eiusmod. Pariatur consequat proident duis dolore nulla veniam reprehenderit nisi officia voluptate incididunt exercitation exercitation elit. Nostrud veniam sint dolor nisi ullamco.”</p>
                            </blockquote>
                            <figcaption class="mt-10 flex items-center gap-x-6">
                                <img class="h-14 w-14 rounded-full bg-gray-800" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                <div class="text-base">
                                    <div class="font-semibold text-white">Joseph Rodriguez</div>
                                    <div class="mt-1 text-gray-400">CEO of Reform</div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
