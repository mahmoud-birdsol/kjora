<script setup>
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import { HeartIcon, PencilIcon, StarIcon as StarIconFilled, ChevronDoubleRightIcon } from '@heroicons/vue/20/solid'
import { FlagIcon, HeartIcon as HeartIconOutline, MapPinIcon, StarIcon as StarIconOutline } from '@heroicons/vue/24/outline';
import ReportModal from "@/Components/ReportModal.vue";
import Socials from '@/Components/Socials.vue';
import ToolTip from "@/Components/ToolTip.vue";
import FavouriteButton from '../FavouriteButton.vue';

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
    }, showFavorite: {
        required: false,
        type: Boolean,
        default: true
    }, showShare: {
        required: false,
        type: Boolean,
        default: true
    }, showDistance: {
        required: false,
        type: Boolean,
        default: true
    },

});

const currentUser = usePage().props.value.auth.user
const state = props.player.state_name
const txtColor = state == 'Free' ? 'white' : 'black'
const colors = ref(['#99A9BF', state == "Free" ? '#FF9900' : 'rgb(0, 100, 0)', state == "Free" ? '#FF9900' : 'rgb(0, 100, 0)'])
const copiedMsg = ref(false)
const backgroundImage = computed(() => {
    if (state == 'Premium') {
        return {
            'sm': '/images/player_bg_sm_gold.png',
            'lg': '/images/player_bg_lg_gold.png',
        }[props.size];
    } else if (state == 'Free') {
        return {
            'sm': '/images/player_bg_sm.png',
            'lg': '/images/player_bg_lg.png',
        }[props.size];
    }
});

const isCurrentUser = props.player.id === currentUser?.id
const isPublic = usePage().url.value.includes('public/player')








