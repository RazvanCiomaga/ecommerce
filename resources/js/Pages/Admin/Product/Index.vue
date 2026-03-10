<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ProductList from "@/Pages/Admin/Product/ProductList.vue";

defineOptions({ layout: AdminLayout });

defineProps({
    products: Object,
    categories: Array,
    brands: Array,
    filters: Object
})
</script>

<template>
    <ProductList :products="products" :categories="categories" :brands="brands" :filters="filters" />
</template>
