<script setup>
import AdminLayout from "@/Pages/Admin/Components/AdminLayout.vue";
import ProductList from "@/Pages/Admin/Product/ProductList.vue";

defineProps({
    products: Object,
    categories: Array,
    brands: Array,
    filters: Object
})
</script>

<template>
    <AdminLayout>
        <ProductList :products="products" :categories="categories" :brands="brands" :filters="filters" />
    </AdminLayout>
</template>

<style scoped>

</style>
