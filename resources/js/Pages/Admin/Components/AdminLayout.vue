<script setup>
    import Sidebar from '@/Pages/Admin/Components/Siderbar.vue'
    import Navbar from '@/Pages/Admin/Components/Navbar.vue'
    import { onMounted } from 'vue'
    import { initFlowbite } from 'flowbite'

    // initialize components based on data attribute selectors
    onMounted(() => {
        initFlowbite();
    });
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navbar />
        <Sidebar />

        <slot />
    </div>
</template>

<style scoped>

</style>
