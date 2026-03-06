<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    pagination: Object,
});
</script>

<template>
    <nav v-if="pagination && pagination.links.length > 3" class="flex items-center justify-center space-x-1" aria-label="Pagination">
        <template v-for="(link, index) in pagination.links" :key="index">
            <!-- Active Link -->
            <Link
                v-if="link.url && link.active"
                :href="link.url"
                preserve-scroll
                v-html="link.label"
                class="flex items-center justify-center px-3 tracking-tight py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors"
                aria-current="page"
            />
            
            <!-- Inactive Link -->
            <Link
                v-else-if="link.url && !link.active"
                :href="link.url"
                preserve-scroll
                v-html="link.label"
                class="flex items-center justify-center px-3 tracking-tight py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors"
            />

            <!-- Disabled Link (e.g. Previous on Page 1) -->
            <span
                v-else
                v-html="link.label"
                class="flex items-center justify-center px-3 tracking-tight py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed"
                aria-disabled="true"
            ></span>
        </template>
    </nav>
</template>
