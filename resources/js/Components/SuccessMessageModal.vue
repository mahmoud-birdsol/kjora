<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
});

</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="sm" position="right">
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
