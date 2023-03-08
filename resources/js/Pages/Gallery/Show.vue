<template>
    <AppLayout title="gallery">
        <template #header>
            <p>posts</p>
        </template>

        <div class="bg-white rounded-3xl  px-2 py-6">
            <Splide dir="ltr" class="" :options="options">
                <template v-for="(media, i) in mediaAndComments" :key="i">
                    <SplideSlide class="px-14">
                        <div class="w-full grid lg:grid-cols-2 gap-3  border rounded-2xl border-stone-400   ">

                            <!-- image and caption left col -->
                            <div class=" flex flex-col gap-6 max-w-full  p-3 ">
                                <!-- image -->
                                <div class="rounded-3xl  sm:aspect-video overflow-hidden flex justify-center">
                                    <img v-if="media.media.mime_type.startsWith('image') || media.media.mime_type.startsWith('webp')"
                                        :src="media.media.original_url" alt="" class="h-full  object-contain  ">
                                    <video v-if="media.media.mime_type.startsWith('video')" controls
                                        :src="media.media.original_url" alt="" class="object-cover   " />
                                </div>
                                <!-- information -->
                                <div class="grid xs:grid-cols-[min-content_1fr] gap-4">
                                    <!-- col 1 -->
                                    <div class="min-w-max ">
                                        <Avatar :username="user.name" :image-url="user.avatar_url" :size="'lg'"
                                            :border="true" border-color="primary" />
                                    </div>
                                    <!-- col 2 -->
                                    <div class="flex flex-col gap-3">
                                        <!-- user information row 1-->
                                        <div class="flex w-full justify-between">
                                            <div class="flex flex-col gap-1 ">
                                                <div class="flex flex-row gap-2">
                                                    <h3 class="font-bold m-0 text-lg leading-none  capitalize ">{{ user.name
                                                    }} </h3>
                                                    <span v-if="false">star icon</span>
                                                </div>
                                                <Link :href="route('player.profile', user.id)"
                                                    class="text-xs text-stone-400 ">@{{
                                                        user.username }} </Link>
                                            </div>
                                            <div class="relative">
                                                <button class="p-1" @click="showOptions = !showOptions">
                                                    <EllipsisHorizontalIcon class="w-6" />
                                                </button>
                                                <div v-show="showOptions"
                                                    class="absolute top-1/2 left-0 shadow-lg p-2 rounded-lg cursor-pointer bg-white">
                                                    <div class="fixed top-0 left-0 w-full h-full"
                                                        @click="showOptions = false">
                                                    </div>
                                                    <div
                                                        class="w-full relative z-20 text-sm text-gray-500 whitespace-nowrap text-center divide-y">
                                                        <div @click="contenteditable = true">Edit</div>
                                                        <div>remove photo</div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- date and time and likes row 2-->
                                        <div class="flex w-full gap-2 text-sm justify-between text-stone-700">
                                            <div class="flex flex-row gap-2">
                                                <span>{{ dayjs(media.media.created_at).fromNow(true) }}</span>
                                                <span>|</span>
                                                <span>{{ dayjs(media.media.created_at).format('hh:mm A') }}</span>

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
                                            <p class="text-sm text-stone-500" v-show="!contenteditable">
                                                aml walaed
                                            </p>
                                            <div v-show="contenteditable" class="flex">
                                                <input type="text" value="aml walaed"
                                                    class="text-sm text-stone-500 w-full ring-1 focus:ring-primary focus:shadow-none focus:border-none border-none ring-gray-300 rounded-full" />
                                                <button class="p-1 group" @click="submit">
                                                    <PaperAirplaneIcon class="text-neutral-900 w-5" />
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- comment and replies right col -->
                            <div class="flex flex-col gap-2 h-full max-lg:border-t lg:border-l border-stone-300">
                                <!-- header -->
                                <div class=" pt-5 p-3 text-sm border-b border-stone-300">comments {{ media.comments &&
                                    media.comments.filter(c =>
                                        !c.parent_id)?.length }}
                                </div>
                                <!-- comments -->
                                <div class="self-stretch p-3 px-6 h-full ">
                                    <div class="flex flex-col gap-4 w-full" v-if="media.comments">
                                        <template v-for="comment in media.comments.filter(c => !c.parent_id)"
                                            :key="comment.id">
                                            <Comment @addedReply="handleAddedReply" :comment="comment"></Comment>
                                        </template>
                                    </div>
                                </div>
                                <!-- new comment form -->
                                <div
                                    class="flex flex-row p-3 items-center self-end w-full gap-x-3 border-t border-stone-300">
                                    <button>
                                        <FaceSmileIcon class="w-6 text-neutral-400" />
                                    </button>
                                    <div class="flex items-center flex-grow ">

                                        <textarea @keypress.enter.exact.prevent="(e) => addComment(media.media.id)"
                                            v-model="newComment" name="newComment" id="newComment" rows="1"
                                            placeholder="Add a comment..."
                                            class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary  "></textarea>
                                    </div>

                                    <button @click="(e) => addComment(media.media.id)" :disabled="isSending" class="p-1 group ">

                                        <PaperAirplaneIcon class="w-5 group-hover:text-neutral-700"
                                            :class="isSending ? 'text-neutral-200' : 'text-neutral-400'" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </SplideSlide>
                </template>
            </Splide>
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
import { Splide, SplideSlide } from "@splidejs/vue-splide";
onBeforeMount(() => {

    dayjs.extend(relativeTime)
});
const props = defineProps({
    user: null,
    post: null
})
console.log(props.post.media);
// slider option
const options = {
    arrows: true,
    rewind: false,
    pagination: false,
    // drag: "free",
    type: 'slide',
    focus: "center",
    perPage: 1,
    perMove: 1,
    snap: true,
    autoplay: false,
};

const mediaAndComments = ref([])
const comments = ref(null);
const newComment = ref(null);
const isSending = ref(false);
let showOptions = ref(false)
let contenteditable = ref(false);
const currentUser = usePage().props.value.auth.user
function getComments() {

    props.post.media.forEach(media => {

        axios.get(route('api.gallery.comments'), {
            params: {
                commentable_id: media.id,
                commentable_type: 'App\\Models\\MediaLibrary'
            }
        }).then(res => {
            comments.value = res.data.data
            mediaAndComments.value.push({
                media: media,
                comments: res.data.data
            })
        }).catch(err => console.error(err))
    });
}
function submit() {
    console.log('has submit')
}

onMounted(() => {
    getComments()
});
function sendComment(mediaId) {
    axios.post(route('api.gallery.comments.store'), {
        commentable_id: mediaId,
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
function addComment(mediaId) {
    console.log(mediaId);
    if (!newComment.value || newComment.value.trim() === '') return
    isSending.value = true
    sendComment(mediaId)
}
function handleAddedReply() {
    getComments();
}
</script>

<style lang="scss" scoped></style>
