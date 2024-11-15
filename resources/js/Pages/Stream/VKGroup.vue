<script setup>
import DefaultTable from "@/Components/Tables/DefaultTable.vue";
import TextColumn from "@/Components/Tables/TextColumn.vue";

const items  = [
    { name: "Item 1", description: "Description 1", price: 100, date: "2023-01-01" },
    { name: "Item 2", description: "Description 2", price: 200, date: "2023-02-01" },
];
</script>

<template>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <DefaultTable :rows="items">
                    <TextColumn column="name" label="Название"/>
                    <TextColumn column="description" label="Описание"/>
                    <TextColumn column="price" label="Цена" money/>
                    <TextColumn column="date" label="Дата" date/>
                </DefaultTable>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
