<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { CheckIcon } from '@heroicons/vue/24/outline';
import { ref, reactive, computed } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline';
import SlideDownTransition from '@/Components/SlideDownTransition.vue'
const props = defineProps({
    img: Object,
    open: Boolean,
    aspectRatio: {
        default: null
    },
    presetMode:Object,
    addOption:Object
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
    background: false,
    highlight: false
}
let boxStyle = {
    width: '100%',
    height: '100%',
    backgroundColor: '#FFF',
    margin: 'auto',
}
const isLoading = ref(true)
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
        isLoading.value = false
    } else {
        num.value += 1
    }
}
</script>
<template>
    <div class="overflow-hidden">
        <SlideDownTransition>
            <div v-if="open" class="flex flex-col gap-4 p-6 bg-white border-t min-w-7xl">
                <div v-loading="isLoading">
                    <VuePictureCropper :boxStyle="boxStyle" :img="imageObj?.url" :options="{...options,...addOption}" @ready="ready" :key="num" :presetMode="presetMode" />
                </div>
                <div class="flex justify-center w-full gap-4 ">
                    <button @click="getResult" class="self-center">
                        <CheckIcon class="w-8 p-1 text-green-600 rounded-full bg-stone-100" />
                    </button>
                    <button  @click="$emit('update:open')">
                        <XMarkIcon class="w-8 p-1 text-red-600 rounded-full bg-stone-100" />
                    </button>
                </div>
        
            </div>
        </SlideDownTransition>
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

.cropper-modal {
    background-color: #fff !important;
}
</style>
