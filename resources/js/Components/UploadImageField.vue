<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted, watch } from 'vue';
import InputError from '@/Components/InputError.vue';

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

const form = useForm({
    model_name: props.modelName,
    model_id: props.modelId,
    collection_name: props.collectionName,
    image: null,
});

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
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        previewImageUrl.value = e.target.result;
        showPreview.value = true;
    };

    reader.readAsDataURL(photo);
};

const removePhoto = () => {
    showPreview.value = false;
    previewImageUrl.value = null;
};

const upload = () => {
    if (!props.shouldUpload) {
        emit('update:modelValue', photoInput.value.files[0]);
        emit('selected', previewImageUrl.value);
        emit('close');

        return;
    }

    if (photoInput.value) {
        form.image = photoInput.value.files[0];
    }

    form.post(route('upload'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (response) => {
            emit('close');
        },
    });
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        :position="position"
        @close="$emit('close')"
    >
        <div class="flex flex-col min-h-[500px] justify-between p-6">
            <div class="flex justify-center -mt-12">
                <h2 class="text-xl text-primary font-bold uppercase">{{$t('upload')}}</h2>
            </div>
            <div class="flex justify-center items-center sm:px-20 py-8" v-loading="form.processing">
                <div class="max-w-[300px] w-full">
                    <input
                        ref="photoInput"
                        type="file"
                        class="hidden"
                        @change="updatePhotoPreview"
                    >

                    <div class="flex justify-center items-center mb-6">
                        <button type="button"
                                class="inline-flex items-center rounded-full border border-transparent bg-black p-4 text-white shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                                @click.prevent="selectNewPhoto"
                        >
                            <PlusCircleIcon class="h-5 w-5"/>
                        </button>
                    </div>

                    <button v-show="showPreview" @click.prevent="removePhoto" class="relative rounded w-full">
                        <img :src="previewImageUrl" alt="" class="w-full h-auto rounded-lg">
                        <div class="absolute inset-0 bg-transparent hover:bg-white hover:bg-opacity-50 h-full w-full">
                            <div class="flex flex-col justify-center items-center h-full opacity-0 hover:opacity-100">
                                <XMarkIcon class="h-8 w-8 text-white"/>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div>
                <PrimaryButton @click.prevent="upload" :disabled="form.processing">
                    {{$t('upload')}}
                </PrimaryButton>
                <InputError class="mt-2" :message="form.errors.image"/>
            </div>
        </div>
    </Modal>
</template>
