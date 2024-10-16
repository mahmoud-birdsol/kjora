<script setup>
import Modal from "@/Components/Modal.vue";
import InputUpload from "@/Components/Forms/InputUpload.vue";
import { useChat } from "@/stores/chat";
import useGetAllowedUploadFiles from "@/Composables/useGetAllowedUploadFiles.js";
import PreviewUpload from "./PreviewUpload.vue";
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
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

const emit = defineEmits(["close"]);

const showAsError = ref(false);
const isDisabled = ref(false);
const chat = useChat();

const maximumUploadNumberOfFiles = computed(
   () => usePage().props.maximumUploadNumberOfFiles
);

const upload = () => {
   if (!chat.filesData.length) {
      return;
   }
   chat.isLoadingFiles = true;
   isDisabled.value = true;
   chat.formCreateMessage.attachments = chat.filesData.map((file) => file.file);
   reset();
};

const reset = (e) => {
   chat.isLoadingFiles = false;
   isDisabled.value = false;
   showAsError.value = false;
   chat.cropFile = null;
   chat.showCropModal = false;
   emit("close");
};
const loadFiles = (newFiles, newFilesData) => {
   let newFilesDataAfterValidation = useGetAllowedUploadFiles(
      chat.filesData,
      newFilesData
   );
   if (newFilesDataAfterValidation.length < newFilesData.length) {
      showAsError.value = true;
   }
   chat.filesData = [...chat.filesData, ...newFilesDataAfterValidation];
   chat.showFilesPreview = true;
};
</script>
<template>
   <Modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      :position="position"
      @close="reset"
   >
      <div class="flex min-h-[500px] flex-col justify-between p-6 pt-0">
         <div class="flex justify-center">
            <h2 class="text-xl font-bold uppercase text-primary">
               {{ $t("upload") }}
            </h2>
         </div>
         <div class="flex flex-col items-center h-full gap-2 py-8">
            <!-- input -->
            <div class="w-full max-w-[300px] sm:px-20">
               <InputUpload
                  multiple
                  accept="image,video,pdf,word"
                  @onFinish="loadFiles"
               />
            </div>
            <PreviewUpload />
         </div>
         <div>
            <div
               v-if="showAsError"
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
   </Modal>
</template>
