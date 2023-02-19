<script setup >
import { ElRate } from 'element-plus';
import { Link } from '@inertiajs/inertia-vue3';

import {

    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';
defineProps({
    player: null
})
</script>
<template>
    <div class="p-4 rounded-xl"
        style="background: url('/images/player_bg_sm.png'); background-size: cover; background-position: center;">
        <div class="flex items-start justify-between">
            <div class="flex justify-start mb-2 space-x-2">
                <img :src="player.avatar ? player.avatar_url : 'https://ui-avatars.com/api/?name=' + player.name + '&color=094609FF&background=E2E2E2'"
                    :alt="player.name" class="border-2 border-white rounded-full h-14 w-14">
                <div>
                    <Link :href="route('player.profile', player.id)">
                    <h2 class="text-sm font-bold text-white">
                        {{ player.first_name }} {{ player.last_name }}
                    </h2>
                    </Link>

                    <p class="text-xs text-white opacity-50">@{{ player.username }}</p>
                    <p class="flex items-center space-x-2 text-sm text-white">
                        <ElRate v-model="player.rating" size="small" />
                        {{ player.rating }}
                    </p>
                </div>
            </div>
            <div>
                <p class="text-sm font-bold text-white">$ {{ player.hourly_rate }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 border-b border-white">
            <div>
                <p class="text-xs text-center text-white opacity-50 text-light">Age</p>
                <p class="text-sm text-center text-white font-semi-bold">{{ player.age }}</p>
            </div>
            <div>
                <p class="text-xs text-center text-white opacity-50 text-light">Played</p>
                <p class="text-sm text-center text-white font-semi-bold">0</p>
            </div>
            <div>
                <p class="text-xs text-center text-white opacity-50 text-light">Missed</p>
                <p class="text-sm text-center text-white font-semi-bold">0</p>
            </div>
            <div>
                <p class="text-xs text-center text-white opacity-50 text-light">Position</p>
                <p class="text-sm text-center text-white font-semi-bold">{{
                    player.position.name
                }}</p>
            </div>
        </div>
        <!-- adress -->
        <div class="flex items-center justify-between mt-2">
            <p class="flex items-center text-sm text-white">
                <MapPinIcon class="inline w-4 h-4 text-white" />
                Cairo
            </p>

            <Link :href="route('invitation.create', player.id)" class="text-sm text-white">Send
            Invitation
            <ChevronDoubleRightIcon class="inline w-4 h-4 text-white" />
            </Link>
        </div>

        <div class="flex items-center justify-between mt-6">
            <div>
                <div class="flex items-center justify-center w-10 h-10 bg-black rounded-full">
                    <span class="text-xs text-white">70KM</span>
                </div>
            </div>
            <div>
                <FlagIcon class="w-6 h-6 text-red-500" />
            </div>
        </div>
    </div>
</template>



<style lang="scss" scoped></style>
