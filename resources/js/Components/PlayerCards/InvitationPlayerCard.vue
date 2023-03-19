<script setup>
import { computed, ref, onBeforeMount, onMounted } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import dayjs from "dayjs";
import { CustomMarker, GoogleMap, Marker } from "vue3-google-map";
import { CheckIcon, HandRaisedIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import relativeTime from 'dayjs/plugin/relativeTime';
import DateTranslation from '../DateTranslation.vue';
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
        default: 'sm'
    },
    invitation: {
        required: true,
        type: Object,
    },
});

const backgroundImage = computed(() => {
    return {
        'sm': '/images/player_bg_sm.png',
        'lg': '/images/player_bg_lg.png',
    }[props.size];
});

const currentUser = usePage().props.value.auth.user
const isCurrentUser = props.player.id === currentUser.id
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;


const accept = () => {
    const form = useForm({});
    form.patch(route('invitation.accept', props.invitation.id), {
        preserveState: false,
        onFinish: () => {
            emit('close');
        }
    });
};

const decline = () => {
    const form = useForm({});
    form.patch(route('invitation.decline', props.invitation.id), {
        preserveState: false,
        onFinish: () => {
            emit('close');
        }
    });
};

let position = {
    lat: parseFloat(props.invitation.stadium.latitude),
    lng: parseFloat(props.invitation.stadium.longitude),
}
const markerOptions = { position: position };

onMounted(() => {
    calcShouldRate();
});

const shouldRate = ref(false)
function calcShouldRate() {

    if (props.invitation?.reviews?.length) {
        shouldRate.value = true;
    }
    // if (props.invitation.updated_at && dayjs(props.invitation?.updated_at).diff(dayjs(), 'hour') > 2 && props.invitation.state == 'accepted') {
    //     shouldRate.value = true;

    // }
}
</script>

<template>
    <div class="rounded-xl"
        :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div class="flex flex-col items-center justify-center gap-3 p-4 ">

            <div class="flex flex-col items-center ">
                <!-- image -->
                <Avatar :id="player.id" :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" />
                <!-- rating -->
                <div class="flex items-center space-x-2 text-sm text-white">
                    <span class="scale-[0.5]  flex items-center gap-x-1">
                        <ElRate disabled v-model="player.rating" size="small" />
                        {{ player.rating }}
                    </span>
                </div>
            </div>
            <!-- name and userName -->
            <div class="flex flex-col items-center ">
                <div class="flex items-center gap-2 text-sm text-white ">
                    <h2 class="">
                        {{ player.first_name }} {{ player.last_name }}
                    </h2>
                    <Link class="hover:underline before:content-['a'] before:text-transparent" :href="route('player.profile', player.id)">@{{
                        player.username }}</Link>
                    <span>
                        <HandRaisedIcon class="w-4 text-yellow-300 rotate-[15deg]" />
                    </span>
                </div>
                <!-- invitation date -->
                <p class="text-xs text-center text-stone-300/70">{{$t('Wants to invite you for a match in')}}
                    <DateTranslation format="DD MMMM YYYY, h:m A" :start="invitation.date"/>
                </p>
            </div>
            <!-- invite user location -->

            <div class="w-full overflow-hidden rounded-lg ">
                <GoogleMap :api-key="apiKey" style="width: 100%; height: 150px" :center="position" :zoom="15">
                    <Marker :options="markerOptions" />
                    <CustomMarker :options="{ position: position, anchorPoint: 'TOP_RIGHT' }">
                        <div class="text-center rounded-md bg-white/90 ">
                            <div class="p-2 text-xs font-bold ">{{ invitation.stadium.name }}</div>
                        </div>
                    </CustomMarker>
                </GoogleMap>
            </div>


            <!-- respond to invitation state buttons -->
            <div class="self-stretch text-sm font-bold">
                <div v-if="invitation.state == null && invitation.inviting_player_id !== currentUser.id && dayjs(props.invitation?.date).diff(dayjs(), 'hour') > 0"
                    class="flex justify-center gap-6">
                    <button @click="decline"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <XMarkIcon class="w-6 text-red-600" />
                    </button>
                    <button @click="accept"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <CheckIcon class="w-6 text-green-600" />
                    </button>
                </div>
                <div v-if="invitation.state == 'declined'" class="flex justify-center">
                    <button :disabled="true"
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-200 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <XMarkIcon class="w-6 text-red-600" />
                    </button>
                </div>
                <Link :href="route('chats.index')" v-if="invitation.state == 'accepted' && !shouldRate"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                {{$t('chat')}}
                </Link>

                <Link :href="route('player.review.show', invitation.reviews[0].id)"
                    v-if="invitation.state == 'accepted' && shouldRate"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                {{$t('rate')}}
                </Link>
            </div>


        </div>
    </div>
</template>
