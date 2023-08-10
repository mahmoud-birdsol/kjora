<script setup>
import Crop from "@/Components/Crop.vue";
import FadeInTransition from "@/Components/FadeInTransition.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { PlusCircleIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import VueEasyLightbox from "vue-easy-lightbox";

const props = defineProps({
   modelValue: {
      required: false,
      default: null,
   },
   shouldUpload: {
      require: false,
      type: Boolean,
      default: false,
   },
   currentImageUrl: {
      required: false,
      type: String,
      default: null,
   },
   modelName: {
      required: false,
      type: String,
   },
   modelId: {
      required: false,
      type: Number,
   },
   collectionName: {
      required: false,
      type: String,
   },
   show: {
      type: Boolean,
      default: false,
   },
   maxWidth: {
      type: String,
      default: "lg",
   },
   closeable: {
      type: Boolean,
      default: true,
   },
   position: {
      required: false,
      type: String,
      default: "center",
   },
});

const emit = defineEmits(["close", "update:modelValue", "reload", "upload"]);

const showPreview = ref(false);
const filesData = ref([]);
const photoInput = ref(null);
const isLoading = ref(false);
const isDisabled = ref(false);
const num = ref(0);
const visibleRef = ref(false);
const imgsRef = ref(null);
const cropFile = ref([]);
const openModal = ref(false);
const maximumUploadNumberOfFiles = ref(
   usePage().props.maximumUploadNumberOfFiles
);

const showLightBox = (url) => {
   imgsRef.value = url;
   visibleRef.value = true;
};
function hideLightBox() {
   visibleRef.value = false;
}

const selectNewPhoto = () => {
   photoInput.value.value = null;
   photoInput.value.click();
};

const updatePhotoPreview = () => {
   if (!photoInput.value.files.length) {
      return;
   }
   let newFiles = Array.from(photoInput.value.files).map((file) => {
      return { file: file, id: _.uniqueId("f") };
   });
   newFiles = checkAvailableSize(newFiles);
   newFiles?.forEach(({ file, id }) => {
      const url = URL.createObjectURL(file);

      filesData.value.push({
         file: file,
         url: url,
         name: file.name,
         type: file.type,
         id: id,
      });
      showPreview.value = true;
   });
};

function checkAvailableSize(newFiles) {
   let totalFilesNum = newFiles.length + filesData.value.length;
   if (totalFilesNum > maximumUploadNumberOfFiles.value) {
      let availableSize =
         maximumUploadNumberOfFiles.value - filesData.value.length;
      if (availableSize <= 0) return;
      if (availableSize) return (newFiles = newFiles.slice(0, availableSize));
   }
   return newFiles;
}

const removePhoto = (i) => {
   if ((cropFile.value.id, filesData.value[i].id)) {
      cropFile.value = {};
      openModal.value = false;
   }
   filesData.value.splice(i, 1);
   filesData.value.length === 0 ? (showPreview.value = false) : null;
};

const upload = () => {
   if (!filesData.value.length) {
      return;
   }
   isLoading.value = true;
   isDisabled.value = true;
   let files = filesData.value.map((file) => file.file);
   emit("upload", files, filesData.value);
   reset();
};

function reset(_e) {
   filesData.value = [];
   isLoading.value = false;
   isDisabled.value = false;
   num.value += 1;
   emit("close");
}

let showCropModal = (file) => {
   cropFile.value = file;
   openModal.value = true;
};
function changeFiles(file, url, id) {
   let fileUrlIndex = filesData.value.findIndex((f) => f.id === id);
   filesData.value[fileUrlIndex].url = url;
   filesData.value[fileUrlIndex].file = file;
   cropFile.value = [];
}
</script>

