<template>
    <table class="min-w-full divide-y divide-white/20">
        <thead class="bg-primary-900">
            <tr>
                <th v-for="(column, index) in internalColumns" :key="index"
                    :class="[ 'py-3.5 px-3 text-left text-sm font-semibold']">
                    {{ column.label }}
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/20">
            <tr v-if="rows.length"  v-for="(row, rowIndex) in rows" :key="rowIndex">
                <td v-for="(column, colIndex) in internalColumns" :key="colIndex"
                :class="td({ padding: colIndex === 0 ? 'left' : colIndex === internalColumns.length - 1 ? 'right' : 'center' })">
                    <component :is="column.component" :row="row" v-bind="column.props" />
                </td>
            </tr>
            <tr v-else>
                <td colspan="100%" class="text-center text-gray-500 py-4">Нет данных</td>
            </tr>

        </tbody>
    </table>
</template>

<script setup>
import { computed } from 'vue';
import { useSlots } from 'vue';
import {tv} from "tailwind-variants";

// Принимаем props в script setup
const props = defineProps({
    columns: {
        type: Array,
        default: () => [],
    },
    rows: {
        type: Array,
        required: true,
    },
});

// Получаем доступ к слотам
const slots = useSlots();

// Определяем вычисляемое свойство internalColumns
const internalColumns = computed(() => {
    // Объединяем переданные через props колонки и переданные через слоты
    return slots.default
        ? slots.default().map((slotVNode) => {
            // Извлекаем label, а остальные свойства сохраняем в newProps
            const { label, ...newProps } = slotVNode.props || {};

            return {
                component: slotVNode.type,
                label: label || slotVNode.props.value,
                props: newProps,
            };
        })
        : props.columns;
});

const td = tv({
    base: 'whitespace-nowrap text-sm',
    variants: {
        padding: {
            left: 'py-5 pl-4 pr-3',
            center: 'px-3 py-5',
            right: 'py-5 pl-3 pr-4 sm:pr-0'
        }
    }
})
</script>
