<script setup>
import {useForm} from "@inertiajs/vue3";
import {intervals} from "@/Utils/intervals.js";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import Button from "@/Components/Actions/Button.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import CustomSelect from "@/Components/Form/CustomSelect.vue";
import SelectDefault from "@/Components/Form/SelectDefault.vue";
import {computed} from "vue";

const props = defineProps({
    modelValue: Object
})

const emit = defineEmits(['update:modelValue'])
const options = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})

const actions = [
    { label: "По-умолчанию", value: null },
    { label: "В магазин", value: "to_store" },
    { label: "Голосовать", value: "vote" },
    { label: "Ещё", value: "more" },
    { label: "Забронировать", value: "book" },
    { label: "Заказать", value: "order" },
    { label: "Записаться", value: "enroll" },
    { label: "Заполнить", value: "fill" },
    { label: "Зарегистрироваться", value: "signup" },
    { label: "Купить", value: "buy" },
    { label: "Купить билет", value: "ticket" },
    { label: "Написать", value: "write" },
    { label: "Открыть", value: "open" },
    { label: "Подробнее", value: "learn_more" },
    { label: "Посмотреть", value: "view" },
    { label: "Перейти", value: "go_to" },
    { label: "Связаться", value: "contact" },
    { label: "Смотреть", value: "watch" },
    { label: "Слушать", value: "play" },
    { label: "Установить", value: "install" },
    { label: "Читать", value: "read" }
];
</script>

<template>
    <div>
        <InputLabel>Ссылка</InputLabel>
        <TextInput v-model="options.link_url" type="text" class="mt-1 block w-full" placeholder="https://vk.com/..." />
    </div>
    <div v-if="options.link_url">
        <InputLabel>Текст ссылки</InputLabel>
        <SelectDefault v-model="options.link_text" class="w-full mt-1" :options="actions" label="Выберите действие"/>
    </div>
</template>

<style scoped>

</style>
