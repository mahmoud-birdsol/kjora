<script setup>
import EmojiPickerElement from "@/Components/EmojiPickerElement.vue";
import MentionTextArea from "@/Components/MentionTextArea.vue";
import { usePostStore } from "@/stores";
import { FaceSmileIcon } from "@heroicons/vue/24/outline";
import { PaperAirplaneIcon } from "@heroicons/vue/24/solid";
import { ref } from "vue";

const postStore = usePostStore();
const commentInput = ref();
const showEmojiPicker = ref(false);

function onSelectEmoji(emoji) {
   postStore.newComment += emoji;
}
</script>
<template>
   <OnClickOutside @trigger="showEmojiPicker = false">
      <div class="relative flex items-center">
         <button
            @click="showEmojiPicker = !showEmojiPicker"
            :data-cancel-blur="true"
         >
            <FaceSmileIcon class="w-6 text-neutral-400" />
         </button>
         <div
            class="absolute z-20 bottom-full ltr:left-full rtl:right-full"
            v-show="showEmojiPicker"
         >
            <EmojiPickerElement @selected-emoji="onSelectEmoji" />
         </div>
      </div>
   </OnClickOutside>

   <MentionTextArea
      v-model:newText="postStore.newComment"
      @send="postStore.addComment"
      :ref="commentInput"
   />
   <button
      @click="(e) => postStore.addComment()"
      :disabled="postStore.isAddingComment"
      class="p-1 group"
   >
      <PaperAirplaneIcon
         class="w-5 group-hover:text-neutral-700 rtl:rotate-180"
         :class="
            postStore.isAddingComment ? 'text-neutral-200' : 'text-neutral-400'
         "
      />
   </button>
</template>

<style lang="scss" scoped></style>
