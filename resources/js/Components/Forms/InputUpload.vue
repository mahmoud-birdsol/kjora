<script setup>
import { useObjectUrl } from "@vueuse/core";
import { ref, computed } from "vue";
import { PlusCircleIcon } from "@heroicons/vue/24/outline";
const props = defineProps({
   type: Boolean,
   multiple: {
      default: false,
   },
   isLoading: Boolean,
   isDisabled: Boolean,
   multiple: Boolean,
   accept: [Array, String],
});

const emit = defineEmits(["onFinish"]);

const fileInput = ref();
const files = ref([]);

const acceptTypes = {
   image: "image/*",
   video: "video/*",
   pdf: ".pdf",
   word: ".doc,.docx",
};

const inputAcceptedTypes = computed(() => {
   if (typeof props.accept === "Array") {
      return props.accept.map((type) => acceptTypes[type]).join(",");
   }
   if (typeof props.accept === "String") {
      props.accept
         .split(",")
         .map((type) => acceptTypes[type])
         .join(",");
   }
});

function clickFileInput() {
   fileInput.value.click();
}

function handleFileChange(e) {
   if (!e.target.files.length) return;
   Array.from(e.target.files).forEach((file) => {
      let url = useObjectUrl(file);
      files.value.push({
         file: file,
         id: _.uniqueId("f"),
         url: url.value,
         name: file.name,
         ...getFileMetaData(file, url.value),
      });
   });

   handleEmitValue();
   reset();
}

function handleEmitValue() {
   let rawFilesArray = files.value.map((file) => {
      return file.file;
   });
   if (props.multiple) {
      emit("onFinish", rawFilesArray, files.value);
   } else {
      /**
       * Description
       * @param {any} "onFinish"
       * @param {Blob} rawFilesArray[0]
       * @param {any} files.value[0]
       * @returns {any}
       */
      emit("onFinish", rawFilesArray[0], files.value[0]);
   }
}
function reset() {
   files.value = [];
   fileInput.value.value = null;
}

function getFileMetaData(file, url) {
   let type = file.type;

   let fileType;
   let isImage = false;
   let isVideo = false;
   let isWord = false;
   let isPdf = false;
   let previewUrl = url;

   switch (true) {
      case type.startsWith("image/"):
         fileType = "image";
         isImage = true;
         break;
      case type.startsWith("video/"):
         fileType = "video";
         isVideo = true;
         break;
      case type.startsWith("application/pdf"):
         fileType = "pdf";
         isWord = true;
         previewUrl = "/images/pdf.png";
         break;
      case type.startsWith("application/msword"):
         fileType = "word";
         isWord = true;
         previewUrl = "/images/doc.png";
         break;
      default:
         break;
   }
   return {
      fileType,
      isWord,
      isPdf,
      isImage,
      isVideo,
      previewUrl,
   };
}
function getFileSize(file) {
   let number = file.size;
   if (number < 1024) {
      return `${number} bytes`;
   } else if (number >= 1024 && number < 1048576) {
      return `${(number / 1024).toFixed(1)} KB`;
   } else if (number >= 1048576) {
      return `${(number / 1048576).toFixed(1)} MB`;
   }
}
</script>

<template>
   <div @click="clickFileInput">
      <input
         ref="fileInput"
         type="file"
         class="hidden"
         v-bind="$attrs"
         @change="handleFileChange"
         :multiple="multiple"
         :accept="inputAcceptedTypes"
      />
      <slot>
         <div class="flex items-center justify-center mb-6">
            <button
               type="button"
               :disabled="isDisabled"
               class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500"
            >
               <div
                  v-if="isLoading"
                  class="w-4 h-4 border-2 border-white rounded-full border-l-transparent animate-spin"
               ></div>
               <PlusCircleIcon v-else class="w-5 h-5" />
            </button>
         </div>
      </slot>
   </div>
</template>

<style scoped></style>
