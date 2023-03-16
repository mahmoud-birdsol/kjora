<template>
    <div class="relative">
        <button class="p-1" @click="showOptions = !showOptions">
            <EllipsisHorizontalIcon class="w-6" />
        </button>
        <OnClickOutside @trigger="showOptions = false">
            <FadeInTransition>
                <!-- media option menu -->
                <div v-show="showOptions"
                    class="absolute top-0 z-20 px-6 py-2 text-xs text-white bg-black border ltr:right-8 rtl:left-8 rounded-xl border-neutral-500 pie-10 z-2 ">
                    <ul class="flex flex-col justify-center gap-y-2">
                        <button class="hover:text-gray-400 group" @click="editCaption">
                            <li class="flex items-center gap-x-2">
                                <PencilIcon class="w-4 " />
                                <span>{{ $t('edit') }}</span>
                            </li>
                        </button>
                        <button @click="openRemoveMediaModal" class="hover:text-gray-400 " v-if="isCurrentUser">
                            <li class="flex items-center justify-center gap-x-2">
                                <TrashIcon class="w-4" />
                                <span> {{ $t('delete') }}</span>
                            </li>
                            <!-- confirm delete media modal -->
                            <Modal :show="showDeletePostModal" @close="showDeletePostModal = false" :closeable="true"
                                :show-close-icon="false" :max-width="'sm'">
                                <div class="flex flex-col justify-center p-6 text-stone-800 ">
                                    <p class="mb-3 text-lg">
                                        {{ $t('Are you sure you want delete this media ? ') }}</p>
                                    <div class="flex justify-center w-full gap-4">
                                        <button
                                            class="p-2 px-8 border-2 rounded-full border-primary hover:bg-primary text-primary hover:text-white active:scale-95 "
                                            @click="showDeletePostModal = false">{{ $t('Cancel')
                                            }}
                                        </button>
                                        <button
                                            class="p-2 px-8 text-white bg-red-800 border-2 border-red-800 rounded-full hover:bg-transparent hover:text-red-800 active:scale-95 "
                                            @click="removePost">{{ $t('Delete Post') }}
                                        </button>
                                    </div>
                                </div>
                            </Modal>
                        </button>
                        <button class="hover:text-gray-400 group">
                            <li v-if="!isCurrentUser">
                                <ReportModal :reportable-id="postId" :reportable-type="'App\\Models\\Post'">
                                    <template #trigger>
                                        <button class="flex items-center gap-x-2">
                                            <FlagIcon class="w-4" />
                                            <span>{{ $t('report') }}</span>
                                        </button>

                                    </template>
                                </ReportModal>
                            </li>

                        </button>

                    </ul>
                </div>
            </FadeInTransition>
        </OnClickOutside>

    </div>
</template>

<script setup>

import { EllipsisHorizontalIcon, TrashIcon, PencilIcon, FlagIcon } from '@heroicons/vue/24/outline';
import FadeInTransition from '../FadeInTransition.vue';
import Modal from '../Modal.vue';
import ReportModal from '@/Components/ReportModal.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['isCurrentUser', 'postId'])
const emits = defineEmits(['editingCaption'])
const showDeletePostModal = ref(false);
const showOptions = ref(false);

function openRemoveMediaModal() {
    showOptions.value = false
    showDeletePostModal.value = true
}
// edit media caption
function editCaption() {
    showOptions.value = false
    emits('editingCaption')
}

function removePost() {

    showDeletePostModal.value = false
    Inertia.delete(route('posts.destroy', props.postId), {
    })

}
</script>

<style lang="scss" scoped></style>
