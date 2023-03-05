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
                                    <Link :href="route('player.profile', user.id)" class="text-xs text-stone-400 ">@{{
                                        user.username }}</Link>
                                </div>
                                <div v-if="isCurrentUser" class="relative">
                                    <button class="p-1" @click="showOptions = !showOptions">
                                        <EllipsisHorizontalIcon class="w-6" />
                                    </button>
                                    <FadeInTransition>
                                        <!-- media option menu -->
                                        <div v-show="showOptions"
                                            class="absolute z-20 px-6 py-2 text-xs text-white top-0 right-8 bg-black border rounded-xl border-neutral-500 pie-10 z-2 ">
                                            <ul class="flex flex-col justify-center gap-y-2">
                                                <button class="hover:text-gray-400 group" @click="editCaption">
                                                    <li class="flex items-center  gap-x-2">
                                                        <PencilIcon class=" w-4" />
                                                        <span>Edit</span>
                                                    </li>
                                                </button>
                                                <button @click="openRemoveMediaModal" class="hover:text-gray-400 ">
                                                    <li class="flex items-center justify-center gap-x-2">
                                                        <TrashIcon class="w-4" />
                                                        <span> delete</span>
                                                    </li>
                                                    <!-- confirm delete media modal -->
                                                    <Modal :show="showDeleteMediaModal"
                                                        @close="showDeleteMediaModal = false" :closeable="true"
                                                        :show-close-icon="false" :max-width="'sm'">
                                                        <div class="text-stone-800 p-6 flex flex-col justify-center ">
                                                            <p class="mb-3 text-lg">Are you sure you want delete this
                                                                media?</p>
                                                            <div class="flex gap-4 w-full justify-center">
                                                                <button
                                                                    class="p-2 px-8 border-primary border-2 hover:bg-primary text-primary hover:text-white active:scale-95 rounded-full "
                                                                    @click="showDeleteMediaModal = false">Cancel</button>
                                                                <button
                                                                    class="p-2 px-8 border-red-800 border-2 bg-red-800 hover:bg-transparent hover:text-red-800 text-white active:scale-95  rounded-full "
                                                                    @click="removeMedia">Delete</button>

                                                            </div>
                                                        </div>
                                                    </Modal>
                                                </button>

                                            </ul>
                                        </div>
                                    </FadeInTransition>

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
                                <p class="text-sm text-stone-500" v-show="!isEditingCaption">
                                    {{ caption }}
                                </p>
                                <div v-show="isEditingCaption" class="flex">
                                    <textarea rows="4" type="text" :value="caption" @blur="submit"
                                        class="text-sm text-stone-500 w-full ring-1 focus:ring-primary focus:shadow-none focus:border-none border-none ring-gray-300 hideScrollBar" />
                                </div>
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

                            <textarea @keypress.enter.exact.prevent="addComment" v-model="newComment" name="newComment"
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
import { FaceSmileIcon, EllipsisHorizontalIcon, TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import { PaperAirplaneIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';
import { onMounted, onBeforeMount, ref } from 'vue';
import Comment from '../../Components/Comment.vue';
import { HeartIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import FadeInTransition from '../../Components/FadeInTransition.vue';
import Modal from '../../Components/Modal.vue';


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
let isEditingCaption = ref(false);
const currentUser = usePage().props.value.auth.user
const isCurrentUser = currentUser.id === props.user.id
const showDeleteMediaModal = ref(false);
const caption = ref('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora repellendus earum magni quia fugiat, enim deserunt labore tenetur praesentium.Impedit neque nihil ullam perferendis praesentium eos, molestiae amet deleniti sequi  ')


//comment logic

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


// option menu logic
// delete media
function removeMedia() {
    axios.delete(route('api.gallery.destroy', props.media.id)).then((res) => console.log(res))
}

function openRemoveMediaModal() {
    showOptions.value = false
    showDeleteMediaModal.value = true
}
// edit media caption
function editCaption() {
    showOptions.value = false
    isEditingCaption.value = true
}
function submit() {
    isEditingCaption.value = false
    console.log('has submit')
}
</script>

<style lang="scss" scoped></style>
