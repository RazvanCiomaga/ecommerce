<script setup>
    import { ref, onMounted } from 'vue'
    import Sidebar from '@/Pages/Admin/Components/Sidebar.vue'
    import Navbar from '@/Pages/Admin/Components/Navbar.vue'
    import Toast from "@/Pages/Admin/Components/Toast.vue";

    // Sidebar is open by default on larger screens
    const isSidebarOpen = ref(true);

    const toggleSidebar = () => {
        isSidebarOpen.value = !isSidebarOpen.value;
    };

    onMounted(() => {
        // Auto-close sidebar on mobile devices initially
        if (window.innerWidth < 1024) {
            isSidebarOpen.value = false;
        }
    });
</script>

<template>
    <div class="antialiased bg-gray-50 min-h-screen relative">
        <Navbar @toggle-sidebar="toggleSidebar" />
        
        <Sidebar :is-sidebar-open="isSidebarOpen" @close-sidebar="isSidebarOpen = false" />
        
        <main 
            :class="[
                'p-4 pt-20 transition-all duration-300 ease-in-out h-full',
                isSidebarOpen ? 'lg:ml-64' : 'ml-0'
            ]"
        >
            <slot />
        </main>

        <Toast />
    </div>
</template>

<style scoped>

</style>
