<script setup>
import Modal from '@/Components/Modal.vue';

defineProps({
    show: Boolean,
    title: String,
    maxWidth: {
        type: String,
        default: 'md'
    }
});

defineEmits(['close', 'submit']);
</script>

<template>
    <Modal :show="show" @close="$emit('close')" :max-width="maxWidth">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 rounded-t border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ title }}
                </h3>
                <button @click="$emit('close')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition-colors">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form @submit.prevent="$emit('submit')">
                <div class="p-6">
                    <!-- Main Content -->
                    <slot />
                </div>
                
                <!-- Footer Actions -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3 rounded-b-lg">
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </Modal>
</template>
