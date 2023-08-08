<script setup>
import { Splide, SplideSlide, SplideTrack } from "@splidejs/vue-splide";
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import "@splidejs/vue-splide/css";
import { XMarkIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import ArrowRight from "@/Components/Icons/ArrowRight.vue";
import Modal from "@/Components/Modal.vue";
import Avatar from "@/Components/Avatar.vue";
import DateTranslation from "@/Components/DateTranslation.vue";
import dayjs from "dayjs";

const props = defineProps({
   show: {
      type: Boolean,
      default: false,
   },
   maxWidth: {
      type: String,
      default: "6xl",
   },
   closeable: {
      type: Boolean,
      default: true,
   },
   position: {
      required: false,
      type: String,
      default: "center",
   },
   media: {
      required: true,
      type: Array,
   },
   user: Object,
});
const emits = defineEmits(["close"]);
const main = ref();
const thumbs = ref();
let showSavePanel = ref(false);
const currentMediaUrl = ref(props.media[0].original_url);
const currentMediaName = ref(props.media[0].file_name);
const mainOptions = {
   arrows: props.media.length > 1 ? true : false,
   type: props.media.length > 1 ? "loop" : "slide",
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
   fixedHeight: 150,
   autoWidth: true,
   // cover: true,
   drag: "free",
   snap: true,
   isNavigation: true,
   updateOnMove: true,
   arrows: false,
   perPage: props.media.length > 5 ? 5 : props.media.length,
   width: "100%",
   breakpoints: {
      640: {
         perPage: 3,
         width: props.media.length > 5 ? "100%" : "70%",
      },
   },

   //   focus: 'center',
};
onMounted(() => {
   const thumbsSplide = thumbs.value?.splide;
   if (thumbsSplide) {
      main.value?.sync(thumbsSplide);
   }
});
function handleSplideActive(e) {
   currentMediaUrl.value = props.media[e.index].original_url;
   currentMediaName.value = `Kjora-${dayjs().format("YYYY-MM-DD-HH-mm-ss")}`;
}
</script>
<style scoped>
[some-slider] li.is-active img {
   transform: scale(0.9);
   outline: 1px solid rgb(0, 100, 0);
}

.splide {
   margin: auto;
}
</style>
<template>
   <Modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      :position="position"
      @close="$emit('close')"
      :show-close-icon="false"
   >
      <div class="max-w-full py-5 bg-white px-7">
         <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
               <Avatar
                  :id="user.id"
                  :image-url="user.avatar_url"
                  :size="'md'"
                  :username="user.name"
                  :border="true"
               />
               <div>
                  <div class="text-primary">{{ user.name }}</div>
                  <Link
                     class="text-xs text-gray-400"
                     :href="route('player.profile', user.id)"
                     >@{{ user.username }}
                  </Link>
                  <div class="text-xs text-gray-400">
                     <DateTranslation
                        :start="media[0].created_at"
                        format="DD/MM/YYYY hh:mm a"
                     />
                  </div>
               </div>
            </div>
            <div class="flex gap-2">
               <a
                  :href="currentMediaUrl"
                  :download="currentMediaName"
                  v-if="route().current('chats.show')"
               >
                  <ArrowDownTrayIcon
                     class="w-6 text-black cursor-pointer"
                     @click="showSavePanel = true"
                  />
               </a>
               <XMarkIcon
                  class="w-6 text-black cursor-pointer"
                  @click="$emit('close')"
               />
            </div>
         </div>
         <div class="my-4">
            <Splide
               dir="ltr"
               @splide:moved="handleSplideActive"
               aria-labelledby="thumbnail-example-heading"
               :options="mainOptions"
               ref="main"
               :has-track="false"
            >
               <div v-show="props.media.length > 1" class="splide__arrows">
                  <button
                     class="splide__arrow splide__arrow--prev"
                     style="background-color: black !important; opacity: 1"
                     aria-label="Next slide"
                     aria-controls="splide01-track"
                  >
                     <ArrowRight />
                  </button>
                  <button
                     class="splide__arrow splide__arrow--next"
                     style="background-color: black !important; opacity: 1"
                     aria-label="Previous slide"
                     aria-controls="splide01-track"
                  >
                     <ArrowRight />
                  </button>
               </div>
               <SplideTrack id="splide01-track">
                  <SplideSlide
                     v-for="item in media"
                     :key="item.id"
                     class="w-full my-4"
                  >
                     <template v-if="item.mime_type.startsWith('image')">
                        <img
                           class="object-contain h-full mx-auto rounded-lg w-[min(500px , 90%)]"
                           :src="item?.original_url"
                           alt=""
                        />
                     </template>
                     <template v-else-if="item.mime_type.startsWith('video')">
                        <video
                           :src="item.original_url"
                           controls
                           class="h-full max-w-full mx-auto rounded-lg w-[min(500px , 90%)]"
                        ></video>
                     </template>
                  </SplideSlide>
               </SplideTrack>
            </Splide>
         </div>
         <div v-show="props.media.length > 1" class="" some-slider>
            <Splide
               dir="ltr"
               :options="thumbsOptions"
               ref="thumbs"
               class="[&_ul]:justify-center [&_ul]:items-center"
            >
               <SplideSlide
                  v-for="item in media"
                  :key="item.id"
                  class=""
                  style="border: none !important "
               >
                  <template v-if="item.mime_type.startsWith('image')">
                     <img
                        class="object-contain h-full rounded-lg"
                        :src="item?.original_url"
                        alt=""
                     />
                  </template>
                  <template v-else-if="item.mime_type.startsWith('video')">
                     <video
                        :src="item.original_url"
                        class="object-contain h-full rounded-lg"
                     ></video>
                  </template>
               </SplideSlide>
            </Splide>
         </div>
         <!-- <template v-if="showSavePanel">
                    <DownloadImg v-model:showSavePanel="showSavePanel" />
                </template> -->
      </div>
   </Modal>
</template>
