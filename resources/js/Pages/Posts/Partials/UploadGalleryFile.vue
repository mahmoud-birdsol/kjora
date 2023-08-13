<script setup>
import Crop from "@/Components/Crop.vue";
import FadeInTransition from "@/Components/FadeInTransition.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import InputUpload from "@/Components/Forms/InputUpload.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Title from "@/Components/Title.vue";
import useGetAllowedUploadFiles from "@/Composables/useGetAllowedUploadFiles.js";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { PlayIcon } from "@heroicons/vue/24/solid";
import { usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
   modelValue: {
      required: false,
      type: String,
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

const emit = defineEmits(["close", "update:modelValue", "reload"]);

const showPreview = ref(false);
const filesData = ref([]);
const isLoading = ref(false);
const isDisabled = ref(false);
const caption = ref("");
const cropFile = ref([]);
const openCropModal = ref(false);
const countUploadFiles = ref(0);
const showAsError = ref(false);
let postId = null;

const maximumUploadNumberOfFiles = computed(
   () => usePage().props.maximumUploadNumberOfFiles
);

const removeFile = ({ id }) => {
   let fileDataIndex = filesData.value.findIndex((f) => f.id === id);
   filesData.value.splice(fileDataIndex, 1);
   if (cropFile.value.id === id) {
      cropFile.value = [];
      openCropModal.value = false;
   }
};

const uploadFiles = async () => {
   if (!filesData.value.length) {
      return;
   }

   isLoading.value = true;
   isDisabled.value = true;
   showAsError.value = false;

   if (!postId) {
      try {
         const res = await axios.postForm(route("api.posts.store"), {
            cover: filesData.value[0].file,
            caption: caption.value.trim(),
         });
         postId = res.data.id;
         sendPostMedia(postId);
      } catch (error) {
         handleError(error, filesData.value[0]);
      }
   } else if (filesData.value.slice(1).length > 0) {
      sendPostMedia(postId);
   } else {
      handleSuccess();
   }
};

function sendPostMedia(postId) {
   const promises = filesData.value.slice(1).map((fileData) => {
      const { file } = fileData;
      if (fileData.isImage || fileData.isVideo) {
         return axios
            .postForm(route("api.gallery.upload", postId), {
               gallery: file,
            })
            .catch((error) => {
               handleError(error, fileData);
            });
      }
   });

   Promise.all(promises)
      .then(() => {
         handleSuccess();
      })
      .catch((_) => {})
      .finally(() => {
         isLoading.value = false;
         isDisabled.value = false;
      });
}

function handleError(error, file) {
   if (error?.response?.status === 422 || error?.response?.status === 413) {
      showAsError.value = true;
      removeFile(file);
      isLoading.value = false;
      isDisabled.value = false;
   }
}

function handleSuccess() {
   reset();
   emit("reload");
}

function reset(_e) {
   filesData.value = [];
   isLoading.value = false;
   isDisabled.value = false;
   showAsError.value = false;
   postId = null;
   caption.value = "";
   countUploadFiles.value += 1;
   emit("close");
}

function changeFiles(file, url, id) {
   let fileObjIndex = filesData.value.findIndex((f) => f.id === id);
   filesData.value[fileObjIndex].url = url;
   filesData.value[fileObjIndex].previewUrl = url;
   filesData.value[fileObjIndex].file = file;
   cropFile.value = [];
}

let showCropModal = (file) => {
   cropFile.value = file;
   openCropModal.value = true;
};
const loadFiles = (newFiles, newFilesData) => {
   newFilesData = useGetAllowedUploadFiles(filesData.value, newFilesData);
   if (newFilesData.length <= 0) return;
   filesData.value = [...filesData.value, ...newFilesData];
   showPreview.value = true;
};
</script>

<template>
   <Modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      :position="position"
      @close="reset"
      :key="countUploadFiles"
   >
      <div class="flex flex-col min-h-[500px] justify-between p-6 pt-0">
         <Title>{{ $t("upload") }}</Title>
         <div>
            <InputLabel :value="'Caption'" class="text-primary" />
            <div class="flex items-center flex-grow">
               <textarea
                  v-model="caption"
                  name="caption"
                  id="caption"
                  rows="1"
                  :placeholder="$t('please write caption')"
                  class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 text-stone-700 ring-1 focus:ring-primary ring-stone-400"
               ></textarea>
            </div>
         </div>
         <!-- v-loading="" -->
         <div class="flex flex-col items-center h-full gap-2 py-8">
            <!-- input -->
            <div class="max-w-[300px] sm:px-20 w-full">
               <InputUpload
                  :accept="['image', 'video']"
                  :isDisabled="isDisabled"
                  :isLoading="isLoading"
                  multiple
                  @onFinish="loadFiles"
               />
            </div>
            <!-- preview -->
            <div
               v-show="showPreview"
               class="relative overflow-auto hideScrollBar max-h-80"
               v-loading="isLoading"
            >
               <div class="relative grid grid-cols-3 gap-2">
                  <template v-for="(fileData, index) in filesData" :key="index">
                     <div class="relative">
                        <template v-if="fileData.isVideo">
                           <video
                              :src="fileData.previewUrl"
                              :alt="fileData.name"
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
                              :src="fileData.previewUrl"
                              class="object-contain w-full h-full rounded-lg aspect-square"
                           />
                        </template>
                        <button
                           @click.prevent="removeFile(fileData)"
                           class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl"
                        >
                           <div
                              class="flex flex-col items-start justify-center h-full p-1 opacity-100"
                           >
                              <XMarkIcon class="w-5 h-5 text-stone-800" />
                           </div>
                        </button>

                        <button
                           class="absolute top-0 left-0 p-1 bg-white bg-opacity-90 rounded-br-xl"
                           @click="showCropModal(fileData)"
                           v-if="fileData.type === 'image'"
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
                  <FadeInTransition>
                     <div
                        v-if="isLoading"
                        class="absolute inset-0 z-20 grid w-full h-full p-4 bg-stone-400/50 place-content-center"
                     ></div>
                  </FadeInTransition>
               </div>
            </div>
         </div>
         <div>
            <Crop
               :img="cropFile"
               @crop="changeFiles"
               v-model:open="openCropModal"
               @update:open="() => (openCropModal = false)"
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
            <div
               v-if="showAsError"
               class="mb-2 text-sm text-center text-red-500 justify-self-end"
            >
               {{
                  $t("only videos and images with max size (84MB) are allowed")
               }}
            </div>
            <PrimaryButton @click.prevent="uploadFiles" :disabled="isDisabled">
               {{ $t("upload") }}
            </PrimaryButton>
         </div>
      </div>
   </Modal>
</template>
