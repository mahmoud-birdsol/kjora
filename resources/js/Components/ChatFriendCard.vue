<template>
    <div
        class="bg-[url(/images/player_bg_lg.png)] bg-cover rounded-2xl p-6 flex flex-row gap-4 items-center bg-[center_60%]">
        <div><img
                :src="friend.imgUrl ? friend.imgUrl : 'https://ui-avatars.com/api/?name=' + friend.name + '&color=094609FF&background=E2E2E2'"
                alt="" class="object-cover w-10 h-10 rounded-full">
        </div>
        <div class="flex flex-col ">
            <h4 class="m-0 text-lg leading-none text-white capitalize">{{ friend.name }}</h4>
            <span class="text-xs leading-none text-neutral-500"> {{ friend.userName }} </span>
        </div>
        <div class="mis-auto">
            <TrashIcon class="w-6 h-6 text-white " />
        </div>
    </div>
</template>

<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline'
defineProps({
    friend: Object
})
</script>

<style lang="scss" scoped>

</style>
