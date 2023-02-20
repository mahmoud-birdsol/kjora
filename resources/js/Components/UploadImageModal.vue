<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { PlusCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';

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
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center">
                <h2 class="text-xl text-primary font-bold uppercase">Upload</h2>
            </div>
            <div class="flex justify-center items-center">
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >
                <button type="button"
                        class="inline-flex items-center rounded-full border border-transparent bg-black p-4 text-white shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                        v-show="! photoPreview"
                        @click.prevent="selectNewPhoto"
                >
                    <PlusCircleIcon class="h-5 w-5"/>
                </button>

                <div v-show="photoPreview" class="mt-2" >
                    <div class="relative rounded px-20 py-8">
                        <img :src="photoPreview" alt="" class="w-full h-auto rounded-lg">
                        <div class="absolute inset-0 bg-white opacity-30 h-full w-full">
                            <div class="flex flex-col justify-center items-center">
                                <XMarkIcon class="h-8 w-8 text-white"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <PrimaryButton @click="close">
                    Upload
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
