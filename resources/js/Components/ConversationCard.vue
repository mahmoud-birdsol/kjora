<template>
    <Link :href="route('chats.show', conversation.id)">
    <div class="bg-[url(/images/player_bg_lg.png)] bg-cover relative rounded-2xl p-6 flex flex-col gap-8 items-start bg-[center_top]"
        :class="active ? 'border-stone-400 shadow-md border-4' : null">


        <div class="flex flex-row items-center w-full gap-4">
            <div>
                <img :src="user.avatar ? user.avatar_url : 'https://ui-avatars.com/api/?name=' + user.name + '&color=094609FF&background=E2E2E2'"
                    alt="" class="object-cover w-10 h-10 rounded-full">
            </div>
            <div class="flex flex-col ">
                <h4 class="m-0 text-lg leading-none text-white capitalize">{{ user.name }}</h4>
                <span class="text-xs leading-none text-neutral-500"> {{ user.username }} </span>
            </div>
            <div class="flex flex-col items-center gap-1 mis-auto">
                <span class="text-xs text-neutral-500">{{ dayjs(lastActiveAt).format('h') }} hours</span>
                <!-- <span class="text-xs text-neutral-500">{{ "2" }} hours</span> -->

            </div>
        </div>
        <div class="flex w-full gap-4">
            <p class="text-sm text-white truncate ">most new messages from every friend ffffff</p>
            <div class="mis-auto pie-3 ">
                <TrashIcon class="w-6 h-6 text-white cursor-pointer hover:text-red-500 " />
            </div>
        </div>



    </div>
    </Link>
</template>

<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import { computed, onMounted } from 'vue';

const props = defineProps({
    conversation: Object,
    active: Boolean,
    lastActiveAt: null,
})
const user = computed(() => {
    return props.conversation?.users ? props.conversation?.users[0] : null;
})



onMounted(() => {
    // console.log('user', props.conversation.users[0])
    // console.log('user', props.conversation.users[0].username)
    // console.log('user', props.conversation.users[0].avatar)
    // console.log('user comp', user.value)
});


</script>

<style  scoped></style>
