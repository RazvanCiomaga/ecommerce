<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from "vue";

defineOptions({ layout: AppLayout });

const props = defineProps({
    products: Object,
    brands: Array,
    categories: Array,
    filters: Object,
});

const search = ref(props.filters.search || '');
const selectedBrands = ref(props.filters.brands || []);
const selectedCategories = ref(props.filters.categories || []);
const minPrice = ref(props.filters.min_price || '');
const maxPrice = ref(props.filters.max_price || '');

let debounceTimeout = null;
watch([search, selectedBrands, selectedCategories, minPrice, maxPrice], () => {
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        router.get(route('products.index'), {
            search: search.value,
            brands: selectedBrands.value,
            categories: selectedCategories.value,
            min_price: minPrice.value,
            max_price: maxPrice.value,
        }, { preserveState: true, preserveScroll: true, replace: true });
    }, 300);
}, { deep: true });

const handleAddToCart = (payload) => {
    router.post(route('cart.add'), {
        product_id: payload.product.id,
        quantity: payload.quantity,
    }, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Products" />

    <div class="bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Our Products</h2>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar / Filters -->
                <div class="w-full md:w-64 flex-shrink-0 space-y-8 bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-fit">
                    <div v-if="categories && categories.length > 0">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Categories</h3>
                        <div class="space-y-3">
                            <div v-for="category in categories" :key="category.id" class="flex items-center">
                                <input :id="`category-${category.id}`" type="checkbox" :value="category.id" v-model="selectedCategories" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 cursor-pointer" />
                                <label :for="`category-${category.id}`" class="ml-3 text-sm text-gray-600 cursor-pointer select-none">{{ category.name }}</label>
                            </div>
                        </div>
                    </div>

                    <div v-if="brands && brands.length > 0">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Brands</h3>
                        <div class="space-y-3">
                            <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                                <input :id="`brand-${brand.id}`" type="checkbox" :value="brand.id" v-model="selectedBrands" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 cursor-pointer" />
                                <label :for="`brand-${brand.id}`" class="ml-3 text-sm text-gray-600 cursor-pointer select-none">{{ brand.name }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Price Range</h3>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" v-model="minPrice" placeholder="Min" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
                            <span class="text-gray-500">-</span>
                            <input type="number" min="0" v-model="maxPrice" placeholder="Max" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                <!-- Product Grid Area -->
                <div class="flex-1 space-y-6">
                    <!-- Search Bar -->
                    <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <input type="text" v-model="search" placeholder="Search products..." class="w-full border-0 focus:ring-0 p-1 text-gray-900 sm:text-sm bg-transparent" />
                    </div>

                    <div v-if="products.data.length === 0" class="text-center py-12 bg-white rounded-lg border border-gray-100 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                        <div class="mt-6">
                            <button @click="search = ''; selectedBrands = []; selectedCategories = []; minPrice = ''; maxPrice = ''" type="button" class="inline-flex items-center rounded-md border border-transparent bg-primary-100 px-4 py-2 text-sm font-medium text-primary-700 hover:bg-primary-200">
                                Clear Filters
                            </button>
                        </div>
                    </div>
                    <div v-else>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                            <ProductCard v-for="product in products.data" :key="product.id" :product="product" @add-to-cart="handleAddToCart" />
                        </div>
                        
                        <div class="mt-12 flex justify-center">
                            <Pagination :pagination="products" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
