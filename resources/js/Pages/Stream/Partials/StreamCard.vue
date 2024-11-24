<script setup>
import VideoPlayer from "@/Components/Common/VideoPlayer.vue";
import Button from "@/Components/Actions/Button.vue";
import {router} from "@inertiajs/vue3";
import {
    PhArrowUUpRight,
    PhChatDots,
    PhEye,
    PhFilmStrip,
    PhHeart,
    PhPlay,
    PhRepeat, PhSkipForward,
    PhVideoCamera
} from "@phosphor-icons/vue";
import {computed, ref} from "vue";
import {intervals} from "@/Utils/intervals.js";

const props = defineProps({
    stream: Object
})

const isLocked = ref(false)

const isOnline = computed(() => {
    const { is_active, expires_at } = props.stream;
    if (!is_active || !expires_at) {
        return false;
    }

    return new Date() < new Date(expires_at);
});

const attributes = computed(() => {
    const { is_active, start_at, next_at, play_count, stats, repeat_interval } = props.stream;
    const startAt = start_at && new Date(start_at);
    const nextAt = next_at && new Date(next_at);

    const baseAttributes = [
        {
            title: 'Активность',
            content: is_active ? 'Вкл.' : 'Выкл.',
            icon: PhVideoCamera
        },
        {
            title: 'Цикл',
            content: intervals.find(interval => interval.value === repeat_interval).label,
            icon: PhRepeat
        }
    ];

    if (!nextAt && startAt > new Date()) {
        baseAttributes.push({
            title: 'Начало',
            content: startAt.toLocaleString(),
            icon: PhPlay
        });
    } else if (nextAt) {
        baseAttributes.push(
            {
                title: 'Следующий запуск',
                content: nextAt.toLocaleString(),
                icon: PhSkipForward
            },
            {
                title: 'Всего запусков',
                content: play_count,
                icon: PhFilmStrip
            }
        );
    }

    if (stats) {
        ['views', 'likes', 'reposts', 'comments'].forEach((stat) => {
            if (stats[stat] !== undefined) {
                baseAttributes.push({
                    title: {
                        views: 'Просмотры',
                        likes: 'Лайки',
                        reposts: 'Репосты',
                        comments: 'Комментарии'
                    }[stat],
                    content: stats[stat],
                    icon: {
                        views: PhEye,
                        likes: PhHeart,
                        reposts: PhArrowUUpRight,
                        comments: PhChatDots
                    }[stat]
                });
            }
        });
    }

    return baseAttributes;
});


const executeAction = (method, routeName) => {
    isLocked.value = true;
    router[method](route(routeName, props.stream.id), {}, {
        preserveScroll: true,
        onFinish: () => (isLocked.value = false)
    });
};

const play = () => executeAction('post', 'streams.play');
const stop = () => executeAction('post', 'streams.stop');
const remove = () => executeAction('delete', 'streams.destroy');

const video = computed(() => {
    return props.stream.is_story ? props.stream.story : props.stream.video;
})
</script>

<template>
    <div :class="[isLocked ? 'opacity-50 pointer-events-none scale-95': '' ,'box overflow-hidden border-2 duration-150']">
        <VideoPlayer :src="video.video_url" :poster="video.poster_url"/>
        <div class="flex items-center justify-between border-b border-white/20 px-4 py-2">
            <div>
                <h3 class="text-lg font-serif font-bold line-clamp-1">{{ stream.title }}</h3>
                <p v-if="stream.description" class="text-start">{{ stream.description }}</p>
            </div>
            <span class="relative flex size-4">
                <span v-if="isOnline" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span :class="[isOnline ? 'bg-green-500' : 'bg-red-800', 'relative inline-flex rounded-full size-4']"></span>
            </span>
        </div>

        <dl class="border-white/20 px-4 pt-4 space-y-4">
            <div class="flex justify-between" v-for="item in attributes">
                <dt class="flex font-medium space-x-3">
                    <component :is="item.icon" class="size-6"/>
                    <span>{{ item.title }}</span>
                </dt>
                <dd class="font-bold">
                    {{ item.content }}
                </dd>
            </div>
        </dl>

        <div class="grid grid-cols-2 gap-4 p-4">
            <Button v-if="stream.is_active" type="button" @click="stop" color="warning" class="col-span-2">
                <span class="drop-shadow">Остановить</span>
            </Button>
            <template v-else>
                <Button type="button" @click="play" color="success">
                    <span class="drop-shadow">Запустить</span>
                </Button>
                <Button type="button" @click="remove" color="danger">
                    <span class="drop-shadow">Удалить</span>
                </Button>
            </template>
            <!--            <button class="col-span-2 btn btn-primary">-->
            <!--                <span class="drop-shadow">Подробнее о трансляции</span>-->
            <!--            </button>-->
        </div>
    </div>
</template>

<style scoped>

</style>
