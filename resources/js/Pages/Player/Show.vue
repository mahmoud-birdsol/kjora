<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import {
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    player: Object,
});
</script>

<template>
    <Head title="Home"/>

    <AppLayout title="Home">
        <template #header>
            <p class="text-2xl font-light">Hello,</p>
            <p class="text-7xl font-black">{{ $page.props.auth.user.first_name }}</p>
            <p class="text-lg font-semibold">{{ dayjs().format('dddd, DD MMMM YYYY') }}</p>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="rounded-xl p-4"
                     style="background: url('/images/player_bg_lg.png'); background-size: cover; background-position: center;">
                    <div class="flex justify-between items-start">
                        <div class="flex justify-start space-x-2 mb-2">
                            <img :src="player.avatar" :alt="player.name"
                                 class="h-14 w-14 rounded-full border-2 border-white">
                            <div>
                                <Link :href="route('player.profile', player.id)">
                                    <h2 class="text-sm text-white font-bold">
                                        {{ player.first_name }} {{ player.last_name }}
                                    </h2>
                                </Link>

                                <p class="text-xs text-white opacity-50">@{{ player.username }}</p>
                                <p class="text-sm text-white flex items-center space-x-2">
                                    <ElRate v-model="player.rating" size="small"/>
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
                            <p class="text-xs text-white opacity-50 text-light text-center">Age</p>
                            <p class="text-sm text-white text-center font-semi-bold">{{ player.age }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-white opacity-50 text-light text-center">Played</p>
                            <p class="text-sm text-white text-center font-semi-bold">0</p>
                        </div>
                        <div>
                            <p class="text-xs text-white opacity-50 text-light text-center">Missed</p>
                            <p class="text-sm text-white text-center font-semi-bold">0</p>
                        </div>
                        <div>
                            <p class="text-xs text-white opacity-50 text-light text-center">Position</p>
                            <p class="text-sm text-white text-center font-semi-bold">{{ player.position.name }}</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <p class="text-white text-sm flex items-center">
                            <MapPinIcon class="inline h-4 w-4 text-white"/>
                            Cairo
                        </p>

                        <Link href="" class="text-sm text-white">Send Invitation
                            <ChevronDoubleRightIcon class="inline h-4 w-4 text-white"/>
                        </Link>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <div>
                            <div class="flex justify-center items-center rounded-full bg-black h-10 w-10">
                                <span class="text-xs text-white">70KM</span>
                            </div>
                        </div>
                        <div>
                            <FlagIcon class="h-6 w-6 text-red-500"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
