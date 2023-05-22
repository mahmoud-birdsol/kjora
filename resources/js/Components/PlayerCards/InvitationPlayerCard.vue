<script setup>
import { computed, ref, onBeforeMount, onMounted } from "vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { ElRate } from "element-plus";
import Avatar from "@/Components/Avatar.vue";
import dayjs from "dayjs";
import { CustomMarker, GoogleMap, Marker } from "vue3-google-map";
import {
    CheckIcon,
    HandRaisedIcon,
    XMarkIcon,
    StarIcon as StarIconFilled,
} from "@heroicons/vue/24/solid";
import { StarIcon as StarIconOutline } from "@heroicons/vue/24/outline";
import relativeTime from "dayjs/plugin/relativeTime";
import DateTranslation from "../DateTranslation.vue";
onBeforeMount(() => {
    dayjs.extend(relativeTime);
});
const props = defineProps({
    player: {
        required: true,
        type: Object,
    },
    size: {
        required: false,
        type: String,
        default: "sm",
    },
    invitation: {
        required: true,
        type: Object,
    },
});

const backgroundImage = computed(() => {
    return {
        sm: "/images/player_bg_sm.png",
        lg: "/images/player_bg_lg.png",
    }[props.size];
});

const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const currentUser = usePage().props.value.auth.user;
const state = props.player.state_name;
const txtColor = props.invitation.state == "Free" ? "white" : "black";
//invitation states
const isHiring = props.invitation.inviting_player.id === currentUser.id;
const isPending = props.invitation.state === null && dayjs(props.invitation?.date).diff(dayjs(), 'hour') > 0
const isAccepted = props.invitation.state === 'accepted'
const isDecline = props.invitation.state === 'declined'
const isCancelled = props.invitation.state === 'cancelled' || (dayjs(props.invitation?.date).diff(dayjs(), 'hour') <= 0 && props.invitation.state === null)
const isCanCancel = isPending && isHiring
const isShouldRate = computed(() => props.invitation?.reviews?.length ? true : false)

const accept = () => {
    const form = useForm({});
    form.patch(route("invitation.accept", props.invitation.id), {
        preserveState: false,

    });
};


const decline = () => {
    const form = useForm({});
    form.patch(route("invitation.decline", props.invitation.id), {
        preserveState: false,
    });
};

const cancel = () => {
    const form = useForm({});
    form.patch(route("invitation.cancel", props.invitation.id), {
        preserveState: false,
        onFinish: () => { },
    });
};


// map options
let position = {
    lat: parseFloat(props.invitation.stadium.latitude),
    lng: parseFloat(props.invitation.stadium.longitude),
};
const markerOptions = { position: position };



</script>

