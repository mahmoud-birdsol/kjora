<script setup>
import { computed, ref } from 'vue';
import VueEasyLightbox, { useEasyLightbox } from 'vue-easy-lightbox'
const props = defineProps({
    imageUrl: {
        required: false,
        type: String,
    },
    size: {
        required: false,
        type: String,
        default: 'sm',
    },
    username: {
        required: false,
        type: String,
        default: 'Kjora',
    },
    border: {
        required: false,
        type: Boolean,
        default: false,
    }
    , borderColor: null,
    enableLightBox: {
        required: false,
        type: Boolean,
        default: true,
    }
});

const sizeClasses = computed(() => {
    return {
        'sm': 'h-8 w-8',
        'md': 'h-10 w-10',
        'lg': 'h-14 w-14',
        'xlg': 'h-20 w-20',
    }[props.size];
});
const borderColorClass = computed(() => {
    return {
        'white': 'border-white',
        'primary': 'border-primary',
        'black': 'border-stone-800',
    }[props.borderColor];
});

const borderClasses = computed(() => {
    return props.border ? 'border-2 ' : 'border-none';
})


// adding vue light boc on click on player image
const visibleRef = ref(false)
const imgsRef = ref(null)
const showLightBox = () => {

    if (props.enableLightBox) {
        imgsRef.value = props.imageUrl
        visibleRef.value = true
    }
}
function hideLightBox() {
    visibleRef.value = false
}
</script>

<template>
    <span @click="showLightBox" v-if="imageUrl" class="block rounded-full bg-cover bg-no-repeat bg-center cursor-pointer"
        :class="[sizeClasses, borderClasses, borderColorClass]" :style="'background-image: url(' + imageUrl + ');'" />

    <span v-if="!imageUrl" class="block rounded-full bg-cover bg-no-repeat bg-center"
        :class="[sizeClasses, borderClasses, borderColorClass]"
        :style="'background-image: url(\'https://ui-avatars.com/api/?name=' + username + '&color=094609FF&background=E2E2E2\');'" />
    <vue-easy-lightbox :visible="visibleRef" :imgs="imgsRef" @hide="hideLightBox"></vue-easy-lightbox>
</template>
