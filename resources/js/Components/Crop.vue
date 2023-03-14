<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ScissorsIcon } from '@heroicons/vue/24/outline';
import { ref, reactive } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline';
import Modal from './Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
const props = defineProps({
    img: Object,
    open: Boolean,
    aspectRatio:{
        default:null
    }
})

const emit = defineEmits(['crop', 'update:open'])
const result = reactive({
    dataURL: '',
    blobURL: '',
})
const num = ref(0)
const options = {
    viewMode: 1,
    dragMode: 'crop',
    responsive: true,
    minCanvasWidth: '320',
    minCanvasHeight: '320',
    minContainerWidth: '320',
    minContainerHeight: '320',
    aspectRatio:props.aspectRatio,
}
let boxStyle = {
    width: '100%',
    height: '100%',
    backgroundColor: '#f8f8f8',
    margin: 'auto',
}

async function getResult() {
    if (!cropper) return
    const filePreviewUrl = cropper.getDataURL()
    const blob = await cropper.getBlob()
    if (!blob) return
    const file = await cropper.getFile({
        fileName: props.img.name,
    })

    result.blobURL = URL.createObjectURL(blob)
    result.dataURL = filePreviewUrl
    
    emit('crop', file, filePreviewUrl, props.img.id)
    emit('update:open')

}
function ready() {
    if(cropper.cropped && cropper.ready && cropper.originalUrl == props.img.url){
    }else{
        num.value+=1
    }
}
</script>
<template>
    <div v-show="open" 
    class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>
    <div v-show="open"
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 min-w-7xl bg-white p-6 rounded-xl flex gap-4 flex-col">
        <XMarkIcon class="w-4" @click="$emit('update:open')"/>
        <div>
            <VuePictureCropper :boxStyle="boxStyle" :img="img?.url" :options="options" @ready="ready" :key="num"/>
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
</style>
