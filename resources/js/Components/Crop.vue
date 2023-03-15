<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ScissorsIcon } from '@heroicons/vue/24/outline';
import { ref, reactive, computed } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline';
import Modal from './Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const props = defineProps({
    img: Object,
    open: Boolean,
    aspectRatio: {
        default: null
    }
})

const emit = defineEmits(['crop', 'update:open'])
const result = reactive({
    dataURL: '',
    blobURL: '',
})
const num = ref(Math.floor(Math.random() * 100))
const options = {
    viewMode: 1,
    dragMode: 'crop',
    responsive: true,
    aspectRatio: props.aspectRatio,
    background:false,
    highlight:false
}
let boxStyle = {
    width: '100%',
    height: '100%',
    backgroundColor: '#FFF',
    margin: 'auto',
}
const imageObj = computed(() => {
    return props.img
})

async function getResult() {
    if (!cropper) return
    const filePreviewUrl = cropper.getDataURL()
    const blob = await cropper.getBlob()
    if (!blob) return
    const file = await cropper.getFile({
        fileName: imageObj.value.name,
    })

    result.blobURL = URL.createObjectURL(blob)
    result.dataURL = filePreviewUrl

    emit('crop', file, filePreviewUrl, imageObj.value.id)
    emit('update:open')

}
function ready() {

    if (cropper.cropped && cropper.ready && cropper.originalUrl == imageObj.value.url) {
    } else {
        num.value += 1
    }
}
</script>
<template>
    <div v-if="open" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
    <div v-if="open"
        class="absolute flex flex-col gap-4 p-6 -translate-x-1/2 -translate-y-1/2 bg-white top-1/2 left-1/2 min-w-7xl rounded-xl">
        <XMarkIcon class="w-4" @click="$emit('update:open')" />
        <div>
            <VuePictureCropper :boxStyle="boxStyle" :img="imageObj?.url" :options="options" @ready="ready" :key="num" />
        </div>
        <PrimaryButton @click="getResult">done</PrimaryButton>
    </div>
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
.cropper-modal{
    background-color: #fff !important;
}
</style>
