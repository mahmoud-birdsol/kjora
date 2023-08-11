<script setup>
import Avatar from "@/Components/Avatar.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import DateTranslation from "@/Components/DateTranslation.vue";
import EmojiPickerElement from "@/Components/EmojiPickerElement.vue";
import LikeButton from "@/Components/LikeButton.vue";
import LikesModal from "@/Components/LikesModal.vue";
import MentionTextArea from "@/Components/MentionTextArea.vue";
import { useCommentStore, usePostStore, useUserStore } from "@/stores";
import { FaceSmileIcon, TrashIcon } from "@heroicons/vue/24/outline";
import { PaperAirplaneIcon } from "@heroicons/vue/24/solid";
import { Link, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime.js";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";

const props = defineProps(["comment"]);
onBeforeMount(() => {
   dayjs.extend(relativeTime);
});

const commentStore = useCommentStore();
const postStore = usePostStore();
const userStore = useUserStore();
const currentUser = usePage().props.auth.user;
const replyInput = ref(null);
const showReplies = ref(false);
const hasReplies = computed(
   () => props.comment.replies && props.comment.replies.length > 0
);
const newReply = ref("");
const showReplyInput = ref(false);
const isSending = ref(false);
const showEmojiPicker = ref(false);
const EmojiPickerClass = ref("");
const showDeleteCommentModal = ref(false);
const commentsLikeCount = ref(props.comment.likes_count);
const showLikesModal = ref(false);
/** @type{import('vue').Ref<HTMLElement>} */
const commentsComp = ref(null);

const isCurrentUser = currentUser.id === props.comment.user.id;
const isPublic = usePage().url.includes("public/posts");
const isParentComment = !props.comment.parent_id;

onMounted(() => {
   let id = route().params?.commentId;
   if (props.comment.id === +id) {
      postStore.commentsContainer.scrollIntoView({
         behavior: "smooth",
         block: "center",
      });
      commentsComp.value.scrollIntoView({
         behavior: "smooth",
         block: "center",
      });
      commentsComp.value.classList.add("first-appear");
   }
});

defineExpose({
   showReplies,
});

watch(
   () => props.comment.replies.length,
   (newLength, oldLength) => {
      showReplies.value = true;
   }
);

const guidesClassesBefore = computed(() => {
   return hasReplies.value
      ? "before:absolute  ltr:before:-left-9 rtl:before:-right-9   before:w-px   before:bg-stone-200  before:z-[1] before:top-0 before:bottom-[8px]   "
      : " ";
});
const guidesClassesAfter = computed(() => {
   return hasReplies.value
      ? !showReplies.value
         ? " after:absolute after:h-px after:w-8  after:bg-stone-200   ltr:after:-left-9 rtl:after:-right-9 after:bottom-[8px] "
         : " after:absolute after:h-px after:w-8  after:bg-stone-200   ltr:after:-left-9 rtl:after:-right-9 after:bottom-[8px]"
      : "";
});
const guidesClassesAfter2 = computed(() => {
   return props.comment.parent_id
      ? " after:absolute after:h-px after:w-8  after:bg-stone-200  after:z-[-1] ltr:after:-left-9 rtl:after:-right-9 after:top-5 "
      : "";
});

const handleBody = computed(() => {
   const commentBody = props.comment.body;
   if (!commentBody.includes("@")) return props.comment.body;
   const allWords = commentBody.split(" ");
   return allWords
      .map((word) => {
         if (!word.startsWith("@")) return word;
         if (!userStore.users.some((user) => user.username === word.slice(1)))
            return `${word}`;
         else
            return `<a href="/player/name/${word.slice(
               1
            )}" class="text-primary" dir="ltr">${word}</a>`;
      })
      .join(" ");
});
function toggleRepliesView() {
   showReplies.value = !showReplies.value;
}

function addReply() {
   if (!newReply.value || newReply.value.trim() === "") return;
   isSending.value = true;
   // sendReply();
   commentStore.storeComment(
      {
         commentable_id: props.comment.commentable_id,
         commentable_type: props.comment.commentable_type,
         body: newReply.value,
         user_id: currentUser.id,
         //infinte depth
         parent_id: props.comment.id,
      },
      {
         onSuccess: () => {
            newReply.value = "";
            showReplyInput.value = false;
         },
         onFinish: () => {
            isSending.value = false;
         },
         only: ["post"],
      }
   );
}

function deleteComment() {
   showDeleteCommentModal.value = false;
   commentStore.deleteComment(props.comment, {
      only: ["post"],
   });
}

function handleReplyClicked(e) {
   showReplyInput.value = true;
   setTimeout(() => {
      replyInput.value.focus();
   }, 0);
}

function onSelectEmoji(emoji) {
   newReply.value += emoji;
   showReplyInput.value = true;
}

// hide the input field when blur if it is empty
function handleBlur(e) {
   showReplyInput.value = false;
   // if ((showReplyInput.value = true)) {

   //    !newReply.value || newReply.value === ""
   //       ? (showReplyInput.value = false)
   //       : null;
   // }
}

function toggleEmojiPicker(e) {
   let parentOffset = postStore.commentsContainerOffset;
   let emojiButtonOffset =
      e.target.getBoundingClientRect().top + window.scrollY;
   let emojiPickerHeight = 320;
   emojiButtonOffset - parentOffset > emojiPickerHeight
      ? (EmojiPickerClass.value = "bottom-full")
      : (EmojiPickerClass.value = "top-full");

   showEmojiPicker.value = !showEmojiPicker.value;
}
</script>

<template>
   <!-- comment  -->
   <div
      ref="commentsComp"
      :data-comment-id="comment.id"
      class="grid grid-cols-[min-content_1fr] w-full justify-start gap-4 pt-2"
      :class="comment.parent_id ? 'bg-white' : ''"
   >
      <!-- image col 1 -->
      <div class="min-w-max z-[10] relative" :class="guidesClassesAfter2">
         <Avatar
            :id="comment.user.id"
            :username="comment.user.name"
            :image-url="comment.user.avatar_url"
            :size="'md'"
            :border="true"
            border-color="primary"
         />
      </div>
      <!-- comment information col 2 -->
      <div
         class="relative flex flex-col max-w-full gap-1"
         :class="[guidesClassesBefore, guidesClassesAfter]"
      >
         <!-- user information & comment time row 1-->
         <div class="flex flex-col justify-between w-full xs:flex-row">
            <!-- user information -->
            <div class="flex flex-row gap-1 md:flex-col">
               <div class="flex flex-row gap-2">
                  <h3
                     class="m-0 text-sm font-bold leading-none capitalize sm:text-lg text-stone-800"
                  >
                     {{ comment.user.name }}
                  </h3>
                  <span v-if="false">star icon</span>
               </div>
               <Link
                  class="text-xs text-stone-400"
                  :href="route('player.profile', comment.user.id)"
                  >@{{ comment.user.username }}
               </Link>
            </div>
            <!-- date and time -->
            <div
               class="flex flex-row gap-2 text-[8px] ltr:origin-right rtl:origin-left text-neutral-400/90"
            >
               <span>
                  <DateTranslation type="range" :start="comment.created_at" />
               </span>
               <span>|</span>
               <DateTranslation format="hh:mm A" :start="comment.created_at" />
            </div>
         </div>
         <!-- comment or reply body  row 2-->
         <div class="w-full">
            <p
               class="w-full text-sm break-all whitespace-pre-wrap text-stone-800"
               v-html="handleBody"
            />
         </div>
         <!-- add reply & like buttons row 3 -->
         <div
            class="flex items-center justify-start w-full gap-2 mb-2 text-sm font-semibold text-stone-700"
         >
            <template v-if="!isPublic">
               <button
                  v-if="isCurrentUser"
                  @click="showDeleteCommentModal = true"
                  class="p-1 transition-all duration-150 pis-0 enabled:hover:underline hover:underline-offset-4"
               >
                  <TrashIcon class="w-4" />
                  <!-- confirm delete media modal -->
                  <ConfirmationModal
                     :show="showDeleteCommentModal"
                     @close="showDeleteCommentModal = false"
                     @delete="deleteComment"
                  >
                     <template #body>
                        <span>{{
                           $t("are-you-sure-you-want-delete-this-comment")
                        }}</span>
                     </template>
                  </ConfirmationModal>
               </button>
               <button
                  @click="handleReplyClicked"
                  class="p-1 transition-all duration-150 pis-0"
               >
                  {{ comment.replies.length > 0 ? comment.replies.length : "" }}
                  {{ $t("reply") }}
               </button>

               <div class="flex items-center">
                  <!-- <span class="text-sm">{{ commentsLikeCount }}</span> -->
                  <button
                     v-show="commentsLikeCount > 0"
                     @click="showLikesModal = true"
                  >
                     <span class="text-sm">{{ commentsLikeCount }}</span>
                     <LikesModal
                        :show="showLikesModal"
                        :users="comment.likes?.map((like) => like.user)"
                        @close="showLikesModal = false"
                     />
                  </button>
                  <LikeButton
                     :can-like="!isCurrentUser"
                     :isLiked="comment?.is_liked"
                     :likeable_id="comment.id"
                     :likeable_type="'App\\Models\\Comment'"
                     @like="commentsLikeCount++"
                     @disLike="commentsLikeCount--"
                  >
                     <template v-slot="{ isLiked }">
                        <div
                           class="transition-all duration-150"
                           :class="isLiked ? 'text-primary' : ''"
                        >
                           {{
                              commentsLikeCount <= 1 ? $t("like") : $t("likes")
                           }}
                        </div>
                     </template>
                  </LikeButton>
               </div>
            </template>
            <template v-else>
               <template v-if="commentsLikeCount > 0">
                  <button @click="showLikesModal = true">
                     <span class="text-sm">{{ commentsLikeCount }}</span>
                     <LikesModal
                        :show="showLikesModal"
                        :users="comment.likes?.map((like) => like.user)"
                        @close="showLikesModal = false"
                     />
                  </button>
                  <div class="transition-all duration-150">
                     {{ commentsLikeCount <= 1 ? $t("like") : $t("likes") }}
                  </div>
               </template>
            </template>
         </div>

         <!-- replies related to this comment row 4 -->
         <div v-show="showReplies" class="mt-2">
            <template v-for="(reply, index) in comment.replies" :key="reply.id">
               <Comment :comment="reply" />
            </template>
         </div>
         <!-- new reply form row 5 -->
         <OnClickOutside @trigger="handleBlur">
            <div
               v-show="showReplyInput"
               class="flex flex-row items-center self-end w-full p-3 gap-x-3"
            >
               <OnClickOutside @trigger="showEmojiPicker = false">
                  <div class="relative flex items-center">
                     <button
                        @click="toggleEmojiPicker"
                        :data-cancel-blur="true"
                     >
                        <FaceSmileIcon class="w-6 text-neutral-400" />
                     </button>
                     <div
                        class="absolute z-[1000] ltr:left-full rtl:right-full"
                        :class="EmojiPickerClass"
                        v-show="showEmojiPicker"
                     >
                        <EmojiPickerElement @selected-emoji="onSelectEmoji" />
                     </div>
                  </div>
               </OnClickOutside>
               <MentionTextArea
                  @addText="addReply"
                  v-model:newText="newReply"
               />

               <button
                  @click="addReply"
                  :disabled="isSending"
                  class="p-1 group"
               >
                  <PaperAirplaneIcon
                     class="w-5 group-hover:text-neutral-700 rtl:rotate-180"
                     :class="
                        isSending ? 'text-neutral-200' : 'text-neutral-400'
                     "
                  />
               </button>
            </div>
         </OnClickOutside>
         <!-- view replies button row 6 -->
         <button
            v-show="hasReplies"
            @click="toggleRepliesView"
            class="flex justify-start w-full gap-2 text-sm transition-all duration-300 text-stone-500 enabled:hover:underline hover:underline-offset-4"
         >
            {{ showReplies ? $t("hide") : $t("view") }}
            {{ comment.replies?.length }} {{ $t("replies") }}
         </button>
      </div>
   </div>
</template>

<style scoped></style>
