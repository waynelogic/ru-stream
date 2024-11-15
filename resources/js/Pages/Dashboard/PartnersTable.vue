<script setup>
import {useStore} from "vuex";
import {PhCopySimple} from "@phosphor-icons/vue";
import {onMounted, ref} from "vue";

const store = useStore();
const props = defineProps({
    login: String,
    items: Object
})

const isCopied = ref(false)

const link = ref(null)

onMounted(() => {
    link.value = `${window.location.origin}?ref=${props.login}`;
})

function copyLink() {
    navigator.clipboard.writeText(link.value);
    store.commit('addFlashMessage', {
        message: 'Ссылка скопирована в буфер обмена',
        type: 'info'
    })
}
</script>

<template>
    <div class="box text-sm">
        <table class="w-full ">
            <thead>
                <tr class="border-b border-white/20 bg-primary-900/50">
                    <th class="p-2" scope="col" v-for="(name, index) in ['Партнер', 'E-mail', 'Дата регистрации']" :key="index">
                        {{ name }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <template v-if="!items || !items.length">
                    <tr class="border-b border-white/20">
                        <td class="p-4 text-center" colspan="3">
                            Вы ещё никого не пригласили!
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr class="border-b border-white/20 last:border-0" v-for="(item, index) in items" :key="index">
                        <th scope="row" class="p-4 text-left align-middle">
                            <div class="flex items-center">
                                <img class="size-8 rounded-full mr-4" :src="item.profile_photo_url" alt=""/>
                                <span class="whitespace-nowrap">{{ item.name }}</span>
                            </div>
                        </th>
                        <td class="p-4 text-center align-middle">
                            <span class="whitespace-nowrap">{{ item.email }}</span>
                        </td>
                        <td class="p-4 text-right align-middle">
                            {{ new Date(item.created_at).toLocaleDateString() }}
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    <div class="w-full border border-white/20 bg-primary-950 rounded-xl mt-6">
        <span class="block px-5 text-base border-b border-white/20 p-2 font-semibold">Ваша <span class="theme-gradient-text">реферальная ссылка:</span></span>
        <div class="flex items-center p-2">
            <span class="w-full p-2 font-bold whitespace-nowrap overflow-hidden">{{ link }}</span>
            <button @click="copyLink" class="self-center btn btn-primary p-3">
                <ph-copy-simple weight="bold"/>
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
