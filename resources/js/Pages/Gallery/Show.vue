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
                <Avatar :id="user.id" :username="user.name" :image-url="user.avatar_url" :size="'md'" :border="true" border-color="primary" />
            </template>
            <template #userInfo>
                <div class="flex justify-between w-full">
                    <div class="flex flex-col">
                        <div class="flex flex-row gap-2">
                            <h3 class="m-0 text-lg font-bold leading-none capitalize">
                                {{ user.name }}
                            </h3>
                            <div v-if="currentUser?.state_name === 'Premium'" class="shrink-0">
                                <div class="w-4 rounded-full bg-golden aspect-square">
                                    <StarIcon class=" fill-white stroke-none" />
                                </div>
                            </div>
                        </div>
                        <Link :href="route('player.profile', user.id)" class="text-xs text-stone-400">@{{ user.username }}
                        </Link>
                    </div>
                    <PostOptionMenu :isCurrentUser="isCurrentUser" :postId="post.id" @editingCaption="
                        postCaptionComp
                            ? (postCaptionComp.isEditingCaption = true)
                            : null
                    ">
                    </PostOptionMenu>
                </div>
            </template>
            <template #postDate&Time>
                <div class="flex justify-between w-full gap-2 text-[10px] text-stone-400">
                    <div class="flex flex-row gap-1">
                        <DateTranslation :start="post.created_at" type="range" />
                        <span>|</span>
                        <DateTranslation :start="post.created_at" format="hh:mm A" />
                    </div>
                </div>
            </template>
            <template #postCaption>
                <PostCaptionFrom ref="postCaptionComp" :post="post"></PostCaptionFrom>
            </template>

            <template #commentsCount>
                <div class="flex items-center justify-between p-4 pt-5 border-b border-stone-300">
                    <div class="text-sm">
                        {{
                            $t("comments ( :count )", {
                                count: numComments,
                            })
                        }}
                    </div>
                    <div class="flex items-center gap-1">
                        <button v-if="post?.likes_count > 0" @click="showLikesModal = true">
                            <span class="text-sm">{{ post?.likes_count }}</span>
                            <LikesModal :show="showLikesModal" :users="post.likes?.map((like) => like.user)" @close="showLikesModal = false" />
                        </button>
                        <LikeButton :canLiked="isCurrentUser" :isLiked="post?.is_liked" :likeable_id="post.id" :likeable_type="'App\\Models\\Post'">
                            <template v-slot="{ isLiked }">
                                <HeartIcon class="w-4 stroke-current stroke-2 text-primary" :class="
                                    isLiked
                                        ? 'fill-current'
                                        : 'fill-transparent'
                                " />
                            </template>
                        </LikeButton>
                    </div>
                </div>
            </template>
            <template #postComments>
                <div ref="commentsContainer" @scroll="handleScroll" class="flex flex-col gap-4 w-full max-h-[500px] hideScrollBar overflow-auto"
                    v-if="postComments">
                    <template v-for="comment in postComments.filter(
                        (c) => !c.parent_id
                    )" :key="comment.id">
                        <Comment @addedReply="getPostComments" :comment="comment" :users="users" ref="commentsComps" :parentOffset="commentsContainerOffset"
                            :id="comment.id" />
                    </template>
                </div>
            </template>
            <template #newCommentForm>
                <PostCommentForm :postId="post.id" :commentsContainer="commentsContainer" @addComment="getPostComments">
                </PostCommentForm>
            </template>
        </PostLayout>
    </AppLayout>
</template>

<script setup>
import { onMounted, onBeforeMount, ref, computed, provide } from "vue";
import { usePage, Link } from "@inertiajs/inertia-vue3";
import { HeartIcon } from "@heroicons/vue/24/solid";
import AppLayout from "../../Layouts/AppLayout.vue";
import Avatar from "../../Components/Avatar.vue";
import Comment from "../../Components/Comment.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime.js";
import LikeButton from "@/Components/LikeButton.vue";
import DateTranslation from "../../Components/DateTranslation.vue";

import PostMedia from "../../Components/Posts/PostMedia.vue";
import PostLayout from "../../Components/Posts/PostLayout.vue";
import PostOptionMenu from "../../Components/Posts/PostOptionMenu.vue";
import PostCaptionFrom from "../../Components/Posts/PostCaptionForm.vue";
import PostCommentForm from "../../Components/Posts/PostCommentForm.vue";
import LikesModal from "../../Components/LikesModal.vue";
import { StarIcon } from "@heroicons/vue/24/outline";

onBeforeMount(() => {
    dayjs.extend(relativeTime);
});

const props = defineProps({
    user: null,
    post: null,
});

const commentsContainer = ref(null);
const commentsComps = ref(null);
const postCaptionComp = ref(null);
const postComments = ref([]);
const showLikesModal = ref(false);
const currentUser = usePage().props.value.auth.user;
const isCurrentUser = currentUser.id === props.user.id;
const users = ref([])
const numComments = computed(() =>
    postComments.value
        ? postComments.value.filter((c) => !c.parent_id)?.length
        : 0
);
const commentsContainerOffset = computed(() => {
    return (
        commentsContainer.value?.getBoundingClientRect().top + window.scrollY
    );
});

onMounted(() => {
    getPostComments();
    fetchUsername();
});

function getPostComments() {
    axios
        .get(route("api.gallery.comments"), {
            params: {
                commentable_id: props.post.id,
                commentable_type: "App\\Models\\Post",
            },
        })
        .then((res) => {
            postComments.value = res.data.data;
            if (!route().params?.commentId) scrollToCommentsBottom();
        })
        .catch((err) => console.error(err));
}
// helper function to scroll comments container to bottom
function scrollToCommentsBottom() {
    setTimeout(() => {
        commentsContainer.value.scrollTo({
            top: commentsContainer.value.scrollHeight,
            left: 0,
            behavior: "smooth",
        });
    }, 100);
}
async function fetchUsername() {
    users.value = await axios.get(route("api.user.get.users.name")).then((res) => res.data.data);
}

</script>

<style lang="scss" scoped></style>
