<script setup>

import {router, useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import Table from "@/Pages/Admin/Components/Table.vue";
import FormModal from "@/Pages/Admin/Components/FormModal.vue";
import InputGroup from "@/Pages/Admin/Components/Form/Input.vue";
import DeleteConfirmModal from "@/Pages/Admin/Components/DeleteConfirmModal.vue";
import {debounce} from "lodash-es";

const props = defineProps({
    categories: Object,
    filter: Object,
})

const columns = [
    { key: 'name', label: 'Name' }
];

const form = useForm({
    name: '',
});

const isCategoryModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedCategory = ref(null);
const search = ref('');

watch(selectedCategory, (newCategory) => {
    if (newCategory) {
        form.name = newCategory.name;
    } else {
        form.reset();
    }
}, { immediate: true});

const openAddCategoryModal = () => {
    isCategoryModalOpen.value = true;
}

const openEditCategory = (category) => {
    selectedCategory.value = category;
    isCategoryModalOpen.value = true;
}

const openDeleteModal = (category) => {
    selectedCategory.value = category;
    isDeleteModalOpen.value = true;
}

const closeModal = () => {
    isCategoryModalOpen.value = false;
    isDeleteModalOpen.value = false;
    selectedCategory.value = null;
}

const deleteCategory = () => {
    if (selectedCategory.value) {
        router.delete(route('admin.categories.destroy', selectedCategory.value.id), {
            onSuccess: () => closeModal()
        });
    }
}

const submit = () => {
    if (selectedCategory.value) {
        router.post(route('admin.categories.update', selectedCategory.value.id), {
            _method: 'put',
            ...form.data(),
        }, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.categories.store'), {
            onSuccess: () => closeModal(),
        });
    }
}

const filterCategories = () => {
    router.get(route('admin.categories.index'), {
        search: search.value
    }, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
};

const debouncedSearch = debounce(filterCategories, 500); // use debounce only when user search

watch(search, () => debouncedSearch())

</script>

<template>
    <section class="h-full">
        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Categories</h2>
                <p class="text-sm text-gray-500 mt-1">Manage categories linked to products.</p>
            </div>

            <button
                @click="openAddCategoryModal"
                type="button"
                class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add category
            </button>
        </div>

        <div class="bg-white border text-sm border-gray-200 shadow-sm rounded-lg mb-6 overflow-hidden">
            <div class="p-4 flex flex-col lg:flex-row items-center justify-between gap-4">

                <!-- Search -->
                <div class="w-full lg:w-1/3">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                            placeholder="Search categories..."
                            v-model="search"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden relative">
            <Table :items="categories.data" :headers="columns" :pagination="categories">
                <template #cell-name="{ item }">
                    <span class="font-medium text-gray-900">{{ item.name }}</span>
                </template>

                <template #actions="{ item }">
                    <div class="flex items-center space-x-3">
                        <button
                            @click="openEditCategory(item)"
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

        <FormModal
            :show="isCategoryModalOpen"
            :title="selectedCategory ? 'Edit category' : 'Add category'"
            maxWidth="md"
            @close="closeModal"
            @submit="submit"
        >
            <InputGroup
                label="Brand Name"
                v-model="form.name"
                type="text"
                placeholder="Type brand name"
                required
            />

            <template #actions>
                <button @click="closeModal" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                    {{ selectedCategory ? 'Update category' : 'Add category' }}
                </button>
            </template>
        </FormModal>

        <DeleteConfirmModal
            :show="isDeleteModalOpen"
            title="Delete Category "
            :itemName="selectedCategory?.name"
            @close="closeModal"
            @confirm="deleteCategory"
        />
    </section>
</template>

<style scoped>

</style>
