<script setup>
import { Link } from '@inertiajs/vue3';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import ProductIcon from '@/Components/Icons/ProductIcon.vue';
import BrandIcon from '@/Components/Icons/BrandIcon.vue';
import CategoryIcon from '@/Components/Icons/CategoryIcon.vue';

// Accept sidebar toggle props
defineProps({
    isSidebarOpen: {
        type: Boolean,
        default: false,
    }
});

const emit = defineEmits(['close-sidebar']);
</script>

<template>
    <!-- Overlay for mobile when sidebar is open -->
    <div
        v-if="isSidebarOpen"
        @click="emit('close-sidebar')"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 lg:hidden"
    ></div>

    <aside
        :class="[
            'fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform duration-300 ease-in-out bg-white border-r border-gray-200',
            isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]"
    >
        <div class="h-full px-4 py-6 overflow-y-auto relative">

            <!-- Close Button (visible when sidebar is open) -->
            <div class="flex justify-end mb-4">
                <button
                    @click="emit('close-sidebar')"
                    class="p-2 text-gray-400 hover:text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors"
                >
                    <CloseIcon class="w-6 h-6" />
                    <span class="sr-only">Close sidebar</span>
                </button>
            </div>

            <!-- Catalog Section -->
            <div class="mb-4">
                <h3 class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Catalog
                </h3>
                <ul class="space-y-1">
                    <li>
                        <Link
                            :href="route('admin.products.index')"
                            class="flex items-center px-2 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors"
                            :class="{ 'bg-gray-100 text-gray-900 font-semibold' : $page.url.startsWith('/admin/products') }"
                        >
                            <ProductIcon class="w-5 h-5 mr-3 text-gray-400" />
                            <span>Products</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('admin.brands.index')"
                            class="flex items-center px-2 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors"
                            :class="{ 'bg-gray-100 text-gray-900 font-semibold' : $page.url.startsWith('/admin/brands') }"
                        >
                            <BrandIcon class="w-5 h-5 mr-3 text-gray-400" />
                            <span>Brands</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('admin.categories.index')"
                            class="flex items-center px-2 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors"
                            :class="{ 'bg-gray-100 text-gray-900 font-semibold' : $page.url.startsWith('/admin/categories') }"
                        >
                            <CategoryIcon class="w-5 h-5 mr-3 text-gray-400" />
                            <span>Categories</span>
                        </Link>
                    </li>
                </ul>
            </div>

        </div>
    </aside>
</template>