<template>
    <div class="rounded-xl" :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div class="flex flex-col items-center justify-center gap-3 p-4">
            <div class="flex flex-col items-center">
                <!-- image -->
                <Avatar :id="player.id" :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" />
                <div class="flex flex-col items-center text-sm text-white">
                    <Link class="hover:underline rtl:before:text-transparent rtl:before:content-['a']" :href="route('player.profile', player.id)">@{{
                        player.username }}</Link>
                </div>
                <!-- rating -->
                <p class="flex items-center justify-center space-x-2 text-sm">
                    <span class="flex scale-[0.7] items-center gap-x-1" :class="txtColor == 'black'
                        ? 'text-primary'
                        : 'text-[#FF9900]'
                    ">
                        <span class="flex items-center gap-1">
                            <template v-for="i in 5">
                                <StarIconFilled class="w-5 h-5" v-if="player.rating >= i" :class="props.invitation.state == 'Free'
                                    ? 'text-gold'
                                    : 'text-primary'
                                " />
                                <StarIconOutline class="w-5 h-5" :class="props.invitation.state == 'Free'
                                    ? 'text-gold'
                                    : 'text-primary'
                                " v-else />
                            </template>
                        </span>

                        <span class="ml-2 font-bold text-md" :class="props.invitation.state == 'Free' ? 'text-gold' : 'text-primary'
                        ">{{ player.rating }}</span>
                    </span>
                </p>
            </div>
            <!-- name and userName -->
            <div class="flex flex-col items-center">
                <!-- when receive invitation -->
                <div class="flex items-center gap-1 text-white capitalize" v-if="isPending && !isHiring">
                    <span>
                        {{
                            $t("hi :receiver , :sender", {
                                sender: invitation.inviting_player.name,
                                receiver: invitation.invited_player.first_name,
                            })
                        }}
                    </span>
                    <span>
                        <HandRaisedIcon class="w-4 rotate-[15deg] text-yellow-300" />
                    </span>
                </div>
                <!-- hiring  -->
                <div v-if="isHiring" class="flex items-center gap-1 text-white capitalize">
                    <p class="text-center text-[10px] text-stone-300/70">
                        <span v-if="isPending">
                            {{ $t("pending") }}
                        </span>
                        <span v-if="isAccepted">
                            {{ $t("accepted") }}
                        </span>
                        <span v-if="isDecline">
                            {{ $t("declined") }}
                        </span>
                        <span v-if="isCancelled">
                            {{ $t("canceled") }}
                        </span>
                        {{ $t("match in") }}
                        <DateTranslation format="DD MMMM YYYY, hh:mm A" :start="invitation.date" />
                    </p>
                </div>
                <!-- not hiring -->
                <template v-if="!isHiring">
                    <p class="text-center text-[10px] text-stone-300/70">
                        <span v-if="invitation.state === 'declined'">{{ $t("declined") }}</span>
                        <span v-if="isCancelled"> {{ $t("canceled") }}</span>
                        <span v-if="isPending"> {{ $t("Wants to invite you for") }}</span>
                        {{ $t("match in") }}
                        <DateTranslation format="DD MMMM YYYY, hh:mm A" :start="invitation.date" />
                    </p>
                </template>
            </div>
            <!-- invite user location -->

            <a :href="`https://www.google.com/maps/dir/Current+Location/${position.lat},${position.lng}`" target="_blank" class="w-full overflow-hidden rounded-lg">
                <GoogleMap :api-key="apiKey" style="width: 100%; height: 150px" :center="position" :zoom="15">
                    <Marker :options="markerOptions" />
                    <CustomMarker :options="{
                        position: position,
                        anchorPoint: 'TOP_RIGHT',
                    }">
                        <div class="text-center rounded-md bg-white/90">
                            <div class="p-2 text-xs font-bold">
                                {{ invitation.stadium.name }}
                            </div>
                        </div>
                    </CustomMarker>
                </GoogleMap>
            </a>

            <!-- respond to invitation state buttons -->
            <div class="self-stretch text-sm font-bold">
                <!-- pending and not hiring == invited player  -->
                <div v-if="isPending &&
                    !isHiring

                " class="flex justify-center gap-6">
                    <button @click="decline"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <XMarkIcon class="w-6 text-red-600" />
                    </button>
                    <button @click="accept"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <CheckIcon class="w-6 text-green-600" />
                    </button>
                </div>
                <!-- pending and hiring -->
                <!-- cancel invitation -->
                <div v-if="isCanCancel">
                    <button @click="cancel"
                        class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        {{ $t("cancel") }}
                    </button>
                </div>
                <!-- declined -->
                <div v-if="isDecline" class="flex justify-center">
                    <button :disabled="true"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-200 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <XMarkIcon class="w-6 text-red-600" />
                    </button>
                </div>
                <!-- accepted -->
                <Link :href="route('chats.index')" v-if="isAccepted && !isShouldRate"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                {{ $t("chat") }}
                </Link>
                <!-- Rate -->
                <Link :href="route('player.review.show', invitation.reviews[0].id)
                " v-if="isAccepted && isShouldRate"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                {{ $t("rate") }}
                </Link>
            </div>
        </div>
    </div>
</template>
