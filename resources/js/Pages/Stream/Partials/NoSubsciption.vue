<script setup>
import Button from "@/Components/Actions/Button.vue";
const props = defineProps({
    type: String
})
</script>

<template>
    <section class="flex flex-col items-center justify-center size-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="flex flex-col items-center justify-center">
                <h1 class="mb-4 font-bold text-2xl">Вы еще не приобрели подписку на данный тип трансляций.</h1>
                <p class="mb-6">
                    Перейдите в раздел "Подписки" и выберите подходящую подписку.
                </p>
                <Button :href="route('plans.index') + '#' + type">
                    <span class="ml-2">Подписаться</span>
                </Button>
            </div>
            <div>
                <img src="/images/common/disconnec.png" alt="Нет подписки"/>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
