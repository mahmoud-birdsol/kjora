<script setup>
import Avatar from "@/Components/Avatar.vue";
import DateTranslation from "@/Components/DateTranslation.vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import PostCaptionFrom from "@/Pages/Posts/Partials/PostCaptionForm.vue";
import PostLayout from "@/Pages/Posts/Partials/PostLayout.vue";
import PostMedia from "@/Pages/Posts/Partials/PostMedia.vue";
import { usePostStore } from "@/stores/post";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime.js";
import { onBeforeMount, onMounted, ref, watch } from "vue";

onBeforeMount(() => {
   dayjs.extend(relativeTime);
});

const props = defineProps({
   user: Object,
   post: Object,
});

const postStore = usePostStore();
const commentsContainer = ref(null);
const postCaptionComp = ref(null);

onMounted(() => {
   postStore.initialize({
      post: props.post,
      commentsContainer: commentsContainer.value,
   });
});
watch(
   () => props.post,
   (newPost) => {
      postStore.updatePostObject(newPost);
   }
);
</script>
<template>
   <PublicLayout title="Posts">
      <template #header>
         <p>{{ $t("post") }}</p>
      </template>
      <PostLayout>
         <template #media>
            <PostMedia />
         </template>
         <template #userImage>
            <Avatar
               :id="user.id"
               :username="user.name"
               :image-url="user.avatar_url"
               :size="'md'"
               :border="true"
               border-color="primary"
            />
         </template>
         <template #userInfo>
            <div class="flex justify-between w-full">
               <div class="flex flex-col">
                  <div class="flex flex-row gap-2">
                     <h3 class="m-0 text-lg font-bold leading-none capitalize">
                        {{ user.name }}
                     </h3>
                     <span v-if="false">star icon</span>
                  </div>
                  <Link
                     :href="route('public.player', user.id)"
                     class="text-xs text-stone-400"
                     >@{{ user.username }}
                  </Link>
               </div>
            </div>
         </template>
         <template #postDate&Time>
            <div
               class="flex justify-between w-full gap-2 text-[10px] text-stone-400"
            >
               <div class="flex flex-row gap-1">
                  <DateTranslation :start="post.created_at" type="range" />
                  <span>|</span>
                  <DateTranslation :start="post.created_at" format="hh:mm A" />
               </div>
            </div>
         </template>
         <template #postCaption>
            <PostCaptionFrom
               ref="postCaptionComp"
               :post="post"
            ></PostCaptionFrom>
         </template>
         <template #commentsCount>
            <div
               class="grid place-items-center min-h-[200px] font-bold"
               ref="commentsContainer"
            >
               <div>
                  {{ $t("please") }}
                  <Link :href="route('register')" class="text-blue-700">
                     {{ $t("sign up") }}
                  </Link>
                  {{ $t("to kjora to view more photos and videos") }}
               </div>
            </div>
         </template>
      </PostLayout>
   </PublicLayout>
</template>
