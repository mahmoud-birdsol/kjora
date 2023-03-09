<template>
    <div class="">
        <div class="grid grid-cols-2 gap-4 overflow-auto sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 hideScrollBar ">


            <template v-for="(post, index) in posts " :key="post.id">
                <FadeInTransition>
                    <Link :href="route('posts.show', post.id)"
                        class="relative w-full h-full overflow-hidden rounded-lg aspect-square group">
                    <img :src="post?.cover_photo?.original_url" alt="" class="object-cover w-full h-full ">
                    <button v-if="currentUser.id === user.id" @click.prevent.stop="showDeleteMediaModal = true"
                        class="absolute top-0 right-0 hidden bg-white group-hover:block bg-opacity-90 rounded-bl-xl">
                        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100 ">
                            <XMarkIcon class="w-5 h-5 text-stone-800" />
                        </div>
                        <Modal :show="showDeleteMediaModal" @close="showDeleteMediaModal = false" :closeable="true"
                            :show-close-icon="false" :max-width="'sm'">
                            <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                <p class="mb-3 text-lg">Are you sure you want delete this
                                    post ?</p>
                                <div class="flex justify-center w-full gap-4">
                                    <button
                                        class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                        @click="showDeleteMediaModal = false">Cancel</button>
                                    <button
                                        class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                        @click="removeItem(post.id)">Delete</button>

                                </div>
                            </div>
                        </Modal>
                    </button>
                    </Link>
                </FadeInTransition>
            </template>



            <!-- <template v-if="shouldPreview == 'videos'">
                <template v-for="(file, index) in media.filter(f => f.type == 'video')" :key="index">
                    <FadeInTransition>
                        <Link :href="route('gallery.show', file.id)"
                            class="relative w-full h-full overflow-hidden rounded-md group aspect-video">
                        <video :src="file.url" alt="" class="object-cover w-full h-full " controls />
                        <button v-if="currentUser.id === user.id" @click.prevent.stop="showDeleteMediaModal = true"
                            class="absolute top-0 right-0 hidden bg-white group-hover:block bg-opacity-90 rounded-bl-xl">
                            <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                <XMarkIcon class="w-5 h-5 text-stone-800" />
                            </div>
                            <Modal :show="showDeleteMediaModal" @close="showDeleteMediaModal = false" :closeable="true"
                                :show-close-icon="false" :max-width="'sm'">
                                <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                    <p class="mb-3 text-lg">Are you sure you want delete this
                                        media?</p>
                                    <div class="flex justify-center w-full gap-4">
                                        <button
                                            class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                            @click="showDeleteMediaModal = false">Cancel</button>
                                        <button
                                            class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                            @click="removeItem(file.id)">Delete</button>

                                    </div>
                                </div>
                            </Modal>
                        </button>
                        </Link>
                    </FadeInTransition>
                </template>
            </template> -->



        </div>
    </div>
    <div v-if="currentUser.id === user.id" class="fixed bottom-0 right-0 p-10 sm:px-20 lg:px-40">
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

import { Link, usePage } from '@inertiajs/inertia-vue3';
import Modal from './Modal.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    user: {
        required: true,
    },
    posts: null,
    media: null,
    shouldPreview: null
})
defineEmits(['reload'])


const showUploadFileModal = ref(false)
const currentUser = usePage().props.value.auth.user
const showDeleteMediaModal = ref(false)

onMounted(() => {

});
function getFileFromId(id) {
    return props.posts.filter(item => item.id == id)[0]
}

// function seturl
function removeItem(id) {
    let file = getFileFromId(id)
    let index = props.posts.indexOf(file);

    props.posts.splice(index, 1)
    showDeleteMediaModal.value = false
    Inertia.delete(route('posts.destroy', id), {
        preserveState: true,
        preserveScroll: true,
    })
}

</script>

<style lang="scss" scoped></style>
