<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ScissorsIcon } from '@heroicons/vue/24/outline';
import { ref, reactive } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline';
import CropIcon from './Icons/CropIcon.vue';
import Modal from './Modal.vue';
const props = defineProps({
    img: Object,
})
const emit = defineEmits(['crop'])

const result = reactive({
    dataURL: '',
    blobURL: '',
})
const options = {
    viewMode: 1,
    dragMode: 'crop',
    responsive: true,
    // background: false,
    // // highlight: true,
    // // aspectRatio: 16 / 9,
    minCanvasWidth: '320',
    minCanvasHeight: '320',
    // minCropBoxHeight: '100',
    minContainerWidth: '320',
    minContainerHeight: '320',
    // viewMode: 1,
    // dragMode: 'crop',
    aspectRatio: 1 / 1,
}
let boxStyle = {
    width: '100%',
    height: '100%',
    backgroundColor: '#f8f8f8',
    margin: 'auto',
}


let showCropModal = ref(false)

async function getResult() {
    if (!cropper) return
    const filePreviewUrl = cropper.getDataURL()
    const blob = await cropper.getBlob()
    if (!blob) return
    console.log(filePreviewUrl === result.dataURL);
    console.log(blob === result.blobURL);

    const file = await cropper.getFile({
        fileName: props.img.name,
    })

    result.blobURL = URL.createObjectURL(blob)
    result.dataURL = filePreviewUrl
    // console.log({ filePreviewUrl, blob, file })
    // emit('crop', file, filePreviewUrl, props.img.id)
    // showCropModal.value = false

}
function ready() {
    console.log('fileData passed to component ', props.img)
}
</script>
<template>
    <button class="absolute top-0 left-0 bg-white bg-opacity-90 rounded-br-xl" @click="showCropModal = true">
        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
            <CropIcon class="w-4" />
        </div>
    </button>
    <Modal :show="showCropModal" :closeable="true" :showCloseIcon="true" @close="showCropModal = false">
        <div class="preview">
            <img :src="img?.url">
        </div>
        <div>
            <VuePictureCropper :boxStyle="boxStyle" :img="img.url" :options="options" @ready="ready" />
        </div>
        <button @click="getResult" class="rounded-full px-4 py-1 font-bold text-white bg-primary text-sm">Crop</button>

        <div class="preview">
            <img :src="result.dataURL">
        </div>
        <div class="preview">
            <img :src="result.blobURL">
        </div>
    </Modal>
</template>
<style scoped>
.preview {
    display: flex;
    width: 100%;
    max-width: 800px;
    margin-bottom: 1em;

}

.preview img {
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
}
</style>
