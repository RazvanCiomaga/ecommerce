<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

// Reactive state for controlling the mobile sidebar visibility
const isSidebarOpen = ref(false);

// Access the authenticated user from Inertia's shared props
const user = computed(() => usePage().props?.auth?.user);

// A placeholder for cart item count
const cartCount = computed(() => 0); // Replace with your actual cart logic

// Function to toggle the sidebar
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
    <header class="relative z-10 bg-primary-600 bg-opacity-90 text-white shadow-lg backdrop-blur-sm">
        <div class="container mx-auto flex h-16 items-center justify-between px-4">
            <!-- Logo -->
            <Link :href="route('home')" class="text-xl font-bold">
                E-Shop
            </Link>

            <!-- Desktop Navigation -->
            <nav class="hidden items-center space-x-6 md:flex">
                <Link :href="route('home')" class="hover:text-primary-200">Home</Link>
                <Link href="#" class="hover:text-primary-200">Products</Link>
                <Link href="#" class="hover:text-primary-200">Categories</Link>
                <Link href="#" class="hover:text-primary-200">About</Link>
            </nav>

            <!-- Desktop Auth & Cart -->
            <div class="hidden items-center space-x-4 md:flex">
                <template v-if="!user">
                    <Link :href="route('login')" class="hover:text-primary-200">Login</Link>
                    <Link :href="route('register')" class="rounded-md bg-white px-3 py-1 text-sm text-primary-600 hover:bg-gray-100">Register</Link>
                </template>
                <template v-else>
                    <Link href="#" class="hover:text-primary-200">My Account</Link>
                    <Link :href="route('logout')" method="post" as="button" class="hover:text-primary-200">Logout</Link>
                </template>
                <Link href="#" class="relative hover:text-primary-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span v-if="cartCount > 0" class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs">{{ cartCount }}</span>
                </Link>
            </div>

            <!-- Mobile Burger Menu -->
            <div class="md:hidden">
                <button @click="toggleSidebar" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Teleport the sidebar and overlay to the body to escape the header's stacking context -->
        <Teleport to="body">
            <!-- Mobile Sidebar Overlay -->
            <transition
                enter-active-class="transition-opacity ease-linear duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity ease-linear duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="isSidebarOpen" @click="toggleSidebar" class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"></div>
            </transition>

            <!-- Mobile Sidebar Panel -->
            <transition
                enter-active-class="transition ease-in-out duration-300 transform"
                enter-from-class="-translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition ease-in-out duration-300 transform"
                leave-from-class="translate-x-0"
                leave-to-class="-translate-x-full"
            >
                <div v-if="isSidebarOpen" class="fixed left-0 top-0 z-30 h-full w-64 bg-gray-900 text-gray-200 shadow-lg md:hidden">
                    <div class="flex h-full flex-col p-5">
                        <!-- Sidebar Header -->
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-white">Menu</h2>
                            <button @click="toggleSidebar" class="focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Navigation Links -->
                        <nav class="mt-8 flex flex-col space-y-4">
                            <Link :href="route('home')" class="hover:text-white">Home</Link>
                            <Link href="#" class="hover:text-white">Products</Link>
                            <Link href="#" class="hover:text-white">Categories</Link>
                            <Link href="#" class="hover:text-white">About</Link>
                            <hr class="border-gray-700"/>
                            <!-- Mobile Auth Links -->
                            <template v-if="!user">
                                <Link :href="route('login')" class="hover:text-white">Login</Link>
                                <Link :href="route('register')" class="hover:text-white">Register</Link>
                            </template>
                            <template v-else>
                                <Link href="#" class="hover:text-white">My Account</Link>
                                <Link :href="route('logout')" method="post" as="button" class="text-left hover:text-white">Logout</Link>
                            </template>
                            <Link href="#" class="hover:text-white">Cart ({{ cartCount }})</Link>
                        </nav>
                    </div>
                </div>
            </transition>
        </Teleport>
    </header>
</template>
