<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import FadeInTransition from './FadeInTransition.vue';

const props = defineProps({
    modelValue: {
        required: false,
        type: String,
        default: null,
    },
    shouldUpload: {
        require: false,
        type: Boolean,
        default: false,
    },
    currentImageUrl: {
        required: false,
        type: String,
        default: null,
    },
    modelName: {
        required: false,
        type: String,
    },
    modelId: {
        required: false,
        type: Number,
    },
    collectionName: {
        required: false,
        type: String,
    },
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
    position: {
        required: false,
        type: String,
        default: 'center',
    }
});

const emit = defineEmits(['close', 'update:modelValue', 'reload']);

const showPreview = ref(false);
const previewImageUrls = ref([]);
const photoInput = ref(null);
const isLoading = ref(false);
const isDisabled = ref(false);



const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {

    if (!photoInput.value.files.length) {
        return
    };
    Array.from(photoInput.value.files).forEach((file, i) => {

        const reader = new FileReader();

        reader.onload = (e) => {
            previewImageUrls.value.push(e.target.result);
            showPreview.value = true;
        };

        reader.readAsDataURL(file);
    })
};

const removePhoto = (i) => {

    previewImageUrls.value.splice(i, 1)
    previewImageUrls.value.length === 0 ? showPreview.value = false : null;
};

const upload = () => {
    if (!photoInput.value.files.length) {
        return
    };
    isLoading.value = true;
    isDisabled.value = true;

    Array.from(photoInput.value.files).forEach((file, i) => {
        axios.post(route('api.gallery.upload'), {
            gallery: file
        }, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).catch(err => console.error(err)).finally(() => {
            if (i === photoInput.value.files.length - 1) {
                reset()
                emit('reload');
            }
        })
    })
};

function reset(e) {
    previewImageUrls.value = []
    isLoading.value = false
    isDisabled.value = false;
    emit('close');
}
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position" @close="reset">
        <div class=" flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center -mt-12">
                <h2 class="text-xl font-bold uppercase text-primary">Upload</h2>
            </div>
            <!-- v-loading="" -->
            <div class="flex flex-col items-center h-full gap-2 py-8 ">

                <!-- input -->
                <div class="max-w-[300px] sm:px-20 w-full">
                    <input ref="photoInput" type="file" multiple accept="video/*,image/*" class="hidden"
                        @change="updatePhotoPreview">

                    <div class="flex items-center justify-center mb-6">
                        <button type="button" :disabled="isDisabled"
                            class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500"
                            @click.prevent="selectNewPhoto">
                            <PlusCircleIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                <!-- preview -->

                <div v-show="showPreview" class="relative overflow-auto hideScrollBar max-h-80">
                    <div class="relative grid grid-cols-3 gap-2">
                        <template v-for="(fileUrl, index) in previewImageUrls" :key="index">
                            <div class="relative">
                                <img v-if="fileUrl.startsWith('data:image')" :src="fileUrl" alt=""
                                    class="object-contain w-full h-full rounded-lg aspect-square">
                                <video v-if="fileUrl.startsWith('data:video')" :src="fileUrl" alt=""
                                    class="object-cover w-full h-full rounded-lg aspect-square" controls />
                                <button @click.prevent="removePhoto(index)"
                                    class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                                    </div>
                                </button>
                            </div>

                        </template>
                        <FadeInTransition>
                            <div v-if="isLoading"
                                class="absolute inset-0 z-20 grid w-full h-full p-4 bg-stone-400/50 place-content-center ">

                            </div>
                        </FadeInTransition>
                    </div>
                    <FadeInTransition>
                        <div v-if="isLoading" class="absolute inset-0 top-4 z-20 grid p-4 place-content-center ">
                            <div
                                class="h-12 border-4 rounded-full border-primary border-t-white aspect-square animate-spin">
                            </div>
                        </div>
                    </FadeInTransition>
                </div>

            </div>

            <div>
                <PrimaryButton @click.prevent="upload" :disabled="isDisabled">
                    Upload
                </PrimaryButton>
                <!-- <InputError class="mt-2" :message="form.errors.image" /> -->
            </div>
        </div>
    </Modal>
</template>
