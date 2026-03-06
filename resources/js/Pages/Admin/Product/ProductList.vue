<script setup>
import { usePage, useForm, router } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import Table from "@/Pages/Admin/Components/Table.vue";
import ProductModal from "@/Pages/Admin/Product/ProductModal.vue";
import DeleteConfirmModal from "@/Pages/Admin/Components/DeleteConfirmModal.vue";
import FilterDropdown from "@/Pages/Admin/Components/FilterDropdown.vue";
import { debounce } from "lodash-es";

const props = defineProps({
    products: Object,
    categories: Array,
    brands: Array,
    filters: Object
});

const isProductModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const editingProductId = ref(null);
const productToDelete = ref(null);

const selectedBrands = ref(props.filters?.brands || []);
const selectedCategories = ref(props.filters?.categories || []);
const search = ref(props.filters?.search || '');

/**
 * Computed property to ensure the modal always gets the
 * most recent data from the Inertia props.
 */
const selectedProduct = computed(() => {
    if (!editingProductId.value) return null;

    // Search for the product in the current paginated data
    return props.products.data.find(p => p.id === editingProductId.value);
});

const categoryOptions = computed(() => {
    return props.categories.map(category => ({
        value: category.id,
        label: category.name
    }));
});

const brandOptions = computed(() => {
    return props.brands.map(brand => ({
        value: brand.id,
        label: brand.name
    }));
});

const filterProducts = () => {
    router.get(route('admin.products.index'), {
        brands: selectedBrands.value,
        categories: selectedCategories.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
};

const debouncedSearch = debounce(filterProducts, 500); // use debounce only when user search

watch([selectedBrands, selectedCategories], () => {
    filterProducts();
});

watch(search, () => {
    debouncedSearch();
});

const columns = [
    { key: 'name', label: 'Product name' },
    { key: 'category', label: 'Category' },
    { key: 'brand', label: 'Brand' },
    { key: 'description', label: 'Description' },
    { key: 'quantity', label: 'Quantity' },
    { key: 'in_stock', label: 'Stock' },
    { key: 'price', label: 'Price' }
];

const openAddProductModal = () => {
    editingProductId.value = null;
    isProductModalOpen.value = true;
}

const openEditProductModal = (product) => {
    editingProductId.value = product.id;
    isProductModalOpen.value = true;
}

const openDeleteModal = (product) => {
    productToDelete.value = product;
    isDeleteModalOpen.value = true;
}

const closeModal = () => {
    isProductModalOpen.value = false;
    isDeleteModalOpen.value = false;
    productToDelete.value = null;
    editingProductId.value = null;
}

const deleteProduct = () => {
    if (productToDelete.value) {
        router.delete(route('admin.products.destroy', productToDelete.value.id), {
            onSuccess: () => closeModal()
        });
    }
}
</script>

<template>
    <section class="h-full">
        <!-- Main Actions Header -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Products</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your catalog, inventory and prices.</p>
            </div>
            
            <button 
                @click="openAddProductModal" 
                type="button" 
                class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add product
            </button>
        </div>

        <!-- Filters & Search Bar -->
        <div class="bg-white border text-sm border-gray-200 shadow-sm rounded-lg mb-6 overflow-hidden">
            <div class="p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Search -->
                <div class="w-full lg:w-1/3">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" 
                            placeholder="Search products..." 
                            v-model="search"
                        >
                    </div>
                </div>

                <!-- Dropdown Filters -->
                <div class="w-full lg:w-auto flex flex-col sm:flex-row items-center gap-3">
                    <FilterDropdown
                        :items="brandOptions"
                        v-model="selectedBrands"
                        label="Filter by Brand"
                    />

                    <FilterDropdown
                        :items="categoryOptions"
                        v-model="selectedCategories"
                        label="Filter by Category"
                    />
                </div>

            </div>
        </div>

        <!-- Content Table -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden relative">
            <Table :headers="columns" :items="products.data" :pagination="products">
                
                <template #cell-name="{ item }">
                    <span class="font-medium text-gray-900">{{ item.name }}</span>
                </template>

                <template #cell-category="{ item }">
                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded">{{ item.category?.name }}</span>
                </template>

                <template #cell-brand="{ item }">
                    {{ item.brand?.name }}
                </template>
                
                <template #cell-description="{ item }">
                    <span class="truncate block max-w-xs" :title="item.description">{{ item.description || '-' }}</span>
                </template>

                <template #cell-in_stock="{ item }">
                    <span v-if="item.in_stock" class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded flex w-fit items-center">
                        <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span> Active
                    </span>
                    <span v-else class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded flex w-fit items-center">
                        <span class="w-2 h-2 mr-1.5 bg-red-500 rounded-full"></span> Out of Stock
                    </span>
                </template>

                <template #cell-price="{ item }">
                    <span class="font-semibold text-gray-900">${{ item.price.toLocaleString() }}</span>
                </template>

                <template #actions="{ item }">
                    <div class="flex items-center space-x-3">
                        <button 
                            @click="openEditProductModal(item)" 
                            class="text-gray-500 hover:text-blue-600 transition-colors p-1"
                            title="Edit"
                        >
                            <svg class="w-5 h-5 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                        <button 
                            @click="openDeleteModal(item)" 
                            class="text-gray-500 hover:text-red-600 transition-colors p-1"
                            title="Delete"
                        >
                            <svg class="w-5 h-5 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </template>
            </Table>
        </div>

        <ProductModal
            :show="isProductModalOpen"
            :product="selectedProduct"
            :categories="categories"
            :brands="brands"
            @close="closeModal"
        />

        <DeleteConfirmModal
            :show="isDeleteModalOpen"
            title="Delete Product"
            :itemName="productToDelete?.name"
            @close="closeModal"
            @confirm="deleteProduct"
        />
    </section>
</template>

<style scoped>

</style>
