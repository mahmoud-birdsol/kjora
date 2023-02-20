<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        required: true,
        type: String,
    },
    message: {
        required: true,
        type: String,
    },
    action: {
        required: false,
        type: String,
    },
    position: {
        required: false,
        type: String,
        default: 'center',
    }
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});

</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="md" :position="position">
        <div class="bg-white rounded-xl p-6 flex flex-col justify-between min-h-[500px]">
            <div class="flex justify-center my-4">
                <h2 class="text-xl text-primary font-bold uppercase">{{ title }}</h2>
            </div>

            <div class="flex justify-center my-4">
                <p class="text-xs text-gray-900">{{ message }}</p>
            </div>

            <div class="flex justify-center my-4" v-if="!action">
                <PrimaryButton @click="$emit('close')">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
