<script setup>
import { ref, computed } from 'vue';
import {PhCaretDown, PhCheck} from "@phosphor-icons/vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null,
    },
    options: {
        type: Array,
        required: true,
        // Example format for options: [{ value: 'option1', label: 'Option 1' }]
    },
    placeholder: {
        type: String,
        default: '-',
    },
})
const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};
const selectOption = (value) => {
    emit('update:modelValue', value);
    isOpen.value = false;
};

const selectedOption = computed(() => {
    const selectedOption = props.options.find(
        (option) => option.value === props.modelValue
    );
    return selectedOption ? selectedOption : {
        value: null,
        label: props.placeholder
    };
});
</script>

<template>


    <div>
        <select class="sr-only">
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
                :selected="option.value === modelValue"
            >
                {{ option.label }}
            </option>
        </select>

        <div class="group relative">
            <div class="inline-block w-full rounded-md shadow-sm">
                <button type="button" @click="toggleDropdown" class="relative w-full rounded-md box text-white pl-3 pr-10 py-3 text-left focus:outline-none focus:shadow-outline-blue focus:border-primary-800 transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <span class="flex items-center space-x-3">
                        <img v-if="selectedOption.icon" :src="selectedOption.icon" :alt="selectedOption.label" class="flex-shrink-0 h-6 w-6 rounded-full ">
                        <span class="block truncate font-serif font-semibold">{{ selectedOption.label }}</span>
                    </span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <PhCaretDown :class="{ 'rotate-180': isOpen }" weight="bold" class="duration-75 size-5"/>
                    </span>
                </button>
            </div>
            <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0 translate-y-2">
                <div v-if="isOpen" class="absolute mt-1 w-full rounded-md bg-primary-900 shadow-lg overflow-hidden">
                    <ul class="max-h-56 rounded-md text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5" role="listbox">
                        <li v-for="option in options" :key="option.value"  @click="selectOption(option.value)" role="option"
                            :class="{ 'bg-primary-900/50': option.value === modelValue }"
                            :tabindex="isOpen ? 0 : -1"
                            @keydown.enter="selectOption(option.value)"
                            class="text-white cursor-default select-none relative py-2 pl-4 pr-9 hover:bg-primary-500">
                            <div class="flex items-center space-x-3">
                                <img :src="option.icon" alt="" class="flex-shrink-0 h-6 w-6 rounded-full">
                                <span class="font-serif font-semibold block truncate">{{ option.label }}</span>
                            </div>
                            <span v-if="option.value === modelValue" class="absolute inset-y-0 right-0 flex items-center pr-4 text-white">
                                <PhCheck weight="bold" class="size-5"/>
                            </span>
                        </li>
                    </ul>
                </div>
            </transition>
        </div>
    </div>
<!--    <div class="custom-select" v-click-outside="">-->
<!--        <div-->
<!--            class="box rounded-md p-2 select-display"-->
<!--            @click="toggleDropdown"-->
<!--        >-->
<!--            {{ selectedLabel }}-->
<!--        </div>-->
<!--        <div-->
<!--            v-if="isOpen"-->
<!--            class="select-options"-->
<!--        >-->
<!--            <div-->
<!--                v-for="option in options"-->
<!--                :key="option.value"-->
<!--                class="select-option"-->
<!--                :class="{ 'selected': option.value === modelValue }"-->
<!--                @click="selectOption(option.value)"-->
<!--            >-->
<!--                {{ option.label }}-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>

<style scoped>

</style>
