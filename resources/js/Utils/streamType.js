export const streamType = {
    'vk-page' : {
        name: 'Страница ВКонтакте',
        handler: 'vk-page',
        icon: 'vk-page',
        link: '/streams/vk-page',
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
        labels: {
            accounts: 'Групп',
            streams: 'Стримов',
        }
    },
    'youtube' : {
        name: 'Youtube',
        handler: 'youtube',
        icon: 'youtube',
        link: '/streams/youtube',
        labels: {
            accounts: 'Каналов',
            streams: 'Стримов',
        }
    },

    'telegram' : {
        name: 'Telegram',
        handler: 'telegram',
        icon: 'telegram',
        link: '/streams/telegram',
        labels: {
            accounts: 'Аккаунтов',
            streams: 'Стримов',
        }
    },
}
