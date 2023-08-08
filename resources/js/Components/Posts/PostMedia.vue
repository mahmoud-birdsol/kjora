<script setup>
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import { ref } from "vue";

const props = defineProps(['postMedia', 'user'])
const currentMediaIndex = ref(1)
// slider option
const options = {
    arrows: false,
    rewind: false,
    pagination: true,
    // drag: "free",
    fixedHeight: 300,
    type: 'slide',
    focus: "center",
    cover: true,
    perPage: 1,
    perMove: 1,
    snap: true,
    autoplay: false,
};
</script>

<template>
    <div class="relative">
        <Splide @splide:moved="(e) => { currentMediaIndex = e.index + 1 }" dir="ltr" class="" :options="options">
            <template v-for="media in postMedia" :key="media.id">
                <SplideSlide class="">
                    <div class="flex justify-center h-full overflow-hidden group">
                        <img v-if="media.mime_type.startsWith('image') || media.mime_type.startsWith('webp')" :src="media.original_url" alt="" class="object-contain h-full rounded-2xl">
                        <video v-if="media.mime_type.startsWith('video')" controls :src="media.original_url" alt="" class="object-contain h-full rounded-2xl " />
                    </div>
                </SplideSlide>
            </template>
        </Splide>
        <div v-if="postMedia.length > 1" class="absolute p-1 text-xs top-2 right-2 text-stone-200 ">
            <span>{{ currentMediaIndex }}</span>
            <span>/</span>
            <span>{{ postMedia.length }} </span>
        </div>
    </div>
</template>


<style >
.splide__pagination__page.is-active {
    background-color: rgb(0, 100, 0) !important;
}
</style>
