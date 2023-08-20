<script setup>
import { computed, ref } from "vue";
import VueEasyLightbox, { useEasyLightbox } from "vue-easy-lightbox";
import { Link, usePage } from "@inertiajs/vue3";
import { useUserStore } from "@/stores/index.js";

const props = defineProps({
   imageUrl: {
      required: false,
      type: String,
   },
   size: {
      required: false,
      type: String,
      default: "sm",
   },
   username: {
      required: false,
      type: String,
      default: "Kjora",
   },
   border: {
      required: false,
      type: Boolean,
      default: false,
   },
   borderColor: {
      default: "primary",
   },
   enableLightBox: {
      required: false,
      type: Boolean,
      default: true,
   },
   id: {
      required: true,
      type: Number,
   },
});
const userStore = useUserStore();
const currentUser = userStore.currentUser ?? null;
//
const isCurrentUser = currentUser?.id === props?.id;
const isPlayerProfile = usePage().url.includes("player/");
//
const sizeClasses = computed(() => {
   return {
      sm: "h-8 w-8",
      md: "h-10 w-10",
      lg: "h-14 w-14",
      xlg: "h-20 w-20",
   }[props.size];
});
const borderColorClass = computed(() => {
   return {
      white: "border-white",
      primary: "border-primary",
      black: "border-stone-800",
      blackDark: "border-black",
      golden: "border-golden",
   }[props.borderColor];
});

const borderClasses = computed(() => {
   return props.border ? "border-2 " : "border-none";
});

// adding vue light boc on click on player image
const visibleRef = ref(false);
const imgsRef = ref(null);
const showLightBox = () => {
   if (props.enableLightBox) {
      imgsRef.value =
         props.imageUrl ??
         `https://ui-avatars.com/api/?name=${props.username}&color=094609FF&background=E2E2E2`;
      visibleRef.value = true;
   }
};
function hideLightBox() {
   visibleRef.value = false;
}
</script>

<template>
   <template v-if="isPlayerProfile" class="text-red-600 bg-white">
      <span
         @click="showLightBox"
         v-if="imageUrl"
         class="block bg-center bg-no-repeat bg-cover rounded-full cursor-pointer"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="'background-image: url(' + imageUrl + ');'"
      />
      <span
         v-else
         @click="showLightBox"
         class="block bg-center bg-no-repeat bg-cover rounded-full"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="
            'background-image: url(\'https://ui-avatars.com/api/?name=' +
            username +
            '&color=094609FF&background=E2E2E2\');'
         "
      />
   </template>

   <template v-else>
      <Link
         v-if="!isCurrentUser && imageUrl && id"
         :href="route('player.profile', id)"
         class="block bg-center bg-no-repeat bg-cover rounded-full cursor-pointer"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="'background-image: url(' + imageUrl + ');'"
      >
      </Link>
      <Link
         v-else-if="!isCurrentUser && !imageUrl && id"
         :href="route('player.profile', id)"
         class="block bg-center bg-no-repeat bg-cover rounded-full"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="
            'background-image: url(\'https://ui-avatars.com/api/?name=' +
            username +
            '&color=094609FF&background=E2E2E2\');'
         "
      />
      <span
         @click="showLightBox"
         v-else-if="imageUrl"
         class="block bg-center bg-no-repeat bg-cover rounded-full cursor-pointer"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="'background-image: url(' + imageUrl + ');'"
      />
      <span
         v-else
         class="block bg-center bg-no-repeat bg-cover rounded-full"
         :class="[sizeClasses, borderClasses, borderColorClass]"
         :style="
            'background-image: url(\'https://ui-avatars.com/api/?name=' +
            username +
            '&color=094609FF&background=E2E2E2\');'
         "
      />
   </template>
   <vue-easy-lightbox
      :visible="visibleRef"
      :imgs="imgsRef"
      @hide="hideLightBox"
      :data-lightBox="
         currentUser?.state_name !== 'Premium' ? 'avatar' : 'avatar-golden'
      "
      :zoomDisabled="true"
      :minZoom="1"
      :moveDisabled="true"
   >
   </vue-easy-lightbox>
</template>

<style>
:is([data-lightBox="avatar"], [data-lightBox="avatar-golden"])
   .vel-img-wrapper {
   overflow: hidden;
   border-radius: 50%;
   aspect-ratio: 1/1;
   max-width: 250px;
   min-width: 150px;
}

[data-lightBox="avatar"] .vel-img-wrapper {
   border: 5px solid rgb(0, 100, 0);
}

[data-lightBox="avatar-golden"] .vel-img-wrapper {
   border: 5px solid #d1c37a;
}

:is([data-lightBox="avatar"], [data-lightBox="avatar-golden"])
   .vel-img-wrapper
   img {
   height: 100%;
   width: 100%;
   object-fit: cover;
}

:is([data-lightBox="avatar"], [data-lightBox="avatar-golden"])
   .vel-toolbar
   .toolbar-btn__zoomin,
:is([data-lightBox="avatar"], [data-lightBox="avatar-golden"])
   .vel-toolbar
   .toolbar-btn__zoomout {
   display: none;
}
</style>
