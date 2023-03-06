<script setup>
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import { HeartIcon, PencilIcon } from '@heroicons/vue/20/solid'
import { ChevronDoubleRightIcon, FlagIcon, HeartIcon as HeartIconOutline, MapPinIcon } from '@heroicons/vue/24/outline';
import ReportModal from "@/Components/ReportModal.vue";
import Socials from '@/Components/Socials.vue';

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
    showInvite: {
        required: false,
        type: Boolean,
        default: true,
    },
    showLocation: {
        required: false,
        type: Boolean,
        default: true
    }
});

const backgroundImage = computed(() => {
    return {
        'sm': '/images/player_bg_sm.png',
        'lg': '/images/player_bg_lg.png',
    }[props.size];
});

const currentUser = usePage().props.value.auth.user
const isCurrentUser = props.player.id === currentUser.id

const addToFavorites = () => {
    const form = useForm({});

    form.post(route('favorites.store', { favorite: props.player.id }), {
        preserveState: false,
        preserveScroll: true,
    });
};

const removeFromFavorites = () => {
    const form = useForm({});

    form.delete(route('favorites.destroy', { favorite: props.player.id }), {
        preserveState: false,
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="rounded-xl"
        :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div v-if="player.id !== $page.props.auth.user.id" class="flex justify-end">
            <span class="rounded-lg rounded-bl-3xl bg-white p-2 -mt-0.5 -mr-0.5">
                <a href="javascript:;" @click="addToFavorites" v-if="!player.is_favorite">
                    <HeartIconOutline class="h-5 w-5 text-primary" />
                </a>
                <a href="javascript:;" @click="removeFromFavorites" v-if="player.is_favorite">
                    <HeartIcon class="h-5 w-5 text-primary" />
                </a>
            </span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between">
                <div class="flex justify-start mb-2" :class="{ 'space-x-2': size == 'sm', 'space-x-8': size == 'lg' }">
                    <div class="relative ">
                        <Link :href="route('profile.edit')" v-if="isCurrentUser"
                            class="absolute bottom-0 right-0 p-1 bg-white rounded-full hover:text-primary "
                            title="Edit your profile">
                        <PencilIcon class="w-3 " title="Edit your profile" />
                        </Link>
                        <Avatar :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" />
                    </div>

                    <div>
                        <Link :href="route('player.profile', player.id)" >
                            <h2 class="text-sm font-bold text-white">
                                {{ player.first_name }} {{ player.last_name }}
                            </h2>

                        </Link>
                        <Link class="text-xs text-white opacity-50" :href="route('player.profile', player.id)">@{{ player.username }}</Link>
                        <p class="flex items-center space-x-2 text-sm text-white">
                            <span class="scale-[0.7] origin-left flex items-center gap-x-1">
                                <ElRate disabled v-model="player.rating" size="small" />
                                {{ player.rating }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-1 items-center">
                    <p class="text-sm font-bold text-white">{{ player.preferred_foot === 'right' ? 'R' : 'L' }}</p>
                </div>
            </div>

            <div class="grid gap-4 border-b border-white"
                :class="{ 'grid-cols-4 pb-2 ': size == 'sm', 'grid-cols-5 pb-4 mt-4': size == 'lg' }">
                <div v-if="size == 'lg'">
                    <p class="text-xs text-center text-white opacity-50 text-light">Favorite Club</p>
                    <div class="flex justify-center item-center">
                        <img :src="player.club?.logo_thumb" class="w-5 h-5 border-2 border-white rounded-full" />
                    </div>
                </div>
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
                    <p class="text-sm text-center text-white font-semi-bold">{{ player.position.name }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-2">
                <p class="flex items-center text-sm text-white" v-if="showLocation">
                    <MapPinIcon class="inline w-4 h-4 text-white" />
                    Cairo
                </p>
                <div class="flex gap-4 items-center">
                    <div class="flex space-x-2 text-white bg-transparent"
                        v-if="showInvite && player.id !== $page.props.auth.user.id">
                        <Link :href="route('invitation.create', player.id)" class="text-sm text-white">Send Invitation
                        <!-- <ChevronDoubleRightIcon class="inline w-4 h-4 text-white" /> -->
                        </Link>
                    </div>
                    <Socials :id="player.id" />

                </div>
            </div>


            <div class="flex justify-between items-center mt-6" v-if="showReport">
                <div></div>
                <ReportModal :reportable-id="player.id" :reportable-type="'App\\Models\\User'">
                    <template #trigger>
                        <button>
                            <FlagIcon class="h-4 w-4 text-red-500" />
                        </button>

                    </template>
                </ReportModal>

            </div>
        </div>
    </div>
</template>
