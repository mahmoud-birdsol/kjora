<script setup>
import { Splide, SplideSlide, SplideTrack } from "@splidejs/vue-splide";
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import "@splidejs/vue-splide/css";
import { XMarkIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
// import DownloadImg from "./DownloadImg.vue";
import ArrowRight from "../Icons/ArrowRight.vue";
import Modal from "../Modal.vue";
import Avatar from '@/Components/Avatar.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '6xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    position: {
        required: false,
        type: String,
        default: 'center',
    },
    media: {
        required: true,
        type: Array,
    }, user: Object
})
const emits = defineEmits(['close'])
const main = ref();
const thumbs = ref();
let showSavePanel = ref(false)
const currentMediaUrl = ref(props.media[0].original_url)
const currentMediaName = ref(props.media[0].file_name)
const mainOptions = {
    arrows: props.media.length > 1 ? true : false,
    type: props.media.length > 1 ? "loop" : 'slide',
    perPage: 1,
    perMove: 1,
    gap: "1rem",
    pagination: false,
    fixedHeight: "50vh",
};
const thumbsOptions = {
    type: "slide",
    rewind: true,
    gap: "1rem",
    pagination: false,
    fixedWidth: 110,
    fixedHeight: 110,
    cover: true,
    drag: 'free',
    snap: true,
    isNavigation: true,
    updateOnMove: true,
    arrows: false,
    //   focus: 'center',
};
onMounted(() => {
    const thumbsSplide = thumbs.value?.splide;
    if (thumbsSplide) {
        main.value?.sync(thumbsSplide);
    }
});
function handleSplideActive(e) {
    currentMediaUrl.value = props.media[e.index].original_url
    currentMediaName.value = props.media[e.index].file_name
}
</script>
<style scoped>
[some-slider] li.is-active {
    transform: scale(0.9);
    outline: 1px solid rgb(0, 100, 0)
}
</style>
<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" :position="position" @close="$emit('close')"
        :show-close-icon="false">
        <div class="py-5 bg-white px-7">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Avatar :image-url="user.avatar_url" :size="'md'" :username="user.name" :border="true" />
                    <div>
                        <div class="text-primary">{{ user.name }}</div>
                        <Link class="text-xs text-gray-400" :href="route('player.profile', user.id)">@{{ user.username
                        }}
                        </Link>
                        <div class="text-xs text-gray-400">10/01/2021 at 1:30 pm</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a :href="currentMediaUrl" :download="currentMediaName">
                        <ArrowDownTrayIcon class="w-6 text-black cursor-pointer" @click="showSavePanel = true" />
                    </a>
                    <XMarkIcon class="w-6 text-black cursor-pointer" @click="$emit('close')" />
                </div>
            </div>
            <div class="my-4">
                <Splide @splide:moved="handleSplideActive" aria-labelledby="thumbnail-example-heading"
                    :options="mainOptions" ref="main" :has-track="false">
                    <div v-show="props.media.length > 1" class="splide__arrows">
                        <button class="splide__arrow splide__arrow--prev"
                            style="background-color: black !important; opacity: 1" aria-label="Next slide"
                            aria-controls="splide01-track">
                            <ArrowRight />
                        </button>
                        <button class="splide__arrow splide__arrow--next"
                            style="background-color: black !important; opacity: 1" aria-label="Previous slide"
                            aria-controls="splide01-track">
                            <ArrowRight />
                        </button>
                    </div>
                    <SplideTrack id="splide01-track">
                        <SplideSlide v-for="item in media" :key="item.id" class="w-full my-4 ">
                            <!-- <img :src="'/images/selfie_example.png'" alt="" /> -->
                            <template v-if="item.mime_type.startsWith('image')">
                                <img class="h-full mx-auto rounded-lg w-[min(500px , 90%)]" :src="item?.original_url"
                                    alt="">
                            </template>
                            <template v-else-if="item.mime_type.startsWith('video')">
                                <video controls class="h-full max-w-full  mx-auto rounded-lg w-[min(500px , 90%)]">
                                    <source :src="item.original_url" :type="item.mime_type">
                                </video>
                            </template>
                        </SplideSlide>
                    </SplideTrack>
                </Splide>
            </div>
            <div v-show="props.media.length > 1" class="" some-slider>
                <Splide :options="thumbsOptions" ref="thumbs" class="[&_ul]:justify-center">
                    <SplideSlide v-for="item in media" :key="item.id" class="overflow-hidden rounded-lg"
                        style="border: none !important ;">
                        <!-- <img :src="'/images/selfie_example.png'" :alt="slide.alt" /> -->
                        <template v-if="item.mime_type.startsWith('image')">
                            <img class="object-cover w-full h-full" :src="item?.original_url" alt="">
                        </template>
                        <template v-else-if="item.mime_type.startsWith('video')">
                            <video class="object-cover w-full h-full">
                                <source :src="item.original_url" :type="item.mime_type">
                            </video>
                        </template>
                    </SplideSlide>
                </Splide>
            </div>
            <template v-if="showSavePanel">
                <!-- <DownloadImg v-model:showSavePanel="showSavePanel" /> -->
            </template>
        </div>
    </Modal>
</template>