function calculateDistance(lat1Str, lng1Str, lat2Str, lng2Str) {
    let lat1 = parseFloat(lat1Str);
    let lng1 = parseFloat(lng1Str);
    let lat2 = parseFloat(lat2Str);
    let lng2 = parseFloat(lng2Str);
    const radius = 6371; // Earth’s radius in km
    const dLat = toRadians(lat2 - lat1);
    const dLng = toRadians(lng2 - lng1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = radius * c;
    return distance.toFixed(1);
}
function toRadians(degree) {
    return degree * (Math.PI / 180);
}

const distanceBetweenPlayerAndMe = calculateDistance(currentUser.current_latitude, currentUser.current_longitude, props.player.current_latitude, props.player.current_longitude)
function showCopied() {
    copiedMsg.value = true
    setTimeout(() => {
        copiedMsg.value = false
    }, 2000)
}

</script>

<template>
    <!-- favorite icon -->
    <div class="overflow-hidden rounded-xl" :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div v-if="showFavorite && !isCurrentUser" class="flex justify-end">
            <span class="rounded-lg ltr:rounded-bl-3xl rtl:rounded-br-3xl bg-white p-2 -mt-0.5 ltr:-mr-0.5 rtl:-ml-0.5">
                <FavouriteButton :user="player" />
            </span>
        </div>
        <div v-if="showFavorite && isCurrentUser" class="h-[34px]"></div>


        <div class="px-4 py-1">
            <div class="flex items-start justify-between">
                <div class="flex items-center justify-start gap-2 mb-2" :class="{ 'space-x-2': size == 'sm', 'space-x-8': size == 'lg' }">
                    <div class="relative">
                        <Link :href="route('profile.edit')" v-if="isCurrentUser && !isPublic" class="absolute bottom-0 p-1 bg-white rounded-full ltr:right-0 rtl:left-0 hover:text-primary">
                        <PencilIcon class="w-3 [&+div]:hover:block " />
                        <ToolTip :value="$t('edit-your-profile')" right="right-0" />
                        </Link>
                        <Avatar :id="player.id" :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" :borderColor="state == 'Free' ? 'primary' : 'blackDark'" />
                    </div>

                    <div :class="state == 'Free' ? 'text-white' : 'text-primary'">
                        <Link :href="route('player.profile', player.id)">
                        <h2 class="text-sm font-bold capitalize">
                            {{ player.first_name }} {{ player.last_name }}
                        </h2>
                        </Link>

                        <Link class="text-xs opacity-50" :href="route('player.profile', player.id)">@{{
                            player.username
                        }}
                        </Link>
                        <p class="flex items-center space-x-2 text-sm ">
                            <span class="scale-[0.7] ltr:origin-left rtl:origin-right  flex items-center gap-x-1" :class="txtColor == 'black' ? 'text-primary' : 'text-[#FF9900]'">
                                <!--                                <ElRate disabled v-model="player.rating" size="small" :colors="colors"/>-->
                                <!--                                {{ player.rating }}-->

                                <!--                                <el-rate-->
                                <!--                                    v-model="player.rating"-->
                                <!--                                    show-score-->
                                <!--                                    size="small"-->
                                <!--                                    text-color="#ff9900"-->
                                <!--                                    score-template="{value}"/>-->
                                <span class="flex items-center gap-1">
                                    <template v-for="i in 5">
                                        <StarIconFilled class="w-5 h-5" v-if="player.rating >= i" :class="state == 'Free' ? 'text-gold' : 'text-primary'" />
                                        <StarIconOutline class="w-5 h-5" :class="state == 'Free' ? 'text-gold' : 'text-primary'" v-else />
                                    </template>
                                </span>

                                <span class="ml-2 font-bold text-md" :class="state == 'Free' ? 'text-gold' : 'text-primary'">{{ player.rating }}</span>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-1">
                    <p :class="state == 'Free' ? 'text-white' : 'text-primary'" class="text-sm font-bold ">
                        {{ player.preferred_foot === 'right' ? 'R' : 'L' }}</p>
                </div>
            </div>

            <div class="grid gap-1 border-b sm:gap-4" :class="{ 'grid-cols-4 pb-2 ': size == 'sm', 'grid-cols-5 pb-4 mt-4': size == 'lg' }, `border-${txtColor}`, `text-${txtColor}`">
                <div v-if="size == 'lg'" class="relative">

                    <p class="text-xs text-center whitespace-nowrap" :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">
                        {{ $t('favorite-club') }}</p>
                    <div class="flex justify-center item-center [&+div]:hover:block rounded-full overflow-hidden w-fit p-1 bg-white mx-auto">
                        <img :src="player.club?.logo_thumb" class="w-5 h-5 " />
                    </div>
                    <ToolTip :value="player.club?.name" />
                </div>
                <div>

                    <p class="text-xs text-center" :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{
                        $t('age')
                    }}</p>
                    <p class="text-sm text-center font-semi-bold">{{ player.age }}</p>
                </div>
                <div>
                    <p class="text-xs text-center " :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{
                        $t('played')
                    }}</p>
                    <p class="text-sm text-center font-semi-bold"> {{ player.played }}</p>
                </div>
                <div>
                    <p class="text-xs text-center" :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{
                        $t('missed')
                    }}</p>
                    <p class="text-sm text-center font-semi-bold"> {{ player.missed }} </p>
                </div>
                <div>
                    <p class="text-xs text-center" :class="state == 'Free' ? 'text-white text-light opacity-50' : 'text-primary'">{{
                        $t('position')
                    }}</p>
                    <p class="text-xs text-center font-semi-bold">{{ $t(player.position.name) }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between gap-1 mt-2 sm:text-xs" :class="`text-${txtColor}`">
                <div class="flex items-center gap-1">

                    <a :href="`https://www.google.com/maps/dir/Current+Location/${player.current_latitude},${player.current_longitude}`" target="_blank" class="w-full overflow-hidden rounded-lg ">
                        <p class="flex gap-1 items-center text-sm scale-[0.85] ltr:origin-left rtl:origin-right" v-if="showLocation">
                            <MapPinIcon class="inline w-4 h-4" />
                            {{ player.current_city && player.current_city?.split(' ')[0] }}
                        </p>
                    </a>


                </div>
                <div class="flex items-center gap-4">
                    <div class="flex space-x-2 bg-transparent" v-if="showInvite && player.id !== $page.props.auth.user.id">
                        <Link :href="route('invitation.create', player.id)" class="text-sm scale-[0.85]  ltr:origin-left rtl:origin-right">
                        {{ $t('send-invitation') }}
                        <ChevronDoubleRightIcon class="inline w-4 h-4 rtl:rotate-180 ltr:rotate-0" :class="`text-${txtColor}`" />
                        </Link>
                    </div>
                    <div class="relative">
                        <Socials v-if="showShare" :shareUrl="`public/player/${player.username}`" position="bottom-0" @showCopied="showCopied" />
                        <span class="bg-black text-white text-[10px] font-bold rounded absolute ltr:right-0 rtl:left-0 -bottom-3 -my-4 p-1 whitespace-nowrap" v-if="copiedMsg">{{
                            $t('the link has been copied') }}!</span>
                    </div>
                </div>
            </div>
            <div class="pis-4 sm:text-xs" :class="`text-${txtColor}`">
                <div v-if="!isCurrentUser && showDistance" class="text-xs scale-[0.85] ltr:origin-left rtl:origin-right">
                    <span>{{ distanceBetweenPlayerAndMe }}</span><span>{{ $t('Km') }}</span>
                </div>
                <div v-else class="h-[16px]"></div>
            </div>

            <div v-if="showReport && isCurrentUser" class="h-[43.2px]"></div>
            <div class="flex justify-end" v-if="showReport && !isCurrentUser">
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


<style ></style>