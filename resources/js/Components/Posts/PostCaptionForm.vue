<template>
    <div>
        <p class="text-sm text-stone-500" v-show="!isEditingCaption">
            {{ captionForm.caption }}
        </p>
        <div v-show="isEditingCaption" class="flex flex-col justify-end gap-3">
            <textarea rows="4" type="text" v-model='captionForm.caption'
                class="w-full text-sm border-none rounded-lg resize-none text-stone-500 ring-1 focus:ring-primary focus:shadow-none focus:border-none ring-gray-300 hideScrollBar" />
            <div class="flex justify-end gap-2">
                <PrimaryButton @click="cancelEditCaption" class="w-24">{{ $t('Cancel') }}</PrimaryButton>
                <PrimaryButton @click="submitEditCaption" class="w-24">{{ $t('Save') }}</PrimaryButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { formContextKey } from 'element-plus';
import { ref } from 'vue';

const props = defineProps(['post', 'isEditingCaption'])

const isEditingCaption = ref(false);

const captionForm = useForm({
    caption: props.post.caption
})
function submitEditCaption() {
    captionForm.patch(route('posts.update', props.post), {
        preserveScroll: true,
        preserveState: true
    })
    isEditingCaption.value = false
}

function cancelEditCaption() {
    captionForm.reset()
    isEditingCaption.value = false
}
defineExpose({ isEditingCaption })
</script>

<style lang="scss" scoped></style>
