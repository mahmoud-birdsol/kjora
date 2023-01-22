<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted, onBeforeMount } from 'vue';
import { faCamera } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';

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

onBeforeMount(() => {
    library.add(faCamera);
});

onMounted(() => {
    if (props.modelValue) {
        photoPreview.value = modelValue;
    }
});


const emit = defineEmits(['close', 'update:modelValue']);
const camera = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);
const cameraIsOpen = ref(false);

const close = () => {
    emit('close');
};

const openCamera = () => {
    const constraints = (window.constraints = {
        audio: false,
        video: true
    });

    navigator.mediaDevices
        .getUserMedia(constraints)
        .then(stream => {
            cameraIsOpen.value = true;
            camera.value.srcObject = stream;
        })
        .catch(error => {
            alert("May be the browser didn't support or there is some errors.");
        });
}

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
                <div class="grid grid-cols-1 gap-4">
                    <video v-if="cameraIsOpen" ref="camera" :width="450" :height="337.5" autoplay></video>
                    <div v-if="!cameraIsOpen" class="w-[450px] h-[337.5px] rounded border border-gray-500 flex justify-center items-center">
                        <p class="text-gray-500 text-xs font-light">
                            Click on the following link to open the camera.
                            <a href="javascript:;" class="text-sky-500 hover:text-sky-700">Open camera</a>
                        </p>
                    </div>

                    <div>
                        <PrimaryButton type="button" @click.prevent="openCamera">
                            <font-awesome-icon icon="camera" class="h-5 w-5 text-white text-center"/> Open Camera
                        </PrimaryButton>
                    </div>
                </div>

                <button v-show="photoPreview" class="mt-2 p-20" @click.prevent="selectNewPhoto">
                    <div class="block rounded p-20">
                        <img :src="photoPreview" alt="" class="w-full h-auto rounded-lg">
                    </div>
                </button>
            </div>
            <div>
                <PrimaryButton @click="close">
                    Upload
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
