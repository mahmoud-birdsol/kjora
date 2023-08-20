<script setup>
import Crop from "@/Components/Crop.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputUpload from "@/Components/Forms/InputUpload.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useForm } from "@inertiajs/vue3";
import { onMounted, ref, watch } from "vue";
import Title from "./Title.vue";

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
      default: "2xl",
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

const emit = defineEmits(["close", "update:modelValue", "selected"]);

const showPreview = ref(false);
const previewImageUrl = ref(null);
const isDisabled = ref(false);
const fileData = ref(null);
const isCropLoading = ref(false);
const form = useForm({
   model_name: props.modelName,
   model_id: props.modelId,
   collection_name: props.collectionName,
   image: null,
});
const num = ref(Math.floor(Math.random() * 100));
const cropFile = ref({});
const openCropModal = ref(false);

onMounted(() => {
   if (props.currentImageUrl) {
      showPreview.value = true;
      previewImageUrl.value = props.currentImageUrl;
   }
});

watch(
   () => props.currentImageUrl,
   () => {
      if (props.currentImageUrl) {
         showPreview.value = true;
         previewImageUrl.value = props.currentImageUrl;
      }
   }
);

const removePhoto = () => {
   showPreview.value = false;
   previewImageUrl.value = null;
   cropFile.value = {};
   openCropModal.value = false;
};

const upload = () => {
   if (!props.shouldUpload) {
      emit("update:modelValue", fileData.value);
      emit("selected", previewImageUrl.value);
      close();
      return;
   }

   if (fileData.value) {
      form.image = fileData.value;
   }

   form.post(route("upload"), {
      preserveState: true,
      preserveScroll: true,
      onFinish: (_) => {
         close();
      },
   });
};
function changeFiles(file, url, _id) {
   fileData.value = file;
   previewImageUrl.value = url;
   cropFile.value = {};
}
let showCropModal = (url) => {
   cropFile.value = {
      name: fileData.value.name,
      url,
   };

   openCropModal.value = true;
   isCropLoading.value = false;
};
function close() {
   fileData.value = null;
   num.value += 1;
   emit("close");
}

const loadFiles = (_newFiles, newFileData) => {
   fileData.value = newFileData.file;
   previewImageUrl.value = newFileData.previewUrl;
   showPreview.value = true;
   isCropLoading.value = true;
   showCropModal(newFileData.url);
};
</script>

<template>
   <Modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      :position="position"
      @close="close"
      :key="num"
   >
      <div class="flex flex-col min-h-[500px] justify-between p-6 pt-0">
         <Title>{{ $t("upload") }}</Title>
         <div
            class="flex items-center justify-center py-8 sm:px-20"
            v-loading="form.processing"
         >
            <div class="max-w-[300px] w-full">
               <InputUpload
                  :accept="['image', 'video']"
                  :isDisabled="isDisabled"
                  @onFinish="loadFiles"
               />
               <button
                  v-show="showPreview && !openCropModal"
                  @click.prevent="removePhoto"
                  class="relative w-full rounded"
                  v-loading="isCropLoading"
               >
                  <img
                     :src="previewImageUrl"
                     alt=""
                     class="w-full h-auto rounded-lg"
                     id="img"
                  />
                  <div
                     class="absolute inset-0 w-full h-full bg-transparent hover:bg-white hover:bg-opacity-50"
                  >
                     <div
                        class="flex flex-col items-center justify-center h-full opacity-0 hover:opacity-100"
                     >
                        <XMarkIcon class="w-8 h-8 text-white" />
                     </div>
                  </div>
               </button>
            </div>
         </div>
         <div>
            <Crop
               :img="cropFile"
               @crop="changeFiles"
               :open="openCropModal"
               @close="() => (openCropModal = false)"
               :presetMode="{
                  mode: 'round',
                  width: 250,
                  height: 250,
               }"
               :extraOptions="{
                  viewMode: 1,
                  dragMode: 'move',
                  aspectRatio: 1,
                  cropBoxResizable: false,
               }"
            />
            <template v-if="!openCropModal">
               <PrimaryButton
                  @click.prevent="upload"
                  :disabled="form.processing"
               >
                  {{ $t("upload") }}
               </PrimaryButton>
            </template>
            <InputError class="mt-2" :message="form.errors.image" />
         </div>
      </div>
   </Modal>
</template>
