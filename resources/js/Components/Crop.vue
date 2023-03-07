<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ScissorsIcon } from '@heroicons/vue/24/outline';
import { ref, reactive } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline';
import CropIcon from './Icons/CropIcon.vue';
const props = defineProps({
    img: Object,
})
const emit = defineEmits(['crop'])
const result = reactive({
    dataURL: '',
    blobURL: '',
})
const options = {
    // viewMode: 1,
    // dragMode: 'crop',
    responsive: true,
    background: false,
    // highlight: true,
    // aspectRatio: 16 / 9,
    // minCanvasWidth: '320',
    // minCropBoxHeight:'100',
    minContainerWidth: '500',
    minContainerHeight: '300',
    viewMode: 1,
    dragMode: 'crop',
    aspectRatio: 16 / 9,


}
let boxStyle = {
    // width: '100%',
    // height: '100%',
    // backgroundColor: '#FFF',
    width: '100%',
    height: '100%',
    backgroundColor: '#fff',
    margin: 'auto',

}
let show = ref(false)
async function getResult() {
    if (!cropper) return
    const filePreviewUrl = cropper.getDataURL()
    const file = await cropper.getFile({
        fileName: props.img.name,
    })
    //     console.log({ base64, blob, file })
    result.dataURL = filePreviewUrl
    emit('crop', file, filePreviewUrl)
    show.value = false

}
function ready() {
    console.log(props.img)
}
</script>
<template>
    <button class="absolute top-0 left-0 bg-white bg-opacity-90 rounded-br-xl" @click="show = true">
        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
            <CropIcon class="w-4" />
        </div>
    </button>
    <!-- <Teleport to="body"> -->
        <div class="fixed top-0 left-0 h-screen w-screen m-auto overflow-hidden bg-black bg-opacity-50 z-40" v-show="show" @click="show = false"></div>
            <div class=" absolute top-1/2 flex flex-col bg-white p-6 rounded-xl mx-auto w-[700px] z-50 " v-show="show">
                <XMarkIcon class="w-5" @click="show = false" />
                <div>
                    <VuePictureCropper :boxStyle="boxStyle" :img="img.url" :options="options" @ready="ready" />
                </div>
                <div class="">
                    <button @click="getResult"
                        class="rounded-full px-4 py-1 font-bold text-white bg-primary text-sm">Crop</button>
                </div>
            </div>
    </Teleport>
</template>
<style scoped>

</style>