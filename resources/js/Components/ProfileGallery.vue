<template>
    <div class="">
        <div class="grid grid-cols-2 gap-4 overflow-auto sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 hideScrollBar ">


            <template v-if="shouldPreview == 'photos'">
                <template v-for="(file, index) in media.filter(f => f.type == 'image') " :key="index">
                    <div class="w-full h-full rounded-sm aspect-square">
                        <img :src="file.url" alt="" class="object-cover w-full h-full ">
                    </div>
                </template>
            </template>

            <template v-if="shouldPreview == 'videos'">
                <template v-for="(file, index) in media.filter(f => f.type == 'video')" :key="index">
                    <div class="w-full h-full rounded-sm aspect-video">
                        <video :src="file.url" alt="" class="object-cover w-full h-full " controls />
                    </div>
                </template>
            </template>



        </div>
    </div>
    <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
        <button class="flex items-center justify-center text-center bg-black rounded-full shadow-xl w-14 aspect-square"
            @click="showUploadFileModal = true">
            <PlusCircleIcon class="w-5 text-white" />
        </button>
        <UploadGalleryFile :show="showUploadFileModal" @close="showUploadFileModal = false" :should-upload="true" />

    </div>
</template>

<script setup>
import {
    PlusCircleIcon,
} from '@heroicons/vue/24/outline';
import UploadGalleryFile from './UploadGalleryFile.vue';
import { onMounted, ref } from 'vue';
defineProps({
    user: {
        required: false,
    }
    , media: null,
    shouldPreview: null
})
const showUploadFileModal = ref(false)
onMounted(() => {

})
</script>

<style lang="scss" scoped></style>
