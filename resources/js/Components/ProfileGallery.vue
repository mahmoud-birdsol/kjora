<template>
    <div v-if="posts?.length" class="">
        <div class="grid grid-cols-2 gap-4 overflow-auto max-h-[500px] sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 hideScrollBar ">
            <template v-for="(post, index) in posts " :key="post.id">
                <FadeInTransition>
                    <Link :href="isPublic ? route('public.posts', post.id) : route('posts.show', post.id)" class="relative w-full h-full overflow-hidden rounded-lg aspect-square group">

                    <template v-if="post?.cover_photo?.mime_type.startsWith('image')">
                        <img :src="post?.cover_photo?.original_url" alt="" class="object-cover w-full h-full ">
                    </template>

                    <template v-if="post?.cover_photo?.mime_type.startsWith('video')">
                        <video :src="post?.cover_photo?.original_url" :type="post?.cover_photo?.mime_type" class="object-cover object-left w-full h-full max-w-full mx-auto rounded-lg" />
                    </template>

                    <div class="absolute flex items-center gap-2 text-xs text-gray-100 bottom-2 ltr:right-2 rtl:left-2 ">
                        <span class="filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]">{{ post.views_count }}</span>
                        <EyeIcon class="h-5 w-5 filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]" />
                    </div>
                    <!-- delete post button -->
                    <!-- <button v-if="currentUser.id === user.id" @click.prevent.stop="postIdToDelete = post.id; showDeletePostModal = true" class="absolute top-0 right-0 hidden bg-white group-hover:block bg-opacity-90 rounded-bl-xl">
                        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100 ">
                            <XMarkIcon class="w-5 h-5 text-stone-800" />
                        </div>

                    </button> -->
                    </Link>
                </FadeInTransition>
            </template>
        </div>
    </div>
    <ConfirmationModal :show="showDeletePostModal" @close="showDeletePostModal = false" @delete="removePost(postIdToDelete)">
        <template #body>
            <span>{{ $t('Are you sure you want delete this post ? ') }}</span>
        </template>
    </ConfirmationModal>
    <FixedActionBtn v-if="currentUser?.id === user?.id && !isPublic"  @click="showUploadFileModal = true">
        <PlusCircleIcon class="w-5 text-white" />
    </FixedActionBtn>
    <UploadGalleryFile :show="showUploadFileModal" @close="showUploadFileModal = false" @reload="$emit('reload')" :should-upload="true" />
</template>

<script setup>
import { PlusCircleIcon, } from '@heroicons/vue/24/outline';
import UploadGalleryFile from './UploadGalleryFile.vue';
import { onMounted, ref } from 'vue';
import FadeInTransition from './FadeInTransition.vue';

import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import FixedActionBtn from '@/Components/FixedActionBtn.vue';
import { EyeIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import ConfirmationModal from './ConfirmationModal.vue';

const props = defineProps({
    user: {
        required: true,
    },
    posts: null,
    media: null,
    shouldPreview: null
})
defineEmits(['reload'])
const isPublic = usePage().url.value.includes('public/player')

const showUploadFileModal = ref(false)
const currentUser = usePage().props.value.auth.user
const showDeletePostModal = ref(false)
const postIdToDelete = ref(null)

function removePost(id) {

    let index = props.posts.findIndex(item => item.id == id)
    props.posts.splice(index, 1)
    showDeletePostModal.value = false
    Inertia.delete(route('posts.destroy', id), {
        preserveState: true,
        preserveScroll: true,
    })
}

</script>

<style lang="scss" scoped></style>
