<script setup>
import Avatar from "@/Components/Avatar.vue";
import DateTranslation from "@/Components/DateTranslation.vue";
import LikeButton from "@/Components/LikeButton.vue";
import LikesModal from "@/Components/LikesModal.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Comment from "@/Pages/Posts/Partials/Comment.vue";
import PostCaptionFrom from "@/Pages/Posts/Partials/PostCaptionForm.vue";
import PostCommentForm from "@/Pages/Posts/Partials/PostCommentForm.vue";
import PostLayout from "@/Pages/Posts/Partials/PostLayout.vue";
import PostMedia from "@/Pages/Posts/Partials/PostMedia.vue";
import PostOptionMenu from "@/Pages/Posts/Partials/PostOptionMenu.vue";
import { usePostStore } from "@/stores/post";
import { StarIcon } from "@heroicons/vue/24/outline";
import { HeartIcon } from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime.js";
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { useUserStore } from "@/stores";

onBeforeMount(() => {
   dayjs.extend(relativeTime);
});

const props = defineProps({
   post: Object,
});

const postStore = usePostStore();
const userStore = useUserStore();
const commentsContainer = ref(null);
const showLikesModal = ref(false);

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
   <AppLayout title="gallery" :showBall="false">
      <template #header>
         <p>{{ $t("post") }}</p>
      </template>
      <PostLayout>
         <template #media>
            <PostMedia />
         </template>
         <template #userImage>
            <Avatar
               :id="post.user.id"
               :username="post.user.name"
               :image-url="post.avatar_url"
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
                        {{ post.user.name }}
                     </h3>

                     <div
                        v-if="userStore?.currentUser?.state_name === 'Premium'"
                        class="shrink-0"
                     >
                        <div class="w-4 rounded-full bg-golden aspect-square">
                           <StarIcon class="fill-white stroke-none" />
                        </div>
                     </div>
                  </div>
                  <Link
                     :href="route('player.profile', post.user.id)"
                     class="text-xs text-stone-400"
                     >@{{ post.user.username }}
                  </Link>
               </div>
               <PostOptionMenu />
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
            <PostCaptionFrom :post="post" />
         </template>

         <template #commentsCount>
            <div
               class="flex items-center justify-between p-4 pt-5 border-b border-stone-300"
            >
               <div class="text-sm">
                  {{
                     $t("comments ( :count )", {
                        count: postStore.parentCommentsCount,
                     })
                  }}
               </div>
               <div class="flex items-center gap-1">
                  <button
                     v-if="post?.likes_count > 0"
                     @click="showLikesModal = true"
                  >
                     <span class="text-sm">{{ post?.likes_count }}</span>
                     <LikesModal
                        :show="showLikesModal"
                        :users="post.likes?.map((like) => like.user)"
                        @close="showLikesModal = false"
                     />
                  </button>
                  <LikeButton
                     :canLike="!postStore.isPostUserTheCurrentUser"
                     :isLiked="post?.is_liked"
                     :likeable_id="post.id"
                     :likeable_type="postStore.POST_MODEL_TYPE"
                  >
                     <template v-slot="{ isLiked }">
                        <HeartIcon
                           class="w-4 stroke-current stroke-2 text-primary"
                           :class="
                              isLiked ? 'fill-current' : 'fill-transparent'
                           "
                        />
                     </template>
                  </LikeButton>
               </div>
            </div>
         </template>
         <template #postComments>
            <div
               ref="commentsContainer"
               class="flex flex-col w-full max-h-[500px] px-6 hideScrollBar overflow-auto"
               v-show="postStore.parentCommentsCount"
            >
               <template
                  v-for="comment in postStore.parentComments"
                  :key="comment.id"
               >
                  <Comment :comment="comment" />
               </template>
            </div>
         </template>
         <template #newCommentForm>
            <PostCommentForm />
         </template>
      </PostLayout>
   </AppLayout>
</template>
