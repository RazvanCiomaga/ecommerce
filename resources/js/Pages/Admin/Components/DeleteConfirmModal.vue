<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    show: Boolean,
    title: {
        type: String,
        default: 'Confirm Delete'
    },
    itemName: {
        type: String,
        default: 'this item'
    }
});

defineEmits(['close', 'confirm']);
</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="md">
        <div class="p-6">
            <!-- Warning icon -->
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-900">
                {{ title }}
            </h3>
            <p class="text-sm text-gray-500 mt-2">
                Are you sure you want to delete <span class="font-semibold text-gray-700">{{ itemName }}</span>? This action cannot be undone.
            </p>
            <div class="mt-6 flex justify-end gap-3">
                <SecondaryButton @click="$emit('close')"> Cancel </SecondaryButton>
                <DangerButton @click="$emit('confirm')"> Delete </DangerButton>
            </div>
        </div>
    </Modal>
</template>
