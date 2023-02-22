<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';

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

const emit = defineEmits(['close', 'update:modelValue', 'selected']);

const showPreview = ref(false);
const previewImageUrls = ref([]);
const photoInput = ref(null);





const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {

    // console.log(photoInput.value.files)

    if (!photoInput.value.files.length) {
        return
    }
    [...photoInput.value.files].forEach((file, i) => {



        const reader = new FileReader();

        reader.onload = (e) => {
            previewImageUrls.value.push(e.target.result);

            showPreview.value = true;
        };

        reader.readAsDataURL(file);

    })

};

const removePhoto = (i) => {

    // showPreview.value = false;
    // previewImageUrl.value = null;
    previewImageUrls.value.splice(i, 1)
    previewImageUrls.value.length === 0 ? showPreview.value = false : null;
};

const upload = () => {

    [...photoInput.value.files].forEach((file, i) => {
        console.log(file)
        axios.post(route('api.gallery.upload'), {
            gallery: file
        }, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then((response) => console.log(response))

    })


    if (!props.shouldUpload) {
        emit('update:modelValue', photoInput.value.files);
        emit('selected', previewImageUrls.value);
        emit('close');

        return;
    }
};
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position"
        @close="() => { $emit('close'), previewImageUrls = [] }">
        <div class="flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center -mt-12">
                <h2 class="text-xl font-bold uppercase text-primary">Upload</h2>
            </div>
            <!-- v-loading="" -->
            <div class="flex flex-col items-center h-full gap-2 py-8 ">

                <!-- input -->
                <div class="max-w-[300px] sm:px-20 w-full">
                    <input ref="photoInput" type="file" multiple class="hidden" @change="updatePhotoPreview">

                    <div class="flex items-center justify-center mb-6">
                        <button type="button"
                            class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                            @click.prevent="selectNewPhoto">
                            <PlusCircleIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                <!-- preview -->

                <div v-show="showPreview" class="grid grid-cols-3 gap-2 overflow-auto hideScrollBar max-h-80">
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

                </div>
            </div>
            <div>
                <PrimaryButton @click.prevent="upload" :disabled="false">
                    Upload
                </PrimaryButton>
                <!-- <InputError class="mt-2" :message="form.errors.image" /> -->
            </div>
        </div>
    </Modal>
</template>
