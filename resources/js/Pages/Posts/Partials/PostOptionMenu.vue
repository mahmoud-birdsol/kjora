<script setup>
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import FadeInTransition from "@/Components/FadeInTransition.vue";
import ReportModal from "@/Components/ReportModal.vue";
import Socials from "@/Components/Socials.vue";
import { usePostStore } from "@/stores";
import {
   EllipsisHorizontalIcon,
   FlagIcon,
   PencilIcon,
   TrashIcon,
} from "@heroicons/vue/24/outline";
import { ref } from "vue";

const postStore = usePostStore();
const showDeletePostModal = ref(false);
const showOptions = ref(false);
const showCopiedNotice = ref(false);

function openRemoveMediaModal() {
   showOptions.value = false;
   showDeletePostModal.value = true;
}
// edit media caption
function editCaption() {
   showOptions.value = false;
   postStore.isEditingCaption = true;
}

function removePost() {
   showDeletePostModal.value = false;
   postStore.deletePost();
}
function showCopied() {
   showCopiedNotice.value = true;
   showOptions.value = false;
   setTimeout(() => {
      showCopiedNotice.value = false;
   }, 2000);
}
</script>
<template>
   <div class="relative">
      <button class="p-1" @click="showOptions = !showOptions">
         <EllipsisHorizontalIcon class="w-6" />
      </button>
      <OnClickOutside @trigger="showOptions = false">
         <FadeInTransition>
            <!-- media option menu -->
            <div
               v-show="showOptions"
               class="absolute top-0 z-20 px-3 py-2 text-xs text-white bg-black border ltr:right-8 rtl:left-8 rounded-xl border-neutral-500 z-2"
            >
               <ul class="flex flex-col justify-center gap-y-2">
                  <button
                     class="hover:text-gray-400 group"
                     v-if="postStore.isPostUserTheCurrentUser"
                     @click="editCaption"
                  >
                     <li class="flex items-center gap-x-2">
                        <PencilIcon class="w-4" />
                        <span>{{ $t("edit") }}</span>
                     </li>
                  </button>
                  <button
                     @click="openRemoveMediaModal"
                     class="hover:text-gray-400"
                     v-if="postStore.isPostUserTheCurrentUser"
                  >
                     <li class="flex items-center justify-center gap-x-2">
                        <TrashIcon class="w-4" />
                        <span> {{ $t("delete") }}</span>
                     </li>
                     <!-- confirm delete media modal -->
                     <ConfirmationModal
                        :show="showDeletePostModal"
                        @close="showDeletePostModal = false"
                        @delete="removePost"
                     >
                        <template #body>
                           <span>{{
                              $t("are-you-sure-you-want-delete-this-post")
                           }}</span>
                        </template>
                     </ConfirmationModal>
                  </button>
                  <button @click="showShare" class="hover:text-gray-400">
                     <li class="flex items-center justify-center">
                        <Socials
                           :shareUrl="`public/posts/${postStore.post.id}`"
                           position="-top-1"
                           @showCopied="showCopied"
                        >
                           <template #label>
                              <span> {{ $t("share") }}</span>
                           </template>
                        </Socials>
                     </li>
                  </button>
                  <button
                     v-if="!postStore.isPostUserTheCurrentUser"
                     class="hover:text-gray-400 group"
                  >
                     <li>
                        <ReportModal
                           :reportable-id="postStore.post.id"
                           :reportable-type="postStore.POST_MODEL_TYPE"
                        >
                           <template #trigger>
                              <button class="flex items-center gap-x-2">
                                 <FlagIcon class="w-4" />
                                 <span>{{ $t("report") }}</span>
                              </button>
                           </template>
                        </ReportModal>
                     </li>
                  </button>
               </ul>
            </div>
         </FadeInTransition>
      </OnClickOutside>
      <span
         class="absolute bottom-0 p-1 -my-4 text-sm font-bold text-white bg-black rounded ltr:right-0 rtl:left-0 whitespace-nowrap"
         v-if="showCopiedNotice"
         >{{ $t("copied") }}!</span
      >
   </div>
</template>

<style scoped></style>
