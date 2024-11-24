<script setup lang="ts">
import Swiper from 'swiper';
import {nextTick, onMounted, ref, useSlots, watch} from "vue";
import {Navigation, Pagination} from "swiper/modules";


const props = defineProps({
    options: {
        type: Object,
        default: () => ({})
    },
    defaultNavigation: {
        type: Boolean,
        default: true
    }
})
const swiperEl = ref(null)
const swiper = ref(null)

function initSwiper() {
    const defOptions = {
        slidesPerView: 2,
        modules: [Navigation, Pagination],
    }

    swiper.value = new Swiper(swiperEl.value, {...defOptions, ...props.options})
    swiper.value.init()
}

onMounted(() => {
    initSwiper()
})

const slots = useSlots()

watch(() => slots.default(), async (value, oldValue) => {
    if (value[0].children.length !== oldValue[0].children.length) {
        swiper.value.destroy();
        await nextTick();
        initSwiper();
    }
});

</script>

<template>
    <div class="swiper" ref="swiperEl">
        <slot name="before" />
        <div class="swiper-wrapper">
            <slot />
        </div>
        <slot name="after" />
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <template v-if="defaultNavigation">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </template>
    </div>
</template>

<style scoped>

</style>
