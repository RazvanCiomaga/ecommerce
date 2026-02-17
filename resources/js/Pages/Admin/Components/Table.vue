<script setup>
import Pagination from "@/Components/Pagination.vue";

defineProps({
    headers: {
        type: Array,
        required: true
    },
    items: {
        type: Array,
        required: true
    },
    pagination: {
        type: Object,
        required: false
    }
})
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="header in headers" :key="header.key" scope="col" class="px-4 py-3">
                        {{ header.label }}
                    </th>
                    <th v-if="$slots.actions" scope="col" class="px-4 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id" class="border-b dark:border-gray-700">
                    <td v-for="header in headers" :key="header.key" class="px-4 py-3">
                        <slot :name="`cell-${header.key}`" :item="item">
                            {{ item[header.key] }}
                        </slot>
                    </td>
                    <td v-if="$slots.actions" class="px-4 py-3 flex items-center justify-end">
                        <slot name="actions" :item="item"></slot>
                    </td>
                </tr>
                <tr v-if="items.length === 0">
                    <td :colspan="headers.length + ($slots.actions ? 1 : 0)" class="px-4 py-3 text-center">
                        No items found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="pagination" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.from }}-{{ pagination.to }}</span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</span>
        </span>
        <Pagination :pagination="pagination" />
    </div>
</template>
