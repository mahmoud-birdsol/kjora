<template>
    <AppLayout title="gallery">
        <template #header>
            <p>{{ $t('post') }}</p>
        </template>
        <PostLayout>
            <template #media>
                <PostMedia :postMedia="post.media" :user="user"></PostMedia>
            </template>
            <template #userImage>
                <Avatar :id="user.id" :username="user.name" :image-url="user.avatar_url" :size="'lg'" :border="true" border-color="primary" />
            </template>
            <template #userInfo>
                <div class="flex justify-between w-full">
                    <div class="flex flex-col gap-1 ">
                        <div class="flex flex-row gap-2">
                            <h3 class="m-0 text-lg font-bold leading-none capitalize ">{{ user.name
                            }} </h3>
                            <span v-if="false">star icon</span>
                        </div>
                        <Link :href="route('player.profile', user.id)" class="text-xs text-stone-400 ">@{{
                            user.username }} </Link>
                    </div>
                    <PostOptionMenu :isCurrentUser="isCurrentUser" :postId="post.id" @editingCaption="postCaptionComp ? postCaptionComp.isEditingCaption = true : null">
                    </PostOptionMenu>
                </div>
            </template>
            <template #postDate&Time>
                <div class="flex justify-between w-full gap-2 text-sm text-stone-700">
                    <div class="flex flex-row gap-2">
                        <DateTranslation :start="post.created_at" type="range" />
                        <span>|</span>
                        <DateTranslation :start="post.created_at" format="hh:mm A" />
                    </div>
                    <div class="flex items-center gap-1">
                        <span v-if="post?.likes_count > 0" class="text-sm">{{ post?.likes_count }}</span>
                        <LikeButton :isLiked="post?.is_liked" :likeable_id="post.id" :likeable_type="'App\\Models\\Post'">
                            <template v-slot="{ isLiked }">
                                <HeartIcon class="w-5 stroke-current stroke-2 text-primary" :class="isLiked ? 'fill-current' : 'fill-transparent'" />
                            </template>
                        </LikeButton>
                    </div>
                </div>
            </template>
            <template #postCaption>
                <PostCaptionFrom ref="postCaptionComp" :post="post"></PostCaptionFrom>
            </template>

            <template #commentsCount>
                <div class="p-3 pt-5 text-sm border-b border-stone-300"> {{ $t('comments ( :count )', {
                    count: numComments
                }) }}
                </div>
            </template>
            <template #postComments>
                <div ref="commentsContainer" @scroll="handleScroll" class="flex flex-col gap-4 w-full max-h-[500px] min-h-[480px]  hideScrollBar overflow-auto" v-if="postComments">
                    <template v-for="comment in postComments.filter(c => !c.parent_id)" :key="comment.id">
                        <Comment @addedReply="getPostComments" :comment="comment" ref="commentsComps" :parentOffset="commentsContainerOffset" />
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
import { onMounted, onBeforeMount, ref, computed } from 'vue';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import { HeartIcon } from '@heroicons/vue/24/solid';
import AppLayout from '../../Layouts/AppLayout.vue';
import Avatar from '../../Components/Avatar.vue';
import Comment from '../../Components/Comment.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import LikeButton from '@/Components/LikeButton.vue';
import DateTranslation from '../../Components/DateTranslation.vue';

import PostMedia from '../../Components/Posts/PostMedia.vue';
import PostLayout from '../../Components/Posts/PostLayout.vue';
import PostOptionMenu from '../../Components/Posts/PostOptionMenu.vue';
import PostCaptionFrom from '../../Components/Posts/PostCaptionFrom.vue';
import PostCommentForm from '../../Components/Posts/PostCommentForm.vue';


onBeforeMount(() => {
    dayjs.extend(relativeTime)
});

const props = defineProps({
    user: null,
    post: null
})


const commentsContainer = ref(null);
const postCaptionComp = ref(null);
const postComments = ref([])
const currentUser = usePage().props.value.auth.user
const isCurrentUser = currentUser.id === props.user.id


const numComments = computed(() => postComments.value ? postComments.value.filter(c => !c.parent_id)?.length : 0)
const commentsContainerOffset = computed(() => {
    return commentsContainer.value?.getBoundingClientRect().top + window.scrollY
})



onMounted(() => {
    getPostComments()
});


function getPostComments() {
    axios.get(route('api.gallery.comments'), {
        params: {
            commentable_id: props.post.id,
            commentable_type: 'App\\Models\\Post'
        }
    }).then(res => {
        postComments.value = res.data.data
        scrollToCommentsBottom()
    }).catch(err => console.error(err))
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

</script>

<style lang="scss" scoped></style>
