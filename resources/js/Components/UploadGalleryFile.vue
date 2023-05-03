<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import FadeInTransition from './FadeInTransition.vue';
import InputLabel from '@/Components/InputLabel.vue'
import CropIcon from '@/Components/Icons/CropIcon.vue';
import Crop from '@/Components/Crop.vue';

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

const emit = defineEmits(['close', 'update:modelValue', 'reload']);

const showPreview = ref(false);
const filesData = ref([]);
const fileInput = ref(null);
const isLoading = ref(false);
const isDisabled = ref(false);
const caption = ref('');
const cropFile = ref([])
const openCropModal = ref(false)
const num = ref(0)
const showAsError = ref(false);
let postId = null


const selectNewFile = () => {
    fileInput.value.value = null
    showAsError.value = false
    fileInput.value.click();
};

const updateFilesPreview = () => {
    if (!fileInput.value.files.length) {
        return
    }
    ;
    const newFiles = Array.from(fileInput.value.files).map(file => { return { file: file, id: _.uniqueId("f") } })

    newFiles.forEach(({ file, id }, i) => {
        const url = URL.createObjectURL(file);

        filesData.value.push({
            file: file,
            url: url,
            name: file.name,
            type: file.type,
            id: id,
        });
        showPreview.value = true;

        // const reader = new FileReader();
        // reader.onload = (e) => {
        //     filesData.value.push({
        //         file: file,
        //         url: e.target.result,
        //         name: file.name,
        //         type: file.type,
        //         id: id
        //     });
        //     showPreview.value = true;
        // };
        // reader.readAsDataURL(file);
    })
};

const removeFile = ({ file, url, id }) => {
    let fileDataIndex = filesData.value.findIndex((f) => f.id === id)
    filesData.value.splice(fileDataIndex, 1)
    filesData.value.length === 0 ? showPreview.value = false : null;
    if (cropFile.value.id === id) {
        cropFile.value = []
        openCropModal.value = false
    }
};

const uploadFiles = async () => {
    if (!filesData.value.length) {
        return
    }

    isLoading.value = true;
    isDisabled.value = true;
    showAsError.value = false


    if (!postId) {
        try {
            const res = await axios.postForm(route('api.posts.store'), {
                cover: filesData.value[0].file,
                caption: caption.value.trim()
            })
            postId = res.data.id
            sendPostMedia(postId)
        } catch (error) {
            console.log('there is error uploading this file (cover) ' + filesData.value[0].name);
            handleError(error, filesData.value[0])
        }
    } else if (filesData.value.slice(1).length > 0) {
        sendPostMedia(postId)
    } else {
        handleSuccess()
    }
}


function sendPostMedia(postId) {

    const promises = filesData.value.slice(1).map((fileData, i) => {
        const { file, id } = fileData;
        if (file.type.startsWith("image") || file.type.startsWith("video")) {
            return axios.postForm(route("api.gallery.upload", postId), {
                gallery: file
            }).catch(error => {
                console.log('there is error uploading this file ' + file.name);
                handleError(error, file)
                // throw (error)
            });
        }
    });

    Promise.all(promises)
        .then(() => {
            handleSuccess()
        })
        .catch((error) => {

        })
        .finally(() => {
            isLoading.value = false;
            isDisabled.value = false;
        });
}


function handleError(error, file) {
    console.error(error)
    if (error?.response?.status === 422 || error?.response?.status === 413) {
        showAsError.value = true
        removeFile(file)
        isLoading.value = false
        isDisabled.value = false;
    }
}

function handleSuccess() {
    reset();
    emit("reload");
}

function reset(e) {
    filesData.value = []
    isLoading.value = false
    isDisabled.value = false;
    showAsError.value = false
    postId = null
    caption.value = ''
    num.value += 1
    emit('close');
}
function changeFiles(file, url, id) {

    let fileObjIndex = filesData.value.findIndex((f) => f.id === id)
    filesData.value[fileObjIndex].url = url
    filesData.value[fileObjIndex].file = file
    cropFile.value = []
}
let showCropModal = (file) => {
    cropFile.value = file
    openCropModal.value = true
}

</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position" @close="reset" :key="num">
        <div class=" flex flex-col min-h-[500px] justify-between p-6 pt-0">
            <div class="flex justify-center ">
                <h2 class="text-xl font-bold uppercase text-primary">{{ $t('upload') }}</h2>
            </div>
            <div>
                <InputLabel :value="'Caption'" class="text-primary" />
                <div class="flex items-center flex-grow ">
                    <textarea v-model="caption" name="caption" id="caption" rows="1"
                        :placeholder="$t('please write caption')"
                        class="w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 text-stone-700 ring-1 focus:ring-primary ring-stone-400 "></textarea>
                </div>
            </div>
            <!-- v-loading="" -->
            <div class="flex flex-col items-center h-full gap-2 py-8 ">

                <!-- input -->
                <div class="max-w-[300px] sm:px-20 w-full">
                    <input ref="fileInput" type="file" multiple accept="video/*,image/*" class="hidden"
                        @change="updateFilesPreview">
                    <div class="flex items-center justify-center mb-6">
                        <button type="button" :disabled="isDisabled"
                            class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500"
                            @click.prevent="selectNewFile">
                            <PlusCircleIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                <!-- preview -->
                <div v-show="showPreview" class="relative overflow-auto hideScrollBar max-h-80" v-loading="isLoading">
                    <div class="relative grid grid-cols-3 gap-2">
                        <template v-for="(fileData, index) in filesData" :key="index">
                            <div v-if="fileData.url.startsWith('data:image') || fileData.type.startsWith('image') ||
                                fileData.url.startsWith('data:video') || fileData.type.startsWith('video')"
                                class="relative">
                                <img v-if="fileData.url.startsWith('data:image') || fileData.type.startsWith('image')"
                                    :src="fileData.url" alt=""
                                    class="object-contain w-full h-full rounded-lg aspect-square">
                                <video v-if="fileData.url.startsWith('data:video') || fileData.type.startsWith('video')"
                                    :src="fileData.url" alt=""
                                    class="object-cover w-full h-full rounded-lg aspect-square" />
                                <button @click.prevent="removeFile(fileData)"
                                    class="absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <XMarkIcon class="w-5 h-5 text-stone-800" />
                                    </div>
                                </button>
                                <button class="absolute top-0 left-0 bg-white bg-opacity-90 rounded-br-xl"
                                    @click="showCropModal(fileData)"
                                    v-if="fileData.url.startsWith('data:image') || fileData.type.startsWith('image')">
                                    <div class="flex flex-col items-start justify-center h-full p-1 opacity-100">
                                        <CropIcon class="w-4" />
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
                </div>
            </div>
            <div>
                <Crop :img="cropFile" @crop="changeFiles" v-model:open="openCropModal"
                    @update:open="() => openCropModal = false" />
                <div class="mb-2 text-sm text-center justify-self-end sha "
                    :class="showAsError ? 'text-red-500' : 'text-primary'">
                    {{ $t('only videos and images with max size (3MB) are allowed') }}
                </div>
                <PrimaryButton @click.prevent="uploadFiles" :disabled="isDisabled">
                    {{ $t('upload') }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
