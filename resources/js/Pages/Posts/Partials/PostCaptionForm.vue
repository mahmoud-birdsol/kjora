<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import { usePostStore } from "@/stores";

const postStore = usePostStore();
</script>
<template>
   <div>
      <p v-show="!postStore.isEditingCaption" class="text-sm text-stone-500">
         {{ postStore.captionForm.caption }}
      </p>
      <div
         v-show="postStore.isEditingCaption"
         class="flex flex-col justify-end gap-3 mb-2"
      >
         <div>
            <textarea
               rows="4"
               type="text"
               v-model="postStore.captionForm.caption"
               class="w-full text-sm border-none rounded-lg resize-none text-stone-500 ring-1 focus:ring-primary focus:shadow-none focus:border-none ring-gray-300 hideScrollBar"
            />
            <InputError :message="postStore.captionForm.errors.caption" />
         </div>
         <div class="grid grid-cols-2 gap-2">
            <PrimaryButton
               @click="postStore.cancelEditCaption"
               class="w-24"
               :disabled="postStore.captionForm.processing"
               >{{ $t("Cancel") }}</PrimaryButton
            >
            <PrimaryButton
               @click="postStore.submitEditCaption"
               :disabled="postStore.captionForm.processing"
               >{{ $t("Save") }}</PrimaryButton
            >
         </div>
      </div>
   </div>
</template>

<style lang="scss" scoped></style>
