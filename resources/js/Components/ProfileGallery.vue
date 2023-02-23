<template>
    <div class="">
        <div class="grid grid-cols-2 gap-4 overflow-auto sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 hideScrollBar ">
            <template v-if="shouldPreview == 'photos'">

                <template v-for="(file, index) in media.filter(f => f.type == 'image' || f.type == 'webp') " :key="index">
                    <FadeInTransition>
                        <Link :href="route('gallery.show', file.id)"
                            class=" relative w-full h-full rounded-lg overflow-hidden aspect-square">
                        <img :src="file.url" alt="" class="object-cover w-full h-full ">
                        <button @click.prevent.stop="removeItem(file.id)"
                            class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                            <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                <XMarkIcon class="w-5 h-5 text-stone-800" />
                            </div>
                        </button>
                        </Link>
                    </FadeInTransition>
                </template>

            </template>

            <template v-if="shouldPreview == 'videos'">
                <template v-for="(file, index) in media.filter(f => f.type == 'video')" :key="index">
                    <FadeInTransition>
                        <Link :href="route('gallery.show', file.id)"
                            class=" relative w-full h-full rounded-md overflow-hidden aspect-video">
                        <video :src="file.url" alt="" class="object-cover w-full h-full " controls />
                        <button @click.prevent.stop="removeItem(file.id)"
                            class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                            <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                <XMarkIcon class="w-5 h-5 text-stone-800" />
                            </div>
                        </button>
                        </Link>
                    </FadeInTransition>
                </template>
            </template>



        </div>
    </div>
    <div class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
        <button class="flex items-center justify-center text-center bg-black rounded-full shadow-xl w-14 aspect-square"
            @click="showUploadFileModal = true">
            <PlusCircleIcon class="w-5 text-white" />
        </button>
        <UploadGalleryFile :show="showUploadFileModal" @close="showUploadFileModal = false" @reload="$emit('reload')"
            :should-upload="true" />

    </div>
</template>

<script setup>
import {
    PlusCircleIcon, XMarkIcon,
} from '@heroicons/vue/24/outline';
import UploadGalleryFile from './UploadGalleryFile.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import FadeInTransition from './FadeInTransition.vue';
import ListGroupTransition from './ListGroupTransition.vue';
import FilePreview from './FilePreview.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    user: {
        required: false,
    }
    , media: null,
    shouldPreview: null
})
defineEmits(['reload'])


const showUploadFileModal = ref(false)


onMounted(() => {

});
function getFileFromId(id) {
    return props.media.filter(item => item.id == id)[0]
}

// function seturl
function removeItem(id) {
    let file = getFileFromId(id)
    let index = props.media.indexOf(file);

    props.media.splice(index, 1)
    axios.delete(route('api.gallery.destroy', id)).then((res) => console.log(res))
}

</script>

<style lang="scss" scoped></style>
