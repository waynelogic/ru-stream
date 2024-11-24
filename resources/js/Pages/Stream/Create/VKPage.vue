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
const form = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})
</script>

<template>
    <div>
        <InputLabel>Описание трансляции: максимум 100-120 символов</InputLabel>
        <TextArea v-model="form.description" type="text" maxlength="120" class="mt-1 block w-full" placeholder="Описание трансляции"/>
    </div>
</template>

<style scoped>

</style>
