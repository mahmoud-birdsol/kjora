<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { PlusCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';
import Title from './Title.vue';

const emit = defineEmits(['close', 'update:modelValue']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    modelValue: {
        required: false,
        default: null,
    },
});

// const form = useForm({});

const close = () => {
    emit('close');
};

const photoPreview = ref(null);
const photoInput = ref(null);

onMounted(() => {
    if (props.modelValue) {
        photoPreview.value = '/' + props.modelValue;
    }
});

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);

    emit('update:modelValue', photo);
};
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="flex flex-col min-h-[500px] justify-between p-6">
            <Title>{{ $t('upload') }}</Title>
            <div class="flex items-center justify-center">
                <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">
                <button type="button"
                    class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                    v-show="!photoPreview" @click.prevent="selectNewPhoto">
                    <PlusCircleIcon class="w-5 h-5" />
                </button>

                <div v-show="photoPreview" class="mt-2">
                    <div class="relative px-20 py-8 rounded">
                        <img :src="photoPreview" alt="" class="w-full h-auto rounded-lg">
                        <div class="absolute inset-0 w-full h-full bg-white opacity-30">
                            <div class="flex flex-col items-center justify-center">
                                <XMarkIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <PrimaryButton @click="close">
                    {{ $t('upload') }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
