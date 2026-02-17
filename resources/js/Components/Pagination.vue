<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    pagination: Object,
});
</script>

<template>
    <nav
        class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
        aria-label="Pagination"
    >
        <template v-for="link in pagination.links" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                v-html="link.label"
                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                :class="{
                    'z-10 bg-indigo-50 border-indigo-500 text-indigo-600':
                        link.active,
                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50':
                        !link.active,
                }"
            />
            <span
                v-else
                v-html="link.label"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500"
            ></span>
        </template>
    </nav>
</template>
