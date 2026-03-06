<script setup>
import {computed, ref, watch} from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import FormModal from '@/Pages/Admin/Components/FormModal.vue';
import InputGroup from '@/Pages/Admin/Components/Form/Input.vue';
import SelectGroup from '@/Pages/Admin/Components/Form/Select.vue';
import TextareaGroup from '@/Pages/Admin/Components/Form/Textarea.vue';
import FileUpload from "@/Pages/Admin/Components/Form/FileUpload.vue";

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
const deletingImageId = ref(null);

/**
 * Handle modal closure and state cleanup
 */
const close = () => {
    cleanupPreviews();
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
    description: '',
    productImages: []
});

/**
 * Sync form state when product prop changes (Edit mode)
 */
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
}, { immediate: true });

/**
 * Submit form data using Method Spoofing for PUT requests with files
 */
const submit = () => {
    if (props.product) {
        router.post(route('admin.products.update', props.product.id), {
            _method: 'put',
            ...form.data(),
        }, {
            forceFormData: true,
            onSuccess: () => close(),
        });
    } else {
        form.post(route('admin.products.store'), {
            onSuccess: () => close(),
        });
    }
};

/**
 * Reactive source for images already persisted on the server
 */
const savedImages = computed(() => {
    return props.product?.images || [];
});

/**
 * Generate temporary URLs for local file previews
 */
const newImagePreviews = computed(() => {
    if (!form.productImages || form.productImages.length === 0) return [];

    return Array.from(form.productImages).map(file => ({
        url: URL.createObjectURL(file),
        name: file.name
    }));
});

/**
 * Remove a file from the selection queue using DataTransfer
 */
const removeNewImage = (index) => {
    const dt = new DataTransfer();
    const files = Array.from(form.productImages);
    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    form.productImages = dt.files;
};

/**
 * Release memory by revoking blob URLs
 */
const cleanupPreviews = () => {
    newImagePreviews.value.forEach(preview => {
        URL.revokeObjectURL(preview.url);
    });
};

/**
 * Trigger server-side image deletion
 */
const deleteImageFromServer = (id) => {
    if (confirm('Are you sure you want to delete this image?')) {
        router.delete(route('admin.product_images.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onBefore: () => {
                // Set the loading state for the specific image
                deletingImageId.value = id;
            },
            onFinish: () => {
                // Clear the loading state once the request is done
                deletingImageId.value = null;
            }
        });
    }
};
</script>

<template>
    <FormModal 
        :show="show" 
        :maxWidth="maxWidth" 
        :title="product ? 'Edit Product' : 'Add Product'"
        @close="close"
        @submit="submit"
    >
        <div class="grid gap-4 sm:grid-cols-2">
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
                        <FileUpload
                            label="Product Images"
                            multiple
                            v-model="form.productImages"
                        />
                        <div class="sm:col-span-2 mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div v-for="img in savedImages" :key="img.id" class="relative group">
                                <img
                                    :src="'/' + img.image"
                                    class="w-full h-24 object-cover rounded-lg border-2 border-green-500 shadow-sm"
                                    alt="Product image"
                                />
                                <span class="absolute top-1 left-1 bg-green-500 text-white text-[10px] px-1.5 rounded-full shadow">Saved</span>

                                <div v-if="deletingImageId === img.id" class="absolute inset-0 flex items-center justify-center bg-gray-900/20 rounded-lg">
                                    <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>

                                <button
                                    v-if="deletingImageId !== img.id"
                                    @click.prevent="deleteImageFromServer(img.id)"
                                    type="button"
                                    class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-800 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <div v-for="(preview, index) in newImagePreviews" :key="index" class="relative group">
                                <img
                                    :src="preview.url"
                                    class="w-full h-24 object-cover rounded-lg border-2 border-blue-500 shadow-md transition-transform group-hover:scale-105"
                                    alt="Product image"
                                />
                                <span class="absolute top-1 left-1 bg-blue-600 text-white text-[10px] px-1.5 rounded-full shadow">New</span>

                                <button
                                    @click.prevent="removeNewImage(index)"
                                    type="button"
                                    class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 shadow-lg"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <TextareaGroup
                                label="Description"
                                v-model="form.description"
                            />
                        </div>
                    </div>
        
        <template #actions>
            <button @click="close" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                Cancel
            </button>
            <button type="submit" class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                {{ product ? 'Update product' : 'Add product' }}
            </button>
        </template>
    </FormModal>
</template>
