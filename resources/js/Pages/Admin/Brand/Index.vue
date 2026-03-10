<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import BrandList from "@/Pages/Admin/Brand/BrandList.vue";

defineOptions({ layout: AdminLayout });

defineProps({
    brands: Object,
})
</script>

<template>
    <BrandList :brands="brands" />
</template>
