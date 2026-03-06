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
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-200">
                <tr>
                    <th v-for="header in headers" :key="header.key" scope="col" class="px-6 py-4 font-medium tracking-wider">
                        {{ header.label }}
                    </th>
                    <th v-if="$slots.actions" scope="col" class="px-6 py-4 text-right font-medium tracking-wider w-[1%] whitespace-nowrap">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50/50 transition-colors">
                    <td v-for="header in headers" :key="header.key" class="px-6 py-4 whitespace-nowrap">
                        <slot :name="`cell-${header.key}`" :item="item">
                            {{ item[header.key] }}
                        </slot>
                    </td>
                    <td v-if="$slots.actions" class="px-6 py-4 whitespace-nowrap text-right w-[1%]">
                        <slot name="actions" :item="item"></slot>
                    </td>
                </tr>
                <tr v-if="items.length === 0">
                    <td :colspan="headers.length + ($slots.actions ? 1 : 0)" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <span>No items found</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div v-if="pagination && pagination.total > 0" class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4 border-t border-gray-100 bg-gray-50/50">
        <span class="text-sm text-gray-500">
            Showing <span class="font-medium text-gray-900">{{ pagination.from }}</span> to <span class="font-medium text-gray-900">{{ pagination.to }}</span> of <span class="font-medium text-gray-900">{{ pagination.total }}</span> results
        </span>
        <Pagination :pagination="pagination" />
    </div>
</template>
