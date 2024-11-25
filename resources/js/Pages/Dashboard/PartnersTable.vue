<script setup>
import TextColumn from "@/Components/Tables/TextColumn.vue";
import DefaultTable from "@/Components/Tables/DefaultTable.vue";
import {PhCopySimple} from "@phosphor-icons/vue";
import {computed} from "vue";
import Button from "@/Components/Actions/Button.vue";
import {useFlash} from "@/Utils/useFlash.js";
const props = defineProps({
    user: Object,
    items: Object
})

const link = computed(() => props.user.referral_link);

function copyLink() {
    navigator.clipboard.writeText(link.value);
    useFlash().success('Ссылка скопирована в буфер обмена');
}
</script>

<template>
    <div class="box overflow-hidden bg-primary-950/50 min-w-full align-middle">
        <DefaultTable :rows="items" empty-message="Вы ещё никого не пригласили!">
            <TextColumn column="name" label="Партнер"/>
            <TextColumn column="email" label="E-mail"/>
            <TextColumn column="funds" label="Баланс" money/>
            <TextColumn column="created_at" label="Роль" date/>
        </DefaultTable>
        <div class="w-full border-t border-white/20 bg-primary-950">
            <span class="block px-5 text-base border-b border-white/20 p-2 font-semibold">Ваша <span class="theme-gradient-text">реферальная ссылка:</span></span>
            <div class="flex items-center p-2">
                <span class="w-full p-2 font-bold whitespace-nowrap overflow-hidden">{{ link }}</span>
                <Button size="square" @click="copyLink" class="self-center">
                    <PhCopySimple weight="bold"/>
                </Button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
