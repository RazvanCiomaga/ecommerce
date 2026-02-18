<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        required: true
    },
    modelValue: {
        type: Array,
        default: () => []
    },
    label: {
        type: String,
        default: 'Filter'
    }
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const dropdownRef = ref(null);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const updateSelection = (itemValue, isChecked) => {
    const newValue = [...props.modelValue];
    if (isChecked) {
        newValue.push(itemValue);
    } else {
        const index = newValue.indexOf(itemValue);
        if (index > -1) {
            newValue.splice(index, 1);
        }
    }
    emit('update:modelValue', newValue);
};

const closeDropdown = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown);
});
</script>

<template>
    <div class="relative" ref="dropdownRef">
        <button 
            @click="toggleDropdown" 
            class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" 
            type="button"
        >
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
            {{ label }}
            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
            </svg>
        </button>
        <div v-show="isOpen" class="absolute right-0 z-50 mt-2 w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose {{ label }}</h6>
            <ul class="space-y-2 text-sm">
                <li v-for="item in items" :key="item.value" class="flex items-center">
                    <input 
                        :id="`filter-checkbox-${item.value}`" 
                        type="checkbox" 
                        :value="item.value"
                        :checked="modelValue.includes(item.value)"
                        @change="updateSelection(item.value, $event.target.checked)"
                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    >
                    <label :for="`filter-checkbox-${item.value}`" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ item.label }}
                    </label>
                </li>
            </ul>
        </div>
    </div>
</template>
