<script setup>
    import AdminLayout from "@/Pages/Admin/Components/AdminLayout.vue";
    import BrandList from "@/Pages/Admin/Brand/BrandList.vue";

    defineProps({
        brands: Object,
    })
</script>

<template>
    <AdminLayout>
        <BrandList :brands="brands" />
    </AdminLayout>
</template>

<style scoped>

</style>
