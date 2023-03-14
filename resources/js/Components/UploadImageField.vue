<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
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
        default: '2xl',
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

const emit = defineEmits(['close', 'update:modelValue', 'selected']);

const showPreview = ref(false);
const previewImageUrl = ref(null);
const photoInput = ref(null);
const fileData = ref([])
const cropLoading = ref(false)
const form = useForm({
    model_name: props.modelName,
    model_id: props.modelId,
    collection_name: props.collectionName,
    image: null,
});
const num = ref(Math.floor(Math.random() * 100))
const cropFile = ref([])
const openCropModal = ref(false)

onMounted(() => {
    if (props.currentImageUrl) {
        showPreview.value = true;
        previewImageUrl.value = props.currentImageUrl;
    }
});

watch(() => props.currentImageUrl, () => {
    if (props.currentImageUrl) {
        showPreview.value = true;
        previewImageUrl.value = props.currentImageUrl;
    }
})

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    fileData.value = photoInput.value.files[0];

    if (!fileData.value) return;
    cropLoading.value = true
    const reader = new FileReader();

    reader.onload = (e) => {
        previewImageUrl.value = e.target.result;
        showPreview.value = true;

    };

    reader.readAsDataURL(fileData.value);
    reader.onloadend = () => {
        setTimeout(() => {
            showCropModal(previewImageUrl)
        }, 0)
    };
};

const removePhoto = () => {
    showPreview.value = false;
    previewImageUrl.value = null;
};

const upload = () => {
    if (!props.shouldUpload) {
        emit('update:modelValue', fileData.value.url);
        emit('selected', previewImageUrl.value);
        close()
        return;
    }

    if (fileData.value) {
        form.image = fileData.value;
    }

    form.post(route('upload'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: (response) => {
            close();
        },
    });
};
function changeFiles(file, url, id) {
    fileData.value = file
    previewImageUrl.value = url
    cropFile.value = []
}
let showCropModal = (url) => {
    cropFile.value = {
        name: fileData.value.name,
        url,
    }
    openCropModal.value = true
    cropLoading.value = false

}
function close() {
    fileData.value = []
    previewImageUrl.value = ''
    num.value += 1
    emit('close')
}
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position" @close="close" :key="num">
        <div class="flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center -mt-12">
                <h2 class="text-xl text-primary font-bold uppercase">{{ $t('upload') }}</h2>
            </div>
            <div class="flex items-center justify-center py-8 sm:px-20" v-loading="form.processing">
                <div class="max-w-[300px] w-full">
                    <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">

                    <div class="flex items-center justify-center mb-6">
                        <button type="button"
                            class="inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                            @click.prevent="selectNewPhoto">
                            <PlusCircleIcon class="w-5 h-5" />
                        </button>
                    </div>

                    <button v-show="showPreview" @click.prevent="removePhoto" class="relative w-full rounded"
                        v-loading="cropLoading">
                        <img :src="previewImageUrl" alt="" class="w-full h-auto rounded-lg">
                        <div class="absolute inset-0 w-full h-full bg-transparent hover:bg-white hover:bg-opacity-50">
                            <div class="flex flex-col items-center justify-center h-full opacity-0 hover:opacity-100">
                                <XMarkIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div>
                <Crop :img="cropFile" @crop="changeFiles" v-model:open="openCropModal" @update:open="() => openCropModal = false"
                     />
                <PrimaryButton @click.prevent="upload" :disabled="form.processing">
                    {{ $t('upload') }}
                </PrimaryButton>
                <InputError class="mt-2" :message="form.errors.image" />
            </div>
        </div>
    </Modal>
</template>
