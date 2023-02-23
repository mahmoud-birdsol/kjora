<template>
    <!-- information -->
    <div class="grid grid-cols-[min-content_1fr] gap-4">
        <!-- col 1 -->
        <div class="min-w-max ">
            <Avatar :username="comment.user.name" :image-url="comment.user.avatar_url" :size="'md'" :border="true"
                border-color="primary" />
        </div>
        <!-- col 2 -->
        <div class="flex flex-col gap-1">
            <!-- user information row 1-->
            <div class="flex w-full justify-between">
                <div class="flex  gap-1 ">
                    <div class="flex flex-row gap-2">
                        <h3 class="font-bold m-0 text-lg text-stone-800 leading-none  capitalize ">{{
                            comment.user.first_name }} </h3>
                        <span v-if="false">star icon</span>
                    </div>
                    <span class="text-xs text-stone-400 ">@{{ comment.user.username }} </span>
                </div>
                <div class="flex flex-row gap-2 text-neutral-400/90 text-xs">
                    <span>{{ dayjs(comment.created_at).fromNow(true) }}</span>
                    <span>|</span>
                    <span>{{ dayjs(comment.created_at).format('hh:mm A') }}</span>
                </div>
            </div>
            <!-- date and time and likes row 2-->
            <div>
                <p class="text-sm text-stone-800">
                    {{ comment.body }}
                </p>
            </div>
            <!-- caption row 3 -->
            <div class="flex w-full text-sm gap-2 justify-start text-stone-700 font-semibold ">
                <button
                    class="p-1 enabled:hover:underline hover:underline-offset-4 transition-all duration-150">Reply</button>
                <button
                    class="p-1 enabled:hover:underline hover:underline-offset-4 transition-all duration-150">Like</button>
            </div>
            <button v-if="comment.replies.length"
                class="flex w-full text-sm gap-2 justify-start text-stone-500 enabled:hover:underline hover:underline-offset-4 transition-all duration-300  ">
                view {{ comment.replies && comment.replies.length }} replies
            </button>
        </div>
    </div>
</template>

<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime.js';
import Avatar from './Avatar.vue';
import { onBeforeMount } from 'vue';
const props = defineProps(['user', 'mediaId', 'comment'])
onBeforeMount(() => {
    dayjs.extend(relativeTime)
})
</script>

<style  scoped></style>
