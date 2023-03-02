<template>
    <!-- comment  -->
    <div class="grid grid-cols-[min-content_1fr] w-full justify-start gap-4" :class="comment.parent_id ? 'bg-white' : ''">
        <!-- image col 1 -->
        <div class="min-w-max z-[10] relative  " :class="guidesClassesAfter2">
            <Avatar :username="comment.user.name" :image-url="comment.user.avatar_url" :size="'md'" :border="true"
                border-color="primary" />
        </div>
        <!-- comment information col 2 -->
        <div class="flex flex-col gap-1 relative isolate  z-[5] max-w-full "
            :class="[guidesClassesBefore, guidesClassesAfter]">
            <!-- user information & comment time row 1-->
            <div class="flex flex-col xs:flex-row w-full justify-between">
                <!-- user information -->
                <div class="flex flex-col xs:flex-row  gap-1 ">
                    <div class="flex flex-row gap-2">
                        <h3 class="font-bold m-0 text-lg text-stone-800 leading-none  capitalize ">{{
                            comment.user.first_name }} </h3>
                        <span v-if="false">star icon</span>
                    </div>
                    <span class="text-xs text-stone-400 ">@{{ comment.user.username }} </span>
                </div>
                <!-- date and time -->
                <div class="flex flex-row gap-2 text-neutral-400/90 text-xs">
                    <span>{{ dayjs(comment.created_at).fromNow(true) }}</span>
                    <span>|</span>
                    <span>{{ dayjs(comment.created_at).format('hh:mm A') }}</span>
                </div>
            </div>
            <!-- comment or reply body  row 2-->
            <div class="w-full">
                <p class="w-full text-sm text-stone-800 break-words whitespace-pre-line">
                    {{ comment.body }}
                </p>
            </div>
            <!-- add reply & like buttons row 3 -->
            <div class="flex w-full text-sm gap-2 justify-start text-stone-700 font-semibold mb-2">
                <button @click="handleReplyClicked"
                    class="p-1 pis-0 enabled:hover:underline hover:underline-offset-4 transition-all duration-150">Reply</button>
                <button
                    class="p-1 enabled:hover:underline hover:underline-offset-4 transition-all duration-150">Like</button>
            </div>

            <!-- replies related to this comment row 4 -->
            <div v-show="showReplies" class="mt-2">
                <template v-for="(reply, index) in comment.replies" :key="reply.id">
                    <Comment @addedReply="handleAddedReply" :comment="reply" />
                </template>
            </div>
            <!-- new reply form row 5 -->
            <div v-show="showReplyInput" class="flex flex-row p-3 items-center self-end w-full gap-x-3 ">
                <button>
                    <FaceSmileIcon class="w-6 text-neutral-400" />
                </button>
                <div class="flex items-center flex-grow ">

                    <textarea ref="replyInput" @keydown.enter="addReply" @blur="handleBlur" @keydown.esc="handleEsc"
                        v-model="newReply" name="newReply" id="newReply" rows="1" placeholder="Add a comment..."
                        class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:right-1 focus:ring-primary  "></textarea>
                </div>

                <button @click="addReply" :disabled="isSending" class="p-1 group ">

                    <PaperAirplaneIcon class="w-5 group-hover:text-neutral-700"
                        :class="isSending ? 'text-neutral-200' : 'text-neutral-400'" />
                </button>
            </div>
            <!-- view replies button row 6 -->
            <button v-show="hasReplies" @click="toggleRepliesView"
                class="flex w-full text-sm gap-2 justify-start  text-stone-500 enabled:hover:underline hover:underline-offset-4 transition-all duration-300  ">
                {{ showReplies ? 'hide' : 'view' }} {{ comment.replies?.length }} replies
            </button>

        </div>
    </div>
</template>

<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import Avatar from './Avatar.vue';
import { computed, onBeforeMount, ref, watch } from 'vue';
import { FaceSmileIcon } from '@heroicons/vue/24/outline';
import { PaperAirplaneIcon } from '@heroicons/vue/24/solid';
import { usePage } from '@inertiajs/inertia-vue3';
const props = defineProps(['comment'])
onBeforeMount(() => {
    dayjs.extend(relativeTime)
})
const emit = defineEmits(['addedReply'])

const currentUser = usePage().props.value.auth.user
const replyInput = ref(null)
const showReplies = ref(false)
const hasReplies = computed(() => props.comment.replies && props.comment.replies.length > 0);
const newReply = ref(null)
const showReplyInput = ref(false)
const isSending = ref(false)
defineExpose({
    showReplies
})

watch(() => props.comment.replies.length, (newLength, oldLength) => {
    showReplies.value = true
})

const guidesClassesBefore = computed(() => {
    return hasReplies.value ? 'before:absolute  before:-left-9   before:w-px   before:bg-stone-200  before:z-[1] before:top-0 before:bottom-[8px]   '
        : ' '
}); const guidesClassesAfter = computed(() => {
    return (hasReplies.value) ? !showReplies.value ? ' after:absolute after:h-px after:w-8  after:bg-stone-200  after:z-[-1] after:-left-9 after:bottom-[8px] ' : 'after:absolute after:h-px after:w-8  after:bg-stone-200  after:z-[-1] after:-left-9 after:bottom-[8px]' : '';
}); const guidesClassesAfter2 = computed(() => {
    return props.comment.parent_id ?
        ' after:absolute after:h-px after:w-8  after:bg-stone-200  after:z-[-1] after:-left-9 after:top-5 ' : '';
});
function toggleRepliesView() {
    showReplies.value = !showReplies.value
}
function addReply() {
    if (!newReply.value || newReply.value.trim() === '') return
    isSending.value = true;
    sendReply()
    showReplyInput.value = false
    emit('addedReply')
}
const isParentComment = !props.comment.parent_id

// function getParentId() {
//     return isParentComment ? props.comment.id : props.comment.parent_id
// }

function sendReply() {
    axios.post(route('api.gallery.comments.store'), {
        commentable_id: props.comment.commentable_id,
        commentable_type: props.comment.commentable_type,
        body: newReply.value,
        user_id: currentUser.id,
        //infinte depth
        parent_id: props.comment.id
    }).then(res => {
        newReply.value = ''
        isSending.value = false;
    }).catch(err => console.error(err))
}
function handleReplyClicked(e) {
    showReplyInput.value = true
    setTimeout(() => {
        replyInput.value.focus()
    }, 0)
}

function handleAddedReply() {
    emit('addedReply')
    // showReplies.value = true
}


// hide the input field when blur if it is empty
function handleBlur(e) {
    !newReply.value || newReply.value === '' ? showReplyInput.value = false : null
}
function handleEsc(e) {
    console.log('esc')
    !newReply.value || newReply.value === '' ? showReplyInput.value = false : null
}
</script>

<style  scoped></style>
