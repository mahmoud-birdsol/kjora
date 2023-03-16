<template>
    <OnClickOutside @trigger="showEmojiPicker = false">
        <div class="relative flex items-center">
            <button @click="showEmojiPicker = !showEmojiPicker" :data-cancel-blur="true">
                <FaceSmileIcon class="w-6 text-neutral-400" />
            </button>
            <div class="absolute z-20 bottom-full ltr:left-full rtl:right-full" v-show="showEmojiPicker">
                <EmojiPickerElement @selected-emoji="onSelectEmoji" />
            </div>
        </div>
    </OnClickOutside>
    <div class="flex items-center flex-grow ">

        <textarea @keypress.enter.exact.prevent="(e) => addComment()" v-model="newComment" name="newComment" id="newComment"
            rows="1" :placeholder="$t('Add a comment...')"
            class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 bg-stone-100 text-stone-700 focus:ring-1 focus:ring-primary "></textarea>
    </div>

    <button @click="(e) => addComment()" :disabled="isSending" class="p-1 group ">
        <PaperAirplaneIcon class="w-5 group-hover:text-neutral-700"
            :class="isSending ? 'text-neutral-200' : 'text-neutral-400'" />
    </button>
</template>

<script setup>
import { FaceSmileIcon } from '@heroicons/vue/24/outline';
import { PaperAirplaneIcon } from '@heroicons/vue/24/solid';
import EmojiPickerElement from '../../Components/EmojiPickerElement.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps(['postId', 'commentsContainer'])
const emits = defineEmits(['addComment'])

const newComment = ref('');
const isSending = ref(false);
const showEmojiPicker = ref(false)
const currentUser = usePage().props.value.auth.user
// store new comments in database
function sendComment() {
    axios.post(route('api.gallery.comments.store'), {
        commentable_id: props.postId,
        commentable_type: 'App\\Models\\Post',
        body: newComment.value,
        user_id: currentUser.id,
        parent_id: null
    }).then(res => {
        emits('addComment')
    }).catch(err => console.error(err)).finally(() => {
        isSending.value = false
        newComment.value = ''
    })
}

// add new comment
function addComment() {
    if (isSending.value) { return }
    if (!newComment.value || newComment.value.trim() === '') return
    isSending.value = true
    sendComment()
}

function onSelectEmoji(emoji) {
    newComment.value += emoji
}



</script>

<style lang="scss" scoped></style>
