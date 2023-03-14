<template>
    <AppLayout title="gallery">
        <template #header>
            <p>{{$t('post')}}</p>
        </template>

        <div class="px-4 py-4 bg-white sm:px-8 rounded-3xl">
            <div class="grid w-full h-full gap-3 border lg:grid-cols-2 rounded-2xl border-stone-400 ">

                <!-- image and caption left col -->
                <div class="flex flex-col max-w-full gap-6 p-3 ">
                    <!-- image -->

                    <Splide dir="ltr" class="" :options="options">
                        <template v-for="media in post.media" :key="media.id">
                            <SplideSlide class="">
                                <div class="flex justify-center overflow-hidden group rounded-3xl aspect-video ">
                                    <img v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')"
                                        :src="media.original_url" alt="" class="object-contain h-full ">
                                    <video v-if="media.mime_type.startsWith('video')" controls :src="media.original_url"
                                        alt="" class="object-contain h-full " />
                                    <!-- delete single media -->
                                    <!-- <button v-if="currentUser.id === user.id"
                                        @click.prevent.stop="showDeleteMediaModal = true"
                                        class="absolute top-0 right-0 hidden bg-white group-hover:block bg-opacity-90 rounded-bl-xl">
                                        <div class="flex flex-col items-start justify-center h-full p-1 opacity-100 ">
                                            <XMarkIcon class="w-5 h-5 text-stone-800" />
                                        </div>
                                        <Modal :show="showDeleteMediaModal" @close="showDeleteMediaModal = false"
                                            :closeable="true" :show-close-icon="false" :max-width="'sm'">
                                            <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                                <p class="mb-3 text-lg">Are you sure you want delete this
                                                    post ?</p>
                                                <div class="flex justify-center w-full gap-4">
                                                    <button
                                                        class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                                        @click="showDeleteMediaModal = false">Cancel</button>
                                                    <button
                                                        class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                                        @click="removeSingleMedia(media.id)">Delete Media</button>

                                                </div>
                                            </div>
                                        </Modal>
                                    </button> -->
                                </div>
                            </SplideSlide>
                        </template>
                    </Splide>

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

                                        <h3 class="m-0 text-lg font-bold leading-none capitalize ">{{ user.name
                                        }} </h3>
                                        <span v-if="false">star icon</span>
                                    </div>
                                    <Link :href="route('player.profile', user.id)" class="text-xs text-stone-400 ">@{{
                                        user.username }} </Link>
                                </div>
                                <div class="fixed top-0 left-0 w-full h-full" v-show="showOptions"
                                    @click="showOptions = false"></div>
                                <div class="relative">
                                    <button class="p-1" @click="showOptions = !showOptions">
                                        <EllipsisHorizontalIcon class="w-6" />
                                    </button>
                                    <FadeInTransition>
                                        <!-- media option menu -->
                                        <div v-show="showOptions"
                                            class="absolute top-0 z-20 px-6 py-2 text-xs text-white bg-black border right-8 rounded-xl border-neutral-500 pie-10 z-2 ">
                                            <ul class="flex flex-col justify-center gap-y-2">
                                                <button class="hover:text-gray-400 group" @click="editCaption">
                                                    <li class="flex items-center gap-x-2">
                                                        <PencilIcon class="w-4 " />
                                                        <span>Edit</span>
                                                    </li>
                                                </button>
                                                <button @click="openRemoveMediaModal" class="hover:text-gray-400 "
                                                    v-if="isCurrentUser">
                                                    <li class="flex items-center justify-center gap-x-2">
                                                        <TrashIcon class="w-4" />
                                                        <span> Delete</span>
                                                    </li>
                                                    <!-- confirm delete media modal -->
                                                    <Modal :show="showDeletePostModal" @close="showDeletePostModal = false"
                                                        :closeable="true" :show-close-icon="false" :max-width="'sm'">
                                                        <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                                            <p class="mb-3 text-lg">{{$t('Are you sure you want delete this media?')}}</p>
                                                            <div class="flex justify-center w-full gap-4">
                                                                <button
                                                                    class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                                                    @click="showDeletePostModal = false">{{$t('Cancel')}}</button>
                                                                <button
                                                                    class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                                                    @click="removePost">{{$t('Delete Post')}}</button>

                                                                <div v-show="showOptions"
                                                                    class="absolute left-0 p-2 bg-white ro unded-lg shadow-lg cursor-pointer top-1/2">
                                                                    <div class="fixed top-0 left-0 w-full h-full"
                                                                        @click="showOptions = false">
                                                                    </div>
                                                                    <div
                                                                        class="relative z-20 w-full text-sm text-center text-gray-500 divide-y whitespace-nowrap">
                                                                        <div @click="isEditingCaption = true">{{$t('edit')}}</div>
                                                                        <div>{{$t('remove photo')}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </Modal>
                                                </button>
                                                <button class="hover:text-gray-400 group">
                                                    <li v-if="!isCurrentUser">
                                                        <ReportModal :reportable-id="media.id"
                                                            :reportable-type="'App\\Models\\MediaLibrary'">
                                                            <template #trigger>
                                                                <button class="flex items-center gap-x-2">
                                                                    <FlagIcon class="w-4" />
                                                                    <span>{{$t('report')}}</span>
                                                                </button>

                                                            </template>
                                                        </ReportModal>
                                                    </li>

                                                </button>

                                            </ul>
                                        </div>
                                    </FadeInTransition>


                                </div>
                            </div>
                            <!-- date and time and likes row 2-->
                            <div class="flex justify-between w-full gap-2 text-sm text-stone-700">
                                <div class="flex flex-row gap-2">
                                    <span>{{ dayjs(post.created_at).fromNow(true) }}</span>
                                    <span>|</span>
                                    <span>{{ dayjs(post.created_at).format('hh:mm A')
                                    }}</span>

                                </div>

                                <div class="flex items-center gap-1"><span class="text-sm">{{ post?.likes_count }}</span>
                                    <LikeButton :isLiked="post?.is_liked" :likeable_id="post.id"
                                        :likeable_type="'App\\Models\\Post'">
                                        <template v-slot="{ isLiked }">
                                            <HeartIcon class="w-5 stroke-current stroke-2 text-primary"
                                                :class="isLiked ? 'fill-current' : 'fill-transparent'" />
                                        </template>
                                    </LikeButton>

                                </div>
                            </div>
                            <!-- caption row 3 -->
                            <div>
                                <p class="text-sm text-stone-500" v-show="!isEditingCaption">
                                    {{ captionForm.caption }}
                                </p>
                                <div v-show="isEditingCaption" class="flex flex-col justify-end gap-3">
                                    <textarea rows="4" type="text" v-model='captionForm.caption'
                                        class="w-full text-sm border-none rounded-lg resize-none text-stone-500 ring-1 focus:ring-primary focus:shadow-none focus:border-none ring-gray-300 hideScrollBar" />
                                    <PrimaryButton @click="submitEditCaption" class=''>{{$t('Save')}}</PrimaryButton>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- comment and replies right col -->
                <div class="flex flex-col h-full gap-2 max-lg:border-t lg:border-l border-stone-300">
                    <!-- header -->
                    <div class=" pt-5 p-3 text-sm border-b border-stone-300"> {{ $t('comments ( :count )', {count: numComments})  }}
                    </div>
                    <!-- comments -->
                    <div class="self-stretch h-full p-3 px-6 ">
                        <div ref="commentsContainer"
                            class="flex flex-col gap-4 w-full max-h-[500px] hideScrollBar overflow-auto" v-if="comments">
                            <template v-for="comment in comments.filter(c => !c.parent_id)" :key="comment.id">
                                <Comment @addedReply="() => handleAddedReply()" :comment="comment">
                                </Comment>
                            </template>
                        </div>
                    </div>
                    <!-- new comment form -->
                    <div class="flex flex-row items-center self-end w-full p-3 border-t gap-x-3 border-stone-300">
                        <OnClickOutside @trigger="showEmojiPicker = false">
                            <div class="relative flex items-center">
                                <button @click="showEmojiPicker = !showEmojiPicker" :data-cancel-blur="true">
                                    <FaceSmileIcon class="w-6 text-neutral-400" />
                                </button>
                                <div class="absolute z-20 bottom-full left-full " v-show="showEmojiPicker">
                                    <EmojiPickerElement @selected-emoji="onSelectEmoji" />
                                </div>
                            </div>
                        </OnClickOutside>
                        <div class="flex items-center flex-grow ">

                            <textarea @keypress.enter.exact.prevent="(e) => addComment()" v-model="newComment"
                                name="newComment" id="newComment" rows="1" placeholder="Add a comment..."
                                class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary "></textarea>
                        </div>

                        <button @click="(e) => addComment()" :disabled="isSending" class="p-1 group ">
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

import { FaceSmileIcon, EllipsisHorizontalIcon, TrashIcon, PencilIcon, FlagIcon } from '@heroicons/vue/24/outline';
import { PaperAirplaneIcon, XMarkIcon } from '@heroicons/vue/24/solid';

import axios from 'axios';
import { onMounted, onBeforeMount, ref  , computed} from 'vue';
import Comment from '../../Components/Comment.vue';
import { HeartIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';
import FadeInTransition from '../../Components/FadeInTransition.vue';
import Modal from '../../Components/Modal.vue';
import ReportModal from '@/Components/ReportModal.vue';
import { Inertia } from '@inertiajs/inertia';
import LikeButton from '@/Components/LikeButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import EmojiPickerElement from '../../Components/EmojiPickerElement.vue';

onBeforeMount(() => {
    dayjs.extend(relativeTime)
});

const props = defineProps({
    user: null,
    post: null
})

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


const comments = ref([])
const commentsContainer = ref(null);
const newComment = ref('');
const isSending = ref(false);
let showOptions = ref(false)
let isEditingCaption = ref(false);
const currentUser = usePage().props.value.auth.user
const isCurrentUser = currentUser.id === props.user.id
const showDeleteMediaModal = ref(false);
const showDeletePostModal = ref(false);
const showEmojiPicker = ref(false)

//comment logic

onMounted(() => {
    getPostComments()
});

function getPostComments() {
    axios.get(route('api.gallery.comments'), {
        params: {
            commentable_id: props.post.id,
            commentable_type: 'App\\Models\\Post'
        }
    }).then(res => {
        comments.value = res.data.data
    }).catch(err => console.error(err))
}
function submit() {
    console.log('has submit')
}


// store new comments in database
function sendComment() {
    axios.post(route('api.gallery.comments.store'), {
        commentable_id: props.post.id,
        commentable_type: 'App\\Models\\Post',
        body: newComment.value,
        user_id: currentUser.id,
        parent_id: null
    }).then(res => {
        getPostComments()
        scrollToCommentsBottom()

    }).catch(err => console.error(err)).finally(() => {
        isSending.value = false
    })
}

// add new comment
function addComment() {
    if (!newComment.value || newComment.value.trim() === '') return
    isSending.value = true
    sendComment()
}

// get comment again when reply added [partial reload]
function handleAddedReply() {
    getPostComments()
}

// helper function to scroll comments container to bottom
function scrollToCommentsBottom() {
    setTimeout(() => {
        commentsContainer.value.scrollTo({
            top: commentsContainer.value.scrollHeight,
            left: 0,
            behavior: "smooth",
        });
    }, 200);
}

function onSelectEmoji(emoji) {
    newComment.value += emoji
}

// option menu logic
// delete media
// function removeSingleMedia(id) {
//     axios.delete(route('api.gallery.destroy', id)).then((res) => console.log(res))

//     showDeleteMediaModal.value = false
//     Inertia.reload({
//         only: ['post'],
//     });
// }

function openRemoveMediaModal() {
    showOptions.value = false
    showDeletePostModal.value = true
}
// edit media caption
function editCaption() {
    showOptions.value = false
    isEditingCaption.value = true
}

let captionForm = useForm({
    caption: props.post.caption
})
function submitEditCaption() {
    captionForm.patch(route('posts.update', props.post), {
        preserveScroll: true,
        preserveState: true
    })
    isEditingCaption.value = false
}

function removePost() {

    showDeletePostModal.value = false
    Inertia.delete(route('posts.destroy', props.post.id), {
    })

}
let numComments  =computed(()=> comments.value ? comments.value.filter(c => !c.parent_id )?.length : 0 )
</script>

<style lang="scss" scoped></style>