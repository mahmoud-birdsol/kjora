<script setup>
import Avatar from "@/Components/Avatar.vue";
import EmojiPickerElement from "@/Components/EmojiPickerElement.vue";
import MediaPreview from "@/Components/MediaPreview.vue";
import useGetFileType from "@/Composables/useGetFileType.js";
import { useUserStore } from "@/stores";
import { useChat } from "@/stores/chat";
import { FaceSmileIcon } from "@heroicons/vue/24/outline";
import {
   ArrowUpCircleIcon,
   PaperAirplaneIcon,
   PhotoIcon,
   XMarkIcon,
} from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import UploadChatFile from "./UploadChatFile/Index.vue";

const props = defineProps({
   conversation: {
      required: true,
      type: Object,
   },
   player: {
      required: true,
      type: Object,
   },
});
const showEmojiPicker = ref(false);
const chat = useChat();
const openUploadModal = ref(false);
const userStore = useUserStore();

// TODO: message body character count based on current screen
// TODO: view should determine the number of rows with a max number
// TODO: of rows before activating scroll.

const removePhoto = (i) => {
   chat.filesData.splice(i, 1);
   chat.formCreateMessage.attachments.splice(i, 1);
};

function onSelectEmoji(emoji) {
   chat.formCreateMessage.body += emoji;
}
</script>
<template>
   <div class="grid p-6 bg-white gap-y-4 rounded-2xl">
      <!--The gray section to display attachment or a message I am replying to. -->
      <div v-loading="chat.isSendingMsg">
         <Transition
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
         >
            <div
               v-if="chat.repliedMessage"
               class="relative flex flex-row items-center justify-between w-full px-2 py-2 text-sm bg-gray-100 group rounded-xl"
            >
               <div
                  v-if="chat.repliedMessage"
                  class="flex items-center justify-start space-x-4"
               >
                  <Avatar
                     :id="chat.repliedMessage.message_sender.id"
                     :image-url="chat.repliedMessage.message_sender.avatar_url"
                     :username="chat.repliedMessage.message_sender.name"
                     :border="true"
                     border-color="primary"
                     size="sm"
                  />
                  <div class="font-bold capitalize text-primary pis-3">
                     <div>
                        {{
                           chat.repliedMessage.sender_id ===
                           userStore.currentUser.id
                              ? userStore.currentUser.name
                              : player.name
                        }}
                     </div>

                     <Link
                        class="text-xs font-normal text-gray-600"
                        :href="
                           route(
                              'player.profile',
                              chat.repliedMessage.message_sender.id
                           )
                        "
                        >@{{
                           chat.repliedMessage.message_sender.username
                        }}</Link
                     >
                  </div>
                  <div class="max-w-[70ch] truncate">
                     {{ chat.repliedMessage.body }}
                  </div>
               </div>
               <div>
                  <div class="text-black max-w-[15rem]">
                     <div v-if="chat.repliedMessage.attachments.length">
                        <MediaPreview
                           :fileType="
                              useGetFileType(
                                 chat.repliedMessage.attachments[0].mime_type,
                                 chat.repliedMessage.attachments[0].original_url
                              ).type
                           "
                           :filePreview="
                              chat.repliedMessage.attachments[0].original_url
                           "
                           :fileName="
                              chat.repliedMessage.attachments[0].file_name
                           "
                        />
                     </div>
                  </div>
               </div>
               <button
                  @click.prevent="chat.setMessageToReplyTo(null)"
                  class="absolute top-0 left-0 bg-white bg-opacity-90 rounded-br-xl"
               >
                  <div
                     class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                  >
                     <XMarkIcon class="w-5 h-5 text-stone-800" />
                  </div>
               </button>
            </div>
         </Transition>

         <transition
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            enter-active-class="transition-all duration-150 ease-out"
            leave-active-class="transition-all duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
         >
            <div class="mt-4">
               <div
                  v-if="chat.filesData"
                  class="grid grid-cols-4 gap-2 ml-auto overflow-hidden overflow-y-auto max-h-32 hideScrollBar place-items-center"
               >
                  <!-- {{ form.attachments }} -->
                  <template v-for="(file, index) in chat.filesData">
                     <div class="relative w-full">
                        <MediaPreview
                           :fileType="file.type"
                           :filePreview="file.previewUrl"
                           :fileName="file.name"
                        />
                        <button
                           @click.prevent="removePhoto(index)"
                           class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl"
                        >
                           <div
                              class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                           >
                              <XMarkIcon class="w-5 h-5 text-stone-800" />
                           </div>
                        </button>
                     </div>
                  </template>
               </div>
            </div>
         </transition>
      </div>

      <div class="flex flex-row items-center w-full gap-x-3">
         <OnClickOutside
            class="hidden sm:block"
            @trigger="showEmojiPicker = false"
         >
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
         <div class="flex items-center flex-grow p-1 rounded-full bg-stone-100">
            <textarea
               v-model="chat.formCreateMessage.body"
               @keypress.enter.exact.prevent="chat.sendMsg()"
               name="body"
               id="body"
               rows="1"
               :placeholder="$t('Type your Message Here')"
               class="w-full p-2 px-4 border-none rounded-full resize-none max-sm:placeholder:text-xs focus:ring-primary bg-stone-100 placeholder:text-neutral-400 text-stone-700 hideScrollBar"
            ></textarea>
         </div>
         <button class="relative" @click="openUploadModal = true">
            <PhotoIcon class="w-6 h-6 text-neutral-400" />
            <span class="absolute bottom-0 rounded-full bg-white -right-[1px]">
               <UploadChatFile
                  :show="openUploadModal"
                  @close="openUploadModal = false"
               />
               <ArrowUpCircleIcon class="w-2 h-2 text-neutral-400" />
            </span>
         </button>
         <button
            :disabled="chat.isSendingMsg"
            class="p-1 group"
            @click="chat.sendMsg()"
         >
            <PaperAirplaneIcon
               class="w-5 rtl:rotate-180"
               :class="
                  chat.isSendingMsg ? 'text-neutral-400' : 'text-neutral-900'
               "
            />
         </button>
      </div>
   </div>
</template>
