<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FadeInTransition from '@/Components/FadeInTransition.vue';
import { ref, onMounted, onBeforeMount, computed } from 'vue';
import { faCamera, faSpinner } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import Crop from './Crop.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import CropIcon from '@/Components/Icons/CropIcon.vue';
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
const resolution = {
    width: 450,
    height: 337.5,
}
const currentUser = usePage().props.value.auth.user
const photoUrl = ref(null)
const context = computed(() => canvas.value?.getContext('2d'))
const close = () => {
    closeCamera()
    cameraIsOpen.value = false
    loadingCamera.value = false
    captured.value = false

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
            console.error(error)
            alert('May be the browser didn\'t support or there is some errors.');
        });
};
function closeCamera() {
    if (camera.value && camera.value.srcObject) {
        camera.value.srcObject.getVideoTracks().forEach(track => {
            track.stop();
        });
    }
}
const capture = () => {

    context.value.drawImage(camera.value, 0, 0, resolution.width, resolution.height);
    closeCamera()

    photoUrl.value = document.getElementById('photoTaken')
        .toDataURL('image/jpeg')
        .replace('image/jpeg', 'image/octet-stream');



    captured.value = true;
    cameraIsOpen.value = false;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const openCropModal = ref(false)
const cropFile = ref(null)
function changeFiles(file, url, id) {
    photoUrl.value = url
    const image = new Image()
    image.onload = function () {
        context.value.drawImage(image, 0, 0, resolution.width, resolution.height);
    };
    image.src = url

}
let showCropModal = (url) => {
    cropFile.value = {
        name: `${currentUser.name}_selfie_image`,
        url: photoUrl.value,
    }
    openCropModal.value = true
    // cropLoading.value = false

}
const submit = () => {


    emit('update:modelValue', photoUrl);

    close();
};
</script>

<template>
    <!-- <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close"> -->
    <teleport to='body'>
        <FadeInTransition>
            <div v-show="show" class="fixed inset-0 transition-all duration-300 transform cursor-pointer" @click="close">
                <div class="absolute inset-0 bg-gray-500 opacity-75" />
            </div>
        </FadeInTransition>
        <transition enter-active-class="duration-300 ease-out"
            enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
            enter-to-class="translate-y-0 opacity-100 sm:scale-100" leave-active-class="duration-200 ease-in"
            leave-from-class="translate-y-0 opacity-100 sm:scale-100"
            leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95">
            <div v-show="show" class="fixed inset-0 grid place-items-center max-w-xl mx-auto transition-all transform ">
                <div
                    class=" flex flex-col min-h-[500px] justify-between p-6 bg-white rounded-lg shadow-xl mt-2 mx-2 max-sm:min-w-[90%]">
                    <div class="flex justify-end ">
                        <button @click="close">
                            <XMarkIcon class="w-4 h-4 text-gray-900 hover:text-gray=500" />
                        </button>
                    </div>
                    <div class="flex justify-center">
                        <h2 class="text-xl font-bold uppercase text-primary">{{ $t('upload') }}</h2>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">
                        <div class="grid grid-cols-1 gap-4 my-8 w-full relative">
                            <video v-show="cameraIsOpen && !loadingCamera && !captured" ref="camera" class="-scale-x-100"
                                :width="resolution.width" :height="resolution.height" autoplay></video>
                            <div v-if="!cameraIsOpen && !captured"
                                class="sm:min-w-[450px] sm:min-h-[337.5px]  max-sm:aspect-square rounded border border-gray-500 flex justify-center items-center p-2">
                                <p class="text-xs font-light text-gray-500">
                                    {{ $t('Click on the following link to open the camera') }}.
                                    <a href="javascript:;" class="text-sky-500 hover:text-sky-700" @click="openCamera">
                                        {{ $t('open camera') }}</a>
                                </p>
                            </div>
                            <div v-if="cameraIsOpen && loadingCamera"
                                class="sm:min-w-[450px] w-[80%] mx-auto sm:min-h-[337.5px] max-sm:aspect-square rounded border border-gray-500 flex justify-center items-center">
                                <font-awesome-icon icon="spinner" spin class="w-5 h-5 text-center text-gray-500" />
                            </div>
                            <canvas v-show="captured" id="photoTaken" ref="canvas" :class='`max-w-full`'
                                :width="resolution.width" :height="resolution.height"></canvas>
                            <button v-if="captured" @click="showCropModal" class="absolute top-0 left-0 w-fit bg-black p-2">
                                <CropIcon class="w-4" fill="#FFF"/>
                            </button>
                            <Crop :img="cropFile" @crop="changeFiles" v-model:open="openCropModal"
                                @update:open="() => openCropModal = false" />
                            <div class="flex justify-center">
                                <button type="button"
                                    class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                                    @click.prevent="cameraIsOpen ? capture() : openCamera()">
                                    <font-awesome-icon icon="camera" class="w-5 h-5 text-center text-white" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <PrimaryButton @click="submit">
                            {{ $t('upload') }}
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
    <!-- </Modal> -->
</template>
