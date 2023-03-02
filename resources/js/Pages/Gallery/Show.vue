<template>
    <AppLayout title="gallery">
        <template #header>
            <p v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')">Photo</p>
            <p v-if="media.mime_type.startsWith('video')">video</p>
        </template>
        <div class="bg-white rounded-3xl px-2 xs:px-8 py-6">
            <div class="w-full grid lg:grid-cols-2 gap-3  border rounded-2xl border-stone-400   ">

                <!-- image and caption left col -->
                <div class=" flex flex-col gap-6 max-w-full  p-3 ">
                    <!-- image -->
                    <div class="rounded-3xl  sm:aspect-video overflow-hidden flex justify-center">
                        <img v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')"
                            :src="media.original_url" alt="" class="h-full  object-contain  ">
                        <video v-if="media.mime_type.startsWith('video')" controls :src="media.original_url" alt=""
                            class="object-cover   " />
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
                            <div class="flex w-full justify-between">
                                <div class="flex flex-col gap-1 ">
                                    <div class="flex flex-row gap-2">
                                        <h3 class="font-bold m-0 text-lg leading-none  capitalize ">{{ user.name }} </h3>
                                        <span v-if="false">star icon</span>
                                    </div>
                                    <span class="text-xs text-stone-400 ">@{{ 'username' }} </span>
                                </div>
                                <div>
                                    <button class="p-1">
                                        <EllipsisHorizontalIcon class="w-6" />
                                    </button>
                                </div>
                            </div>
                            <!-- date and time and likes row 2-->
                            <div class="flex w-full gap-2 text-sm justify-between text-stone-700">
                                <div class="flex flex-row gap-2">
                                    <span>{{ dayjs(media.created_at).fromNow(true) }}</span>
                                    <span>|</span>
                                    <span>{{ dayjs(media.created_at).format('hh:mm A') }}</span>

                                </div>
                                <div class="flex items-center gap-1"><span class="text-sm">{{ '10' }}</span>
                                    <button class="p-1">
                                        <HeartIcon
                                            class="w-5 text-primary hover:fill-current fill-transparent stroke-current stroke-2" />
                                    </button>
                                </div>
                            </div>
                            <!-- caption row 3 -->
                            <div>
                                <p class="text-sm text-stone-500">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio officiis et nisi hic eos
                                    recusandae quasi assumenda cupiditate blanditiis, iure autem praesentium perferendis
                                    velit
                                    molestias error nemo iste temporibus at!
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- comment and replies right col -->
                <div class="flex flex-col gap-2 h-full max-lg:border-t lg:border-l border-stone-300">
                    <!-- header -->
                    <div class=" pt-5 p-3 text-sm border-b border-stone-300">comments {{ comments && comments.filter(c =>
                        !c.parent_id)?.length }}
                    </div>
                    <!-- comments -->
                    <div class="self-stretch p-3 px-6 h-full ">
                        <div class="flex flex-col gap-4 w-full" v-if="comments">
                            <template v-for="comment in comments.filter(c => !c.parent_id)" :key="comment.id">
                                <Comment @addedReply="handleAddedReply" :comment="comment"></Comment>
                            </template>
                        </div>
                    </div>
                    <!-- new comment form -->
                    <div class="flex flex-row p-3 items-center self-end w-full gap-x-3 border-t border-stone-300">
                        <button>
                            <FaceSmileIcon class="w-6 text-neutral-400" />
                        </button>
                        <div class="flex items-center flex-grow ">

                            <textarea @keypress.enter.prevent.exact="addComment" v-model="newComment" name="newComment"
                                id="newComment" rows="1" placeholder="Add a comment..."
                                class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary  "></textarea>
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
import { usePage } from '@inertiajs/inertia-vue3';
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
        isSending.value = false
        getComments()

    }).catch(err => console.error(err))
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
