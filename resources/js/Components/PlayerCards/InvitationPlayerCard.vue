<script setup>
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import Avatar from '@/Components/Avatar.vue';
import dayjs from "dayjs";
import { GoogleMap, Marker } from "vue3-google-map";
import { CheckIcon, HandRaisedIcon, XMarkIcon } from '@heroicons/vue/24/solid';
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
const markerOptions = { position: position, label: props.invitation.stadium.name, title: props.invitation.stadium.name };



</script>

<template>
    <div class="rounded-xl"
        :style="`background: url('${backgroundImage}'); background-size: cover; background-position: center;`">
        <div class="flex flex-col items-center justify-center gap-1 p-4 ">

            <div class="flex flex-col items-center ">
                <!-- image -->
                <Avatar :image-url="player.avatar_url" :size="'lg'" :username="player.name" :border="true" />
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
                    <Link class="hover:underline" :href="route('player.profile', player.id)">@{{
                        player.username }}</Link>
                    <span>
                        <HandRaisedIcon class="w-4 text-yellow-300 rotate-[15deg]" />
                    </span>
                </div>
                <!-- invitation date -->
                <p class="text-xs text-center text-stone-300/70">Wants to invite you for a match in
                    <span>{{ dayjs(invitation.date).format('DD MMMM YYYY, h:m A') }}</span>
                </p>
            </div>
            <!-- invite user location -->
            <!-- invitation.stadium.address --->
            <!-- invitation.stadium.city   -->
            <!-- invitation.stadium.country -->
            <div>
                <GoogleMap :api-key="apiKey" style="width: 100%; height: 150px" :center="position" :zoom="15">
                    <Marker :options="markerOptions" />
                </GoogleMap>
            </div>
            <!-- respond to invitation state buttons -->
            <div class="self-stretch text-sm font-bold">
                <div v-if="invitation.state == null" class="flex justify-center gap-2">
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
                        class="flex items-center justify-center px-2 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                        <XMarkIcon class="w-6 text-red-600" />
                    </button>
                </div>
                <button v-if="invitation.state == 'accepted'"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                    Chat
                </button>
                <!-- todo:fix the condition to show rate when they invitation date end -->
                <button v-if="false"
                    class="flex items-center justify-center w-full px-4 py-2 rounded-full shadow-sm bg-stone-100 enabled:hover:bg-opacity-90 enabled:active:scale-95">
                    Rate
                </button>
            </div>


        </div>
    </div>
</template>