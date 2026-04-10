<script setup>
import { formatPrice } from "@/utils.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

defineProps({
    product: Object,
});

const emit = defineEmits(['add-to-cart']);
const quantity = ref(1);

const addToCart = (product) => {
    emit('add-to-cart', { product, quantity: quantity.value });
};
</script>

<template>
    <div class="group flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
        <a href="#" class="aspect-h-3 aspect-w-4 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96 block">
            <img v-if="product.images && product.images.length > 0" :src="`/${product.images[0].image}`" :alt="product.name" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
            <img v-else src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=2070" :alt="product.name" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
        </a>
        <div class="flex flex-1 flex-col space-y-2 p-4">
            <h3 class="text-sm font-medium text-gray-900">
                <a href="#" class="hover:underline">
                    {{ product.name }}
                </a>
            </h3>
            <p class="text-sm text-gray-500">{{ product.description.substring(0, 50) }}...</p>
            <div class="flex flex-1 flex-col justify-end">
                <p class="text-base font-medium text-gray-900">{{ formatPrice(product.price) }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <input type="number" v-model="quantity" min="1" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-primary-500 py-1.5 focus:ring-primary-500 text-sm" />
                    <PrimaryButton @click.prevent="addToCart(product)" class="ml-2 w-full justify-center text-xs px-2 py-1.5">
                        Add to Cart
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
