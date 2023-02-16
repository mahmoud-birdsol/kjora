<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted, onBeforeMount } from 'vue';
import { faCamera, faSpinner } from '@fortawesome/free-solid-svg-icons';
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
    library.add(faSpinner);
});

onMounted(() => {
    if (props.modelValue) {
        photoPreview.value = '/' + props.modelValue;
    }
});

const emit = defineEmits(['close', 'update:modelValue']);
const camera = ref(null);
const canvas = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);
const cameraIsOpen = ref(false);
const loadingCamera = ref(false);
const captured = ref(false);

const close = () => {
    emit('close');
};

const openCamera = () => {
    const constraints = (window.constraints = {
        audio: false,
        video: true
    });

    cameraIsOpen.value = true;
    loadingCamera.value = true;
    captured.value = false;

    navigator.mediaDevices
        .getUserMedia(constraints)
        .then(stream => {
            camera.value.srcObject = stream;
            loadingCamera.value = false;
        })
        .catch(error => {
            alert('May be the browser didn\'t support or there is some errors.');
        });
};

const capture = () => {
    const context = canvas.value.getContext('2d');
    context.drawImage(camera.value, 0, 0, 450, 337.5);

    captured.value = true;
    cameraIsOpen.value = false;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const submit = () => {
    const photo = document.getElementById('photoTaken')
        .toDataURL('image/jpeg')
        .replace('image/jpeg', 'image/octet-stream');

    emit('update:modelValue', photo);

    close();
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
                <div class="grid grid-cols-1 gap-4 my-8">
                    <video v-show="cameraIsOpen && !loadingCamera && !captured" ref="camera" :width="450"
                           :height="337.5" autoplay></video>
                    <div v-if="!cameraIsOpen && !captured"
                         class="w-[450px] h-[337.5px] rounded border border-gray-500 flex justify-center items-center">
                        <p class="text-gray-500 text-xs font-light">
                            Click on the following link to open the camera.
                            <a href="javascript:;" class="text-sky-500 hover:text-sky-700"
                               @click="openCamera">Open camera</a>
                        </p>
                    </div>

                    <div v-if="cameraIsOpen && loadingCamera"
                         class="w-[450px] h-[337.5px] rounded border border-gray-500 flex justify-center items-center">
                        <font-awesome-icon icon="spinner" spin class="h-5 w-5 text-gray-500 text-center"/>
                    </div>

                    <canvas v-show="captured" id="photoTaken" ref="canvas" :width="450" :height="337.5"></canvas>

                    <div class="flex justify-center">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-full border border-transparent bg-black p-4 text-white shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                            @click.prevent="cameraIsOpen ? capture() : openCamera()">
                            <font-awesome-icon icon="camera" class="h-5 w-5 text-white text-center"/>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <PrimaryButton @click="submit">
                    Upload
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
