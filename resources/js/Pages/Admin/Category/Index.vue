<script setup>
    import AdminLayout from "@/Pages/Admin/Components/AdminLayout.vue";
    import CategoryList from "@/Pages/Admin/Category/CategoryList.vue";

    defineProps({
        categories: Object,
    });
</script>

<template>
    <AdminLayout>
        <CategoryList :categories="categories" />
    </AdminLayout>
</template>

<style scoped>

</style>
