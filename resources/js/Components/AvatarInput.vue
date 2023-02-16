<script setup>
import { ref, onMounted } from 'vue';

const photoPreview = ref(null);
const photoInput = ref(null);
const showModelValue = ref(false);

const props = defineProps({
    modelValue: String,
});

onMounted(() => {
    if (props.modelValue) {
        showModelValue.value = true;
    }
});

const emit = defineEmits(['update:modelValue']);

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);

    showModelValue.value = false;

    emit('update:modelValue', photo);
};
</script>

<template>
    <div>
        <input
            ref="photoInput"
            type="file"
            class="hidden"
            @change="updatePhotoPreview"
        >

        <!-- Current Profile Photo -->
        <button v-show="! photoPreview && ! showModelValue" class="mt-2" @click.prevent="selectNewPhoto">
            <span
                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                :style="'background-image: url(\'https://ui-avatars.com/api/?name=kjora&color=094609FF&background=E2E2E2\');'"
            />
        </button>

        <button v-show="showModelValue" class="mt-2" @click.prevent="selectNewPhoto">
            <span
                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                :style="'background-image: url(\'' + modelValue + '\');'"
            />
        </button>

        <!-- New Profile Photo Preview -->
        <button v-show="photoPreview" class="mt-2" @click.prevent="selectNewPhoto">
            <span
                class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                :style="'background-image: url(\'' + photoPreview + '\');'"
            />
        </button>
    </div>
</template>
