<script setup>
import ReportModal from "@/Components/ReportModal.vue";
import Socials from "@/Components/Socials.vue";
import {
   EllipsisHorizontalIcon,
   FlagIcon,
   PencilIcon,
   TrashIcon,
} from "@heroicons/vue/24/outline";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import FadeInTransition from "@/Components/FadeInTransition.vue";

const props = defineProps(["isCurrentUser", "postId"]);
const emits = defineEmits(["editingCaption"]);

const showDeletePostModal = ref(false);
const showOptions = ref(false);
const copiedMsg = ref(false);

function openRemoveMediaModal() {
   showOptions.value = false;
   showDeletePostModal.value = true;
}
// edit media caption
function editCaption() {
   showOptions.value = false;
   emits("editingCaption");
}

function removePost() {
   showDeletePostModal.value = false;
   router.delete(route("posts.destroy", props.postId), {});
}
function showCopied() {
   copiedMsg.value = true;
   showOptions.value = false;
   setTimeout(() => {
      copiedMsg.value = false;
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
                     v-if="isCurrentUser"
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
                     v-if="isCurrentUser"
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
                           :shareUrl="`public/posts/${postId}`"
                           position="-top-1"
                           @showCopied="showCopied"
                        >
                           <template #label>
                              <span> {{ $t("share") }}</span>
                           </template>
                        </Socials>
                     </li>
                  </button>

                  <button class="hover:text-gray-400 group">
                     <li v-if="!isCurrentUser">
                        <ReportModal
                           :reportable-id="postId"
                           :reportable-type="'App\\Models\\Post'"
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
         v-if="copiedMsg"
         >{{ $t("copied") }}!</span
      >
   </div>
</template>

<style scoped></style>
