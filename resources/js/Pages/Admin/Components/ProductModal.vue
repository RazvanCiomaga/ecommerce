<script setup>
import { computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputGroup from '@/Pages/Admin/Components/Form/Input.vue';
import SelectGroup from '@/Pages/Admin/Components/Form/Select.vue';
import TextareaGroup from '@/Pages/Admin/Components/Form/Textarea.vue';

const props = defineProps({
    show: Boolean,
    title: {
        type: String,
        default: 'Create Item'
    },
    maxWidth: {
        type: String,
        default: '2xl'
    },
    product: {
        type: Object,
        default: null
    },
    categories: Array,
    brands: Array
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
    form.reset();
};

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

const form = useForm({
    name: '',
    brand_id: '',
    price: '',
    category_id: '',
    quantity: '',
    description: ''
});

watch(() => props.product, (newProduct) => {
    if (newProduct) {
        form.name = newProduct.name;
        form.brand_id = newProduct.brand_id;
        form.price = newProduct.price;
        form.category_id = newProduct.category_id;
        form.quantity = newProduct.quantity;
        form.description = newProduct.description;
    } else {
        form.reset();
    }
});

const submit = () => {
    if (props.product) {
        form.put(route('admin.products.update', props.product.id), {
            onSuccess: () => {
                close();
            }
        });
    } else {
        form.post(route('admin.products.store'), {
            onSuccess: () => {
                close();
            }
        });
    }
};
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" @close="close">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex justify-between items-center px-4 py-3 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ product ? 'Edit Product' : 'Add Product' }}
                </h3>
                <button @click="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 sm:p-5">
                <form @submit.prevent="submit">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <InputGroup 
                            label="Product Name" 
                            v-model="form.name" 
                            type="text" 
                            placeholder="Type product name" 
                            required 
                        />
                        <SelectGroup 
                            label="Brand" 
                            v-model="form.brand_id" 
                            :options="brandOptions" 
                        />
                        <InputGroup 
                            label="Price" 
                            v-model="form.price" 
                            type="number" 
                            placeholder="$2999" 
                            step="0.01"
                            required 
                        />
                        <SelectGroup 
                            label="Category" 
                            v-model="form.category_id" 
                            :options="categoryOptions" 
                        />
                        <InputGroup 
                            label="Quantity" 
                            v-model="form.quantity" 
                            type="number" 
                            placeholder="12" 
                            required 
                        />
                        <div class="sm:col-span-2">
                            <TextareaGroup 
                                label="Description" 
                                v-model="form.description" 
                            />
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        {{ product ? 'Update product' : 'Add new product' }}
                    </button>
                </form>
            </div>
        </div>
    </Modal>
</template>
