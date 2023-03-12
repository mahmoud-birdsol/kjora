<script setup>
import { ref } from 'vue';
import MainPlayerCard from "@/Components/PlayerCards/MainPlayerCard.vue";
import dayjs from "dayjs";
import { CalendarIcon, MapPinIcon } from "@heroicons/vue/20/solid";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RespondToInvitationModal from "@/Components/RespondToInvitationModal.vue";
import DateTranslation from '@/Components/DateTranslation.vue';import InvitationPlayerCard from '../../../Components/PlayerCards/InvitationPlayerCard.vue';

const props = defineProps({
    invitation: {
        required: true,
        type: Object,
    }
});


</script>

<template>
    <div class="p-6 px-8 bg-gray-100 rounded-2xl">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="max-w-sm">
                    <InvitationPlayerCard :player="invitation.inviting_player" :invitation="invitation" />
                </div>
            </div>
            <div class="flex flex-col justify-between items-start">
                <div>
                    <h2 class="font-bold text-gray-900">
                        <CalendarIcon class="inline h-6 w-6" />
                        <DateTranslation :start="invitation.date" format="DD MMMM YYYY, h:m A" />
                    </h2>
                    <p class="text-gray-500 text-sm mt-2">
                        <MapPinIcon class="inline h-4 w-4" />
                        {{ invitation.stadium.address }}, {{ invitation.stadium.city }}, {{
                            invitation.stadium.country
                        }}
                    </p>
                </div>

                <button v-if="invitation.state == 'accepted'"
                    class="w-full flex justify-center items-center px-4 py-2 bg-black  border border-transparent rounded-full font-bold text-xs text-green-500 text-center uppercase tracking-widest hover:bg-primaryDark active:bg-primaryDark focus:outline-none hover:text-white focus:border-primaryDark focus:ring-1 focus:ring-primary transition">
                    {{$t('message')}}
                </button>

                <button v-if="invitation.state == 'declined'" :disabled="true"
                    class="w-full flex justify-center items-center px-4 py-2 bg-stone-300  border border-transparent rounded-full font-bold text-xs text-red-500 hover:cursor-not-allowed text-center uppercase tracking-widest focus:outline-none focus:ring transition">
                    {{$t('declined')}}
                </button>

                <PrimaryButton v-if="invitation.state == null" @click="showInvitationNotificationModal = true">{{$t('respond')}}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
