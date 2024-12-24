import VKStories from "@/Pages/Stream/Create/VKStories.vue";
import VKPage from "@/Pages/Stream/Create/VKPage.vue";
import VKGroup from "@/Pages/Stream/Create/VKGroup.vue";

export const streamType = {
    'vk-page' : {
        name: 'Страница ВКонтакте',
        handler: 'vk-page',
        icon: 'vk-page',
        link: '/streams/vk-page',
        creatorComponent: VKPage,
        labels: {
            accounts: 'Аккаунтов',
            streams: 'Стримов',
        }
    },
    // По тому же принципу сделать
    'vk-stories' : {
        name: 'Истории ВКонтакте',
        handler: 'vk-stories',
        icon: 'vk-stories',
        link: '/streams/vk-stories',
        creatorComponent: VKStories,
        labels: {
            accounts: 'Аккаунтов',
            streams: 'Историй',
        }
    },

    'vk-group' : {
        name: 'Группа ВКонтакте',
        handler: 'vk-group',
        icon: 'vk-group',
        link: '/streams/vk-group',
        creatorComponent: VKGroup,
        labels: {
            accounts: 'Групп',
            streams: 'Стримов',
        }
    },

    'telegram' : {
        name: 'Группа Telegram',
        handler: 'telegram',
        icon: 'telegram',
        link: '/streams/telegram',
        labels: {
            accounts: 'Аккаунтов',
            streams: 'Стримов',
        }
    },
    // 'telegram-stories' : {
    //     name: 'Истории Telegram',
    //     handler: 'telegram-stories',
    //     icon: 'telegram',
    //     link: '/streams/telegram-stories',
    //     labels: {
    //         accounts: 'Аккаунтов',
    //         streams: 'Стримов',
    //     }
    // },
}
