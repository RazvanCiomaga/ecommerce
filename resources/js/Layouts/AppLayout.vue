<script setup>
import Header from '@/Components/App/Header.vue';
import Footer from '@/Components/App/Footer.vue';
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-100">
        <Header />

        <!-- Page content gets injected here -->
        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
