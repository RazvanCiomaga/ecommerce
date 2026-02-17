<script setup>
import AdminLayout from "@/Pages/Admin/Components/AdminLayout.vue";
import ProductList from "@/Pages/Admin/Product/ProductList.vue";

defineProps({
    products: Object
})
</script>

<template>
    <AdminLayout>
        <ProductList :products="products" />
    </AdminLayout>
</template>

<style scoped>

</style>
