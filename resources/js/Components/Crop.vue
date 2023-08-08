<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SlideDownTransition from '@/Components/SlideDownTransition.vue';
import { computed, reactive, ref } from 'vue';
import VuePictureCropper, { cropper } from 'vue-picture-cropper';

const props = defineProps({
    img: Object,
    open: Boolean,
    aspectRatio: {
        default: null
    },
    presetMode: Object,
    addOption: Object
})

const emit = defineEmits(['crop', 'update:open'])
const result = reactive({
    dataURL: '',
    blobURL: '',
})
const num = ref(Math.floor(Math.random() * 100))
const options = {
    viewMode: 3,
    dragMode: 'crop',
    responsive: true,
    aspectRatio: props.aspectRatio,
    background: false,
    highlight: false,
}
let boxStyle = {
    height: '300px',
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
                    <VuePictureCropper :boxStyle="boxStyle" :img="imageObj?.url" :options="{ ...options, ...addOption }" @ready="ready" :key="num" :presetMode="presetMode" />
                </div>
                <div class="flex justify-center max-w-xs gap-4 mx-auto ">
                    <PrimaryButton @click="$emit('update:open')">
                        Cancel
                    </PrimaryButton>
                    <PrimaryButton @click="getResult" class="self-center !px-6">
                        Crop
                    </PrimaryButton>
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
