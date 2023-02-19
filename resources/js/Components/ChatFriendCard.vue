<template>
    <div
        class="bg-[url(/images/player_bg_lg.png)] bg-cover relative rounded-2xl p-6 flex flex-col gap-8 items-start bg-[center_top] ">


        <div class="w-full flex flex-row gap-4 items-center">
            <div>
                <img :src="friend.imgUrl ? friend.imgUrl : 'https://ui-avatars.com/api/?name=' + friend.name + '&color=094609FF&background=E2E2E2'"
                    alt="" class="object-cover w-10 h-10 rounded-full">
            </div>
            <div class="flex flex-col ">
                <h4 class="m-0 text-lg leading-none text-white capitalize">{{ friend.name }}</h4>
                <span class="text-xs leading-none text-neutral-500"> {{ friend.userName }} </span>
            </div>
            <div class=" mis-auto flex flex-col items-center gap-1  ">
                <div class="rounded-full bg-white aspect-square w-10 grid place-content-center ">
                    <span class="text-primary font-bold">1</span>
                </div>
                <span class="text-neutral-500 text-xs">2 hours</span>

            </div>
        </div>
        <div class="flex w-full">
            <p class="pis-6 text-white">most new messages from every friend</p>
            <div class="mis-auto pie-3 ">
                <TrashIcon class="w-6 h-6 text-white cursor-pointer hover:text-red-500 " />
            </div>
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
