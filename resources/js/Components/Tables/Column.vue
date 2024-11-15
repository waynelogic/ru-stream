<script setup>
const props = defineProps({
    index: Number,
    column: Object,
    item: Object
})
</script>

<template>
    <td  class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
        <div class="text-gray-900">{{ item[column.value] }}</div>
        <div v-if="column.description" class="mt-1 text-gray-500">{{ item[column.description] }}</div>
    </td>
</template>

<style scoped>

</style>