<template>
   <Modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      :position="position"
      @close="reset"
      :key="num"
   >
      <div class="flex min-h-[500px] flex-col justify-between p-6 pt-0">
         <div class="flex justify-center">
            <h2 class="text-xl font-bold uppercase text-primary">
               {{ $t("upload") }}
            </h2>
         </div>
         <!-- v-loading="" -->
         <div class="flex flex-col items-center h-full gap-2 py-8">
            <!-- input -->
            <div class="w-full max-w-[300px] sm:px-20">
               <input
                  ref="photoInput"
                  type="file"
                  multiple
                  accept="image/*,video/*,.pdf,.doc,.docx"
                  class="hidden"
                  @change="updatePhotoPreview"
               />
               <div class="flex items-center justify-center mb-6">
                  <button
                     type="button"
                     :disabled="isDisabled"
                     class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500"
                     @click.prevent="selectNewPhoto"
                  >
                     <PlusCircleIcon class="w-5 h-5" />
                  </button>
               </div>
            </div>
            <!-- preview -->
            <div
               v-show="showPreview"
               class="relative overflow-auto hideScrollBar max-h-80"
               v-loading="isLoading"
            >
               <div class="relative grid grid-cols-3 gap-2">
                  <template v-for="(file, index) in filesData" :key="index">
                     <div
                        v-if="
                           file.url.startsWith('data:image') ||
                           file.type.startsWith('image') ||
                           file.url.startsWith('data:video') ||
                           file.type.startsWith('video')
                        "
                        class="relative"
                     >
                        <img
                           v-if="
                              file.url.startsWith('data:image') ||
                              file.type.startsWith('image')
                           "
                           :src="file.url"
                           alt=""
                           class="object-contain w-full h-full rounded-lg aspect-square"
                           @click.stop="showLightBox(file.url)"
                        />
                        <video
                           v-if="
                              file.url.startsWith('data:video') ||
                              file.type.startsWith('video')
                           "
                           :src="file.url"
                           alt=""
                           class="object-cover w-full h-full rounded-lg aspect-square"
                        />
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
                           @click.stop="showCropModal(file)"
                           v-if="
                              file.url.startsWith('data:image') ||
                              file.type.startsWith('image')
                           "
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
                     <div
                        v-else-if="
                           file.url.startsWith('data:application/pdf') ||
                           file.type.startsWith('application/pdf')
                        "
                        class="relative flex flex-col gap-4"
                     >
                        <img class="mx-auto h-36" src="/images/pdf.png" />
                        <p class="text-xs text-center text-gray-400 truncate">
                           {{ file.name }}
                        </p>
                        <button
                           @click.prevent="removePhoto(index)"
                           class="absolute top-0 right-0 bg-white rounded-bl-xl bg-opacity-90"
                        >
                           <div
                              class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                           >
                              <XMarkIcon class="w-5 h-5 text-stone-800" />
                           </div>
                        </button>
                     </div>
                     <div
                        v-else-if="
                           file.type.endsWith('.document') ||
                           file.type.startsWith('application/msword')
                        "
                        class="relative flex flex-col gap-4"
                     >
                        <img class="mx-auto h-36" src="/images/doc.png" />
                        <p class="text-xs text-center text-gray-400 truncate">
                           {{ file.name }}
                        </p>
                        <button
                           @click.prevent="removePhoto(index)"
                           class="absolute top-0 right-0 bg-white rounded-bl-xl bg-opacity-90"
                        >
                           <div
                              class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                           >
                              <XMarkIcon class="w-5 h-5 text-stone-800" />
                           </div>
                        </button>
                     </div>
                  </template>

                  <FadeInTransition>
                     <div
                        v-if="isLoading"
                        class="absolute inset-0 z-20 grid w-full h-full p-4 place-content-center bg-stone-400/50"
                     ></div>
                  </FadeInTransition>
               </div>
            </div>
         </div>
         <div>
            <Crop
               :img="cropFile"
               @crop="changeFiles"
               v-model:open="openModal"
               @update:open="() => (openModal = false)"
            />
            <div
               v-if="filesData.length >= maximumUploadNumberOfFiles"
               class="mb-2 text-sm text-center text-red-500"
            >
               {{
                  $t(
                     "the maximum allowed file is :maximumUploadNumberOfFiles",
                     {
                        maximumUploadNumberOfFiles: maximumUploadNumberOfFiles,
                     }
                  )
               }}
            </div>
            <div class="mb-2 text-sm justify-self-end text-primary">
               {{
                  $t(
                     "video-images-pdfs-and-docs-are-allowed-with-max-size-84-mb-are-allowed"
                  )
               }}
            </div>
            <PrimaryButton @click.prevent="upload" :disabled="isDisabled">
               {{ $t("upload") }}
            </PrimaryButton>
         </div>
      </div>
      <Teleport to="body">
         <vue-easy-lightbox
            :visible="visibleRef"
            :imgs="imgsRef"
            @hide="hideLightBox"
         ></vue-easy-lightbox>
      </Teleport>
   </Modal>
</template>
