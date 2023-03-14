<script setup>
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import { HeartIcon, PencilIcon } from '@heroicons/vue/20/solid'
import { FlagIcon, HeartIcon as HeartIconOutline, MapPinIcon } from '@heroicons/vue/24/outline';
import ReportModal from "@/Components/ReportModal.vue";
import Socials from '@/Components/Socials.vue';
import ToolTip from "@/Components/ToolTip.vue";

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

const currentUser = usePage().props.value.auth.user
const state = props.player.state_name
const txtColor = state == 'Free' ? 'white' : 'black'
const colors = ref(['#99A9BF', state == "Free" ? '#FF9900' : 'rgb(0, 100, 0)', state == "Free" ? '#FF9900' : 'rgb(0, 100, 0)'])
const backgroundImage = computed(() => {
    if (state == 'Premium') {
        return {
            'sm': '/images/player_bg_sm_gold.png',
            'lg': '/images/player_bg_lg_gold.png',
        }[props.size];
    }
    else if (state == 'Free') {
        return {
            'sm': '/images/player_bg_sm.png',
            'lg': '/images/player_bg_lg.png',
        }[props.size];
    }
});

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
            <span class="rounded-lg ltr:rounded-bl-3xl rtl:rounded-br-3xl bg-white p-2 -mt-0.5 ltr:-mr-0.5 rtl:-ml-0.5">
                <a href="javascript:;" @click="addToFavorites" v-if="!player.is_favorite">
                    <HeartIconOutline class="w-5 h-5 text-primary" />
                </a>
                <a href="javascript:;" @click="removeFromFavorites" v-if="player.is_favorite">
                    <HeartIcon class="w-5 h-5 text-primary" />
                </a>
            </span>
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between">
                <div class="flex justify-start gap-2 items-center mb-2" :class="{ 'space-x-2': size == 'sm', 'space-x-8': size == 'lg' }">
                    <div class="relative">
                        <Link :href="route('profile.edit')" v-if="isCurrentUser"
                            class="absolute bottom-0 ltr:right-0 rtl:left-0 p-1 bg-white rounded-full hover:text-primary">
                        <PencilIcon class="w-3 [&+div]:hover:block " />
                        <ToolTip :value="$t('edit-your-profile')"/>
                        </Link>
                        <Avatar :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" />
                    </div>

                    <div :class="state == 'Free' ? 'text-white' : 'text-primary'"
                    >
                        <Link :href="route('player.profile', player.id)">
                        <h2 class="text-sm font-bold">
                            {{ player.first_name }} {{ player.last_name }}
                        </h2>
                        </Link>

                        <Link class="text-xs opacity-50" :href="route('player.profile', player.id)">@{{
                            player.username
                        }}
                        </Link>
                        <p class="flex items-center space-x-2 text-sm ">
                            <span class="scale-[0.7] origin-left flex items-center gap-x-1"
                                :class="txtColor == 'black' ? 'text-primary' : 'text-[#FF9900]'">
                                <ElRate disabled v-model="player.rating" size="small" :colors="colors" />
                                {{ player.rating }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <p  :class="state == 'Free' ? 'text-white' : 'text-primary'" class="text-sm font-bold ">{{ player.preferred_foot === 'right' ? 'R' : 'L' }}</p>
                </div>
            </div>

            <div class="grid gap-4 border-b"
                :class="{ 'grid-cols-4 pb-2 ': size == 'sm', 'grid-cols-5 pb-4 mt-4': size == 'lg' }, `border-${txtColor}`, `text-${txtColor}`">
                <div v-if="size == 'lg'" class="relative">

                    <p class="text-xs text-center"
                        :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{ $t('favorite-club') }}</p>
                    <div class="flex justify-center item-center [&+div]:hover:block">
                        <img :src="player.club?.logo_thumb" class="w-5 h-5 border-2 border-white rounded-full" />
                    </div>
                    <ToolTip :value="player.club?.name" />
                </div>
                <div>

                    <p class="text-xs text-center"
                        :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{ $t('age') }}</p>
                    <p class="text-sm text-center font-semi-bold">{{ player.age }}</p>
                </div>
                <div>
                    <p class="text-xs text-center "
                        :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{ $t('played') }}</p>
                    <p class="text-sm text-center font-semi-bold">0</p>
                </div>
                <div>
                    <p class="text-xs text-center"
                        :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{ $t('missed') }}</p>
                    <p class="text-sm text-center font-semi-bold">0</p>
                </div>
                <div>
                    <p class="text-xs text-center"
                        :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{ $t('position') }}</p>
                    <p class="text-sm text-center font-semi-bold">{{ player.position.name }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-2" :class="`text-${txtColor}`">
                <p class="flex items-center text-sm" v-if="showLocation">
                    <MapPinIcon class="inline w-4 h-4" />
                    {{ player.current_city }}
                </p>

                <div class="flex items-center gap-4">
                    <div class="flex space-x-2 bg-transparent" v-if="showInvite && player.id !== $page.props.auth.user.id">
                        <Link :href="route('invitation.create', player.id)" class="text-sm">{{$t('send-invitation')}}
                        <!-- <ChevronDoubleRightIcon class="inline w-4 h-4 text-white" /> -->
                        </Link>
                    </div>
                    <Socials :id="player.id" />

                </div>
            </div>


            <div class="flex items-center justify-between mt-6" v-if="showReport">
                <div></div>
                <ReportModal :reportable-id="player.id" :reportable-type="'App\\Models\\User'">
                    <template #trigger>
                        <button>
                            <FlagIcon class="w-4 h-4 text-red-500" />
                        </button>

                    </template>
                </ReportModal>

            </div>
        </div>
    </div>
</template>
