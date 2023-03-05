<template>
    <AppLayout title="gallery">
        <template #header>
            <p v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')">Photo</p>
            <p v-if="media.mime_type.startsWith('video')">video</p>
        </template>
        <div class="px-2 py-6 bg-white rounded-3xl xs:px-8">
            <div class="grid w-full gap-3 border lg:grid-cols-2 rounded-2xl border-stone-400 ">

                <!-- image and caption left col -->
                <div class="flex flex-col max-w-full gap-6 p-3 ">
                    <!-- image -->
                    <div class="flex justify-center overflow-hidden rounded-3xl sm:aspect-video">
                        <img v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')"
                            :src="media.original_url" alt="" class="object-contain h-full ">
                        <video v-if="media.mime_type.startsWith('video')" controls :src="media.original_url" alt=""
                            class="object-cover " />
                    </div>
                    <!-- information -->
                    <div class="grid xs:grid-cols-[min-content_1fr] gap-4">
                        <!-- col 1 -->
                        <div class="min-w-max ">
                            <Avatar :username="user.name" :image-url="user.avatar_url" :size="'lg'" :border="true"
                                border-color="primary" />
                        </div>
                        <!-- col 2 -->
                        <div class="flex flex-col gap-3">
                            <!-- user information row 1-->
                            <div class="flex justify-between w-full">
                                <div class="flex flex-col gap-1 ">
                                    <div class="flex flex-row gap-2">
                                        <h3 class="m-0 text-lg font-bold leading-none capitalize ">{{ user.name }} </h3>
                                        <span v-if="false">star icon</span>
                                    </div>
                                    <Link :href="route('player.profile', user.id)" class="text-xs text-stone-400 ">@{{
                                        user.username }} </Link>
                                </div>
                                <div class="relative">
                                    <button class="p-1" @click="showOptions = !showOptions">
                                        <EllipsisHorizontalIcon class="w-6" />
                                    </button>
                                    <div v-show="showOptions"
                                        class="absolute left-0 p-2 bg-white rounded-lg shadow-lg cursor-pointer top-1/2">
                                        <div class="fixed top-0 left-0 w-full h-full" @click="showOptions = false">
                                        </div>
                                        <div
                                            class="relative z-20 w-full text-sm text-center text-gray-500 divide-y whitespace-nowrap">
                                            <div @click="contenteditable = true">Edit</div>
                                            <div>remove photo</div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- date and time and likes row 2-->
                            <div class="flex justify-between w-full gap-2 text-sm text-stone-700">
                                <div class="flex flex-row gap-2">
                                    <span>{{ dayjs(media.created_at).fromNow(true) }}</span>
                                    <span>|</span>
                                    <span>{{ dayjs(media.created_at).format('hh:mm A') }}</span>

                                </div>
                                <div class="flex items-center gap-1"><span class="text-sm">{{ media?.like_count }}</span>
                                    <LikeButton :isLiked="media?.is_liked" :likeable_id="media.id"
                                        :likeable_type="'\\App\\Models\\MediaLibrary'">
                                        <template v-slot="{ isLiked }">
                                            <HeartIcon class="w-5 stroke-current stroke-2 text-primary"
                                                :class="isLiked ? 'fill-current' : 'fill-transparent'" />
                                        </template>
                                    </LikeButton>
                                </div>
                            </div>
                            <!-- caption row 3 -->
                            <div>
                                <p class="text-sm text-stone-500" v-show="!contenteditable">
                                    aml walaed
                                </p>
                                <div v-show="contenteditable" class="flex">
                                    <input type="text" value="aml walaed"
                                        class="w-full text-sm border-none rounded-full text-stone-500 ring-1 focus:ring-primary focus:shadow-none focus:border-none ring-gray-300" />
                                    <button class="p-1 group" @click="submit">
                                        <PaperAirplaneIcon class="w-5 text-neutral-900" />
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- comment and replies right col -->
                <div class="flex flex-col h-full gap-2 max-lg:border-t lg:border-l border-stone-300">
                    <!-- header -->
                    <div class="p-3 pt-5 text-sm border-b border-stone-300">comments {{ comments && comments.filter(c =>
                        !c.parent_id)?.length }}
                    </div>
                    <!-- comments -->
                    <div class="self-stretch h-full p-3 px-6 ">
                        <div class="flex flex-col w-full gap-4" v-if="comments">
                            <template v-for="comment in comments.filter(c => !c.parent_id)" :key="comment.id">
                                <Comment @addedReply="handleAddedReply" :comment="comment"></Comment>
                            </template>
                        </div>
                    </div>
                    <!-- new comment form -->
                    <div class="flex flex-row items-center self-end w-full p-3 border-t gap-x-3 border-stone-300">
                        <button>
                            <FaceSmileIcon class="w-6 text-neutral-400" />
                        </button>
                        <div class="flex items-center flex-grow ">

                            <textarea @keypress.enter.exact.prevent="addComment" v-model="newComment" name="newComment"
                                id="newComment" rows="1" placeholder="Add a comment..."
                                class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary "></textarea>
                        </div>

                        <button @click="addComment" :disabled="isSending" class="p-1 group ">

                            <PaperAirplaneIcon class="w-5 group-hover:text-neutral-700"
                                :class="isSending ? 'text-neutral-200' : 'text-neutral-400'" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Avatar from '../../Components/Avatar.vue';
import { FaceSmileIcon, EllipsisHorizontalIcon } from '@heroicons/vue/24/outline';
import { PaperAirplaneIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';
import { onMounted, onBeforeMount, ref } from 'vue';
import Comment from '../../Components/Comment.vue';
import { HeartIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import LikeButton from '../../Components/LikeButton.vue';
onBeforeMount(() => {

    dayjs.extend(relativeTime)
});
const props = defineProps({
    media: null,
    user: null,
})
const comments = ref(null);
const newComment = ref(null);
const isSending = ref(false);
let showOptions = ref(false)
let contenteditable = ref(false);
const currentUser = usePage().props.value.auth.user
function getComments() {
    axios.get(route('api.gallery.comments'), {
        params: {
            commentable_id: props.media.id,
            commentable_type: 'App\\Models\\MediaLibrary'
        }
    }).then(res => {
        comments.value = res.data.data
    }).catch(err => console.error(err))
}
function submit() {
    console.log('has submit')
}

onMounted(() => {
    getComments()
});
function sendComment() {
    axios.post(route('api.gallery.comments.store'), {
        commentable_id: props.media.id,
        commentable_type: 'App\\Models\\MediaLibrary',
        body: newComment.value,
        user_id: currentUser.id,
        parent_id: null
    }).then(res => {
        newComment.value = ''

        getComments()

    }).catch(err => console.error(err)).finally(() => {
        isSending.value = false
    })
}
function addComment(e) {
    if (!newComment.value || newComment.value.trim() === '') return
    isSending.value = true
    sendComment()
}
function handleAddedReply() {
    getComments();
}




</script>

<style lang="scss" scoped></style>
