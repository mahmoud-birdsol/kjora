<script setup>
import Avatar from "@/Components/Avatar.vue";
import Comment from "@/Pages/Posts/Partials/Comment.vue";
import DateTranslation from "@/Components/DateTranslation.vue";
import LikeButton from "@/Components/LikeButton.vue";
import LikesModal from "@/Components/LikesModal.vue";
import PostCaptionFrom from "@/Pages/Posts/Partials/PostCaptionForm.vue";
import PostCommentForm from "@/Pages/Posts/Partials/PostCommentForm.vue";
import PostLayout from "@/Pages/Posts/Partials/PostLayout.vue";
import PostMedia from "@/Pages/Posts/Partials/PostMedia.vue";
import PostOptionMenu from "@/Pages/Posts/Partials/PostOptionMenu.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { StarIcon } from "@heroicons/vue/24/outline";
import { HeartIcon } from "@heroicons/vue/24/solid";
import { Link, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime.js";
import { computed, onBeforeMount, onMounted, ref } from "vue";
import { usePostStore } from "@/stores/post";

onBeforeMount(() => {
   dayjs.extend(relativeTime);
});

const props = defineProps({
   //to remove replace with postUser in store
   user: null,
   post: Object,
});
const postStore = usePostStore();
const commentsContainer = ref(null);
//to remove
const postCaptionComp = ref(null);
//add to the store
const showLikesModal = ref(false);

const isCurrentUser = postStore.isPostUserTheCurrentUser.value;

onMounted(() => {
   postStore.initialize({
      post: props.post,
      commentsContainer: commentsContainer.value,
   });
});

//done
</script>
<template>
   <AppLayout title="gallery" :showBall="false">
      <template #header>
         <p>{{ $t("post") }}</p>
      </template>
      <PostLayout>
         <template #media>
            <PostMedia :postMedia="post.media" :user="user"></PostMedia>
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
                     // todo:replace with user store
                     <div
                        v-if="$page.props?.auth?.user?.state_name === 'Premium'"
                        class="shrink-0"
                     >
                        <div class="w-4 rounded-full bg-golden aspect-square">
                           <StarIcon class="fill-white stroke-none" />
                        </div>
                     </div>
                  </div>
                  <Link
                     :href="route('player.profile', user.id)"
                     class="text-xs text-stone-400"
                     >@{{ user.username }}
                  </Link>
               </div>
               <PostOptionMenu
                  :isCurrentUser="isCurrentUser"
                  :postId="post.id"
                  @editingCaption="
                     postCaptionComp
                        ? (postCaptionComp.isEditingCaption = true)
                        : null
                  "
               >
               </PostOptionMenu>
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
                     :canLike="!isCurrentUser"
                     :isLiked="post?.is_liked"
                     :likeable_id="post.id"
                     :likeable_type="'App\\Models\\Post'"
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
               @scroll="handleScroll"
               class="flex flex-col gap-4 w-full max-h-[500px] hideScrollBar overflow-auto"
               v-if="postStore.comments"
            >
               <template
                  v-for="comment in postStore.parentComments"
                  :key="comment.id"
               >
                  <Comment @addedReply="getPostComments" :comment="comment" />
               </template>
            </div>
         </template>
         <template #newCommentForm>
            <PostCommentForm
               :postId="post.id"
               :commentsContainer="commentsContainer"
               @addComment="getPostComments"
            >
            </PostCommentForm>
         </template>
      </PostLayout>
   </AppLayout>
</template>
