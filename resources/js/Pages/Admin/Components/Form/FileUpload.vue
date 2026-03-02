<script setup>
const props = defineProps({
        modelValue: [Object, File, Array],
        label: {
            type: String,
            required: true
        },
        multiple: {
            type: Boolean,
            default: false
        },
        accept: {
            type: String,
            default: 'image/*'
        },
        required: {
            type: Boolean,
            default: false
        },
        helperText: {
            type: String,
            default: 'SVG, PNG, JPG.'
        }
    });

const emit = defineEmits(['update:modelValue'])

const handleFileChange = (event) => {
    const files = event.target.files;
    if (!files.length) return;

    if (props.multiple) {
        emit('update:modelValue', Array.from(files));
    } else {
        emit('update:modelValue', files[0]);
    }
}
</script>

<template>
    <div>
        <label :for="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>

        <input
            :id="label"
            type="file"
            :multiple="multiple"
            :accept="accept"
            :required="required"
            @change="handleFileChange"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2"
        >

        <p v-if="helperText" class="mt-1 text-sm text-gray-500 dark:text-gray-300">
            {{ helperText }}
        </p>
    </div>
</template>
