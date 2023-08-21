<script setup>
import { useChat } from "@/stores/chat";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { PlayIcon } from "@heroicons/vue/24/solid";
import FadeInTransition from "@/Components/FadeInTransition.vue";
import Crop from "@/Components/Crop.vue";
import VueEasyLightbox from "vue-easy-lightbox";
import { ref } from "vue";
const chat = useChat();
const visibleRef = ref(false);
const imgsRef = ref(null);

const removePhoto = (i) => {
   if (chat.cropFile?.id === chat.filesData[i].id) {
      chat.cropFile = null;
      chat.showCropModal = false;
   }
   chat.filesData.splice(i, 1);
   chat.filesData.length === 0 ? (chat.showFilesPreview = false) : null;
};
const openCropModal = (file) => {
   chat.cropFile = file;
   chat.showCropModal = true;
};
const substituteFiles = (file, url, id) => {
   let fileUrlIndex = chat.filesData.findIndex((f) => f.id === id);
   chat.filesData[fileUrlIndex].url = url;
   chat.filesData[fileUrlIndex].previewUrl = url;
   chat.filesData[fileUrlIndex].file = file;
   chat.cropFile = null;
};
const showLightBox = (url, type) => {
   if (type === "pdf" || type === "word") return;
   imgsRef.value = url;
   visibleRef.value = true;
};
const hideLightBox = () => {
   visibleRef.value = false;
};
</script>
<template>
   <div
      v-show="chat.showFilesPreview"
      class="relative overflow-auto hideScrollBar max-h-80"
      v-loading="chat.isLoadingFiles"
   >
      <div class="relative grid grid-cols-3 gap-2">
         <template v-for="(file, index) in chat.filesData" :key="index">
            <div class="relative">
               <template v-if="file.isVideo">
                  <video
                     :src="file.previewUrl"
                     :alt="file.name"
                     class="object-cover w-full h-full rounded-lg aspect-square"
                  />
                  <div
                     class="absolute inset-0 flex items-center justify-center gap-2 text-xs text-gray-100"
                  >
                     <PlayIcon
                        class="h-10 filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]"
                     />
                  </div>
               </template>
               <template v-else>
                  <img
                     :src="file.previewUrl"
                     :alt="file.name"
                     class="object-contain w-full h-full rounded-lg aspect-square"
                     @click.stop="showLightBox(file.url, file.type)"
                  />
                  <p
                     v-if="file.isPdf || file.isWord"
                     class="text-xs text-center text-gray-400 truncate"
                  >
                     {{ file.name }}
                  </p>
               </template>

               <button
                  @click.prevent.stop="removePhoto(index)"
                  class="absolute top-0 right-0 bg-white rounded-bl-xl bg-opacity-90"
               >
                  <div
                     class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                  >
                     <XMarkIcon class="w-5 h-5 text-stone-800" />
                  </div>
               </button>
               <button
                  class="absolute top-0 left-0 bg-white rounded-br-xl bg-opacity-90"
                  @click.stop="openCropModal(file)"
                  v-if="file.type === 'image'"
               >
                  <div
                     class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                  >
                     <font-awesome-icon
                        icon="crop-simple"
                        class="text-xs text-black/70"
                     />
                  </div>
               </button>
            </div>
         </template>
      </div>
   </div>
   <div>
      <Crop
         :img="chat.cropFile"
         @crop="substituteFiles"
         :open="chat.showCropModal"
         @close="chat.showCropModal = false"
      />
      <FadeInTransition>
         <div
            v-if="chat.isLoadingFiles"
            class="absolute inset-0 z-20 grid w-full h-full p-4 place-content-center bg-stone-400/50"
         ></div>
      </FadeInTransition>
   </div>
   <Teleport to="body">
      <vue-easy-lightbox
         :visible="visibleRef"
         :imgs="imgsRef"
         @hide="hideLightBox"
      ></vue-easy-lightbox>
   </Teleport>
</template>
