<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import FadeInTransition from '@/Components/FadeInTransition.vue';

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
        default: 'lg',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    position: {
        required: false,
        type: String,
        default: 'center',
    }
});

const emit = defineEmits(['close', 'update:modelValue', 'reload', 'upload']);

const showPreview = ref(false);
const filesData = ref([]);
const photoInput = ref(null);
const isLoading = ref(false);
const isDisabled = ref(false);
const files = ref([]);

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    if (!photoInput.value.files.length) {
        return
    }
    ;
    files.value = Array.from(photoInput.value.files)
    files.value.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {

            filesData.value.push({
                url: e.target.result,
                name: file.name,
                type: file.type
            });
            showPreview.value = true;
        };
        reader.readAsDataURL(file);
    })
};

const removePhoto = (i) => {

    filesData.value.splice(i, 1)
    files.value.splice(i, 1)
    filesData.value.length === 0 ? showPreview.value = false : null;
};

const upload = () => {
    if (!files.value.length) {
        return
    }

    isLoading.value = true;
    isDisabled.value = true;
    emit('upload', files.value, filesData.value)
    reset()
    // files.value.forEach((file, i) => {
    //     if (file.type.startsWith("image") || file.type.startsWith('video')) {

    //         axios.postForm(route('api.gallery.upload'), {
    //             gallery: file
    //         }).then(() => console.log('uploded')).catch(err => console.error(err)).finally(() => {
    //             if (i === files.value.length - 1) {
    //                 reset()
    //
    //             }
    //         })
    //     }
    // })
};

function reset(e) {
    filesData.value = []
    files.value = []
    isLoading.value = false
    isDisabled.value = false;
    emit('close');
}
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position" @close="reset">
        <div class=" flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center -mt-12">
                <h2 class="text-xl font-bold uppercase text-primary">{{$t('upload')}}</h2>
            </div>
            <!-- v-loading="" -->
            <div class="flex flex-col items-center h-full gap-2 py-8 ">

                <!-- input -->
                <div class="max-w-[300px] sm:px-20 w-full">
                    <input ref="photoInput" type="file" multiple accept="image/*,video/*,.pdf,.doc,.docx" class="hidden"
                        @change="updatePhotoPreview">
                    <div class="flex items-center justify-center mb-6">
                        <button type="button" :disabled="isDisabled"
                            class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500"
                            @click.prevent="selectNewPhoto">
                            <PlusCircleIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                <!-- preview -->
                <div v-show="showPreview" class="relative overflow-auto hideScrollBar max-h-80" v-loading="isLoading">
                    <div class="relative grid grid-cols-3 gap-2">
                        <template v-for="(fileUrl, index) in filesData" :key="index">
                            <div v-if="fileUrl.url.startsWith('data:image') || fileUrl.url.startsWith('data:video')"
                                class="relative">
                                <img v-if="fileUrl.url.startsWith('data:image')" :src="fileUrl.url" alt=""
                                    class="object-cover w-full h-full rounded-lg aspect-square ">
                                <video v-if="fileUrl.url.startsWith('data:video')" :src="fileUrl.url" alt=""
                                    class="object-cover w-full h-full rounded-lg aspect-square" controls />
                                <button @click.prevent="removePhoto(index)"
                                    class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                                    </div>
                                </button>
                            </div>
                            <div v-else-if="fileUrl.url.startsWith('data:application/pdf')"
                                class="relative flex flex-col gap-4 ">
                                <img class="mx-auto h-52" src="/images/pdf.png" />
                                <p class="text-xs text-center text-gray-400 truncate">{{ fileUrl.name }}</p>
                                <button @click.prevent="removePhoto(index)"
                                    class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                                    </div>
                                </button>
                            </div>
                            <div v-else-if="fileUrl.type.endsWith('.document') || fileUrl.type.startsWith('application/msword')"
                                class="relative flex flex-col gap-4">
                                <img class="mx-auto h-52" src="/images/doc.png" />
                                <p class="text-xs text-center text-gray-400 truncate">{{ fileUrl.name }}</p>
                                <button @click.prevent="removePhoto(index)"
                                    class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                                    </div>
                                </button>
                            </div>
                        </template>
                        <FadeInTransition>
                            <div v-if="isLoading"
                                class="absolute inset-0 z-20 grid w-full h-full p-4 bg-stone-400/50 place-content-center ">
                            </div>
                        </FadeInTransition>
                    </div>
                    <!-- <FadeInTransition>
                                                                         <div v-if="isLoading" class="absolute inset-0 z-20 grid p-4 top-4 place-content-center ">
                                                                             <div
                                                                                 class="h-12 border-4 rounded-full border-primary border-t-white aspect-square animate-spin">
                                                                             </div>
                                                                         </div>
                                                                     </FadeInTransition> -->
                </div>

            </div>
            <div>
                <div class="justify-self-end text-sm mb-2 text-primary text-center">{{$t('video, images, PDFs and docs are allowed with max size (10 MB) are allowed')}}
                </div>
                <PrimaryButton @click.prevent="upload" :disabled="isDisabled">
                    {{ $t('upload') }}
                </PrimaryButton>
                <!-- <InputError class="mt-2" :message="form.errors.image" /> -->
            </div>
        </div>
    </Modal>
</template>
