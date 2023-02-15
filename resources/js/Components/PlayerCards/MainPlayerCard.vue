<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import {
    MapPinIcon,
    ChevronDoubleRightIcon,
    FlagIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    player: {
        required: true,
        type: Object,
    },
    size: {
        required: false,
        type: String,
        default: 'sm'
    },
    showReport: {
        required: false,
        type: Boolean,
        default: true,
    },
});

const backgroundImage = computed(() => {
    return {
        'sm': '/images/player_bg_sm.png',
        'lg': '/images/player_bg_lg.png',
    }[props.size];
});

</script>

<template>
    <div class="rounded-xl p-4"
         :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div class="flex justify-between items-start">
            <div
                class="flex justify-start mb-2"
                :class="{'space-x-2': size == 'sm', 'space-x-8': size == 'lg'}"
            >
                <Avatar :image-url="player.avatar_url" :size="size" :username="player.name" :border="true"/>

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

        <div
            class="grid gap-4 border-b border-white"
            :class="{'grid-cols-4 pb-4 mt-2': size == 'sm', 'grid-cols-5 pb-8 mt-6': size == 'lg'}"
        >
            <div v-if="size == 'lg'">
                <p class="text-xs text-white opacity-50 text-light text-center">Favorite Club</p>
                <div class="flex justify-center item-center">
                    <img :src="player.club?.logo_thumb" class="h-5 w-5 rounded-full border-2 border-white"/>
                </div>
            </div>
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

            <div class="flex space-x-2">
                <Link :href="route('invitation.create', player.id)" class="text-sm text-white">Send Invitation
                    <ChevronDoubleRightIcon class="inline h-4 w-4 text-white"/>
                </Link>
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <div></div>
            <div v-if="showReport">
                <FlagIcon class="h-4 w-4 text-red-500"/>
            </div>
        </div>
    </div>
</template>
