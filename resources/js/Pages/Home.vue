<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3';
import { formatPrice } from "@/utils.js";

// This tells Inertia to use AppLayout.vue as the persistent layout for this page
defineOptions({ layout: AppLayout });

defineProps({
    featuredProducts: Array,
});
</script>

<template>
    <Head title="Home" />

    <!-- 1. Hero Section -->
    <section class="relative h-[60vh] min-h-[400px] bg-gray-900 text-white">
        <!-- You can replace this with a high-quality background image -->
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?q=80&w=2070');"></div>
        <div class="relative z-10 flex h-full flex-col items-center justify-center text-center">
            <h1 class="text-4xl font-bold tracking-tight md:text-6xl">Style for Every Story</h1>
            <p class="mt-4 max-w-2xl text-lg text-gray-300">Discover our curated collection of products designed for modern living.</p>
            <a href="#" class="mt-8 rounded-md bg-primary-600 px-8 py-3 font-semibold text-white transition hover:bg-primary-700">
                Shop New Arrivals
            </a>
            <p class="mt-4 text-sm text-gray-400">
                *This is a demo project for portfolio purposes. Orders are not processed.
            </p>
        </div>
    </section>

    <!-- 2. Value Propositions -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 gap-8 text-center md:grid-cols-3">
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM16 16.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 8V4m0 0L8 8m4-4l4 4m-4-4v12m0 0h-4m4 0h4" /></svg>
                    <h3 class="mt-4 text-lg font-semibold">Free Shipping</h3>
                    <p class="mt-1 text-gray-600">On all orders over $75</p>
                </div>
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    <h3 class="mt-4 text-lg font-semibold">Secure Payments</h3>
                    <p class="mt-1 text-gray-600">Protected by Stripe & PayPal</p>
                </div>
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5V4H4zm0 12h5v5H4v-5zm8-12h5v5h-5V4zm8 0h5v5h-5V4zm-8 12h5v5h-5v-5zm8 0h5v5h-5v-5z" /></svg>
                    <h3 class="mt-4 text-lg font-semibold">Easy Returns</h3>
                    <p class="mt-1 text-gray-600">30-day return policy, no questions asked.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Featured Products -->
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold tracking-tight">Featured Products</h2>
            <p class="mt-2 text-lg text-gray-600">Hand-picked items you're sure to love.</p>
            <div class="mt-12 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="product in featuredProducts" :key="product.id" class="group relative text-left">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                        <img v-if="product.images && product.images.length > 0" :src="`/${product.images[0].image}`" alt="Product image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                        <img v-else src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=2070" alt="Product image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ product.title }}
                                </a>
                            </h3>
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ formatPrice(product.price) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Promotional Banner -->
    <section class="bg-primary-700">
        <div class="container mx-auto px-4 py-16 text-center">
            <h2 class="text-3xl font-bold text-white">End of Season Sale</h2>
            <p class="mt-2 text-lg text-primary-200">Get up to 40% off on selected items. Don't miss out!</p>
            <a href="#" class="mt-6 inline-block rounded-md border border-transparent bg-white px-6 py-3 font-semibold text-primary-700 transition hover:bg-gray-100">
                Shop Sale
            </a>
        </div>
    </section>
</template>
