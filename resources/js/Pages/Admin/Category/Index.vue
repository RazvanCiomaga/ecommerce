<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CategoryList from "@/Pages/Admin/Category/CategoryList.vue";

defineOptions({ layout: AdminLayout });

defineProps({
    categories: Object,
});
</script>

<template>
    <CategoryList :categories="categories" />
</template>
