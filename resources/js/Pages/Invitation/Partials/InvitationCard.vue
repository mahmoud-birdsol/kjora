<script setup>
import { ref } from 'vue';
import MainPlayerCard from "@/Components/PlayerCards/MainPlayerCard.vue";
import dayjs from "dayjs";
import { CalendarIcon, MapPinIcon } from "@heroicons/vue/20/solid";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RespondToInvitationModal from "@/Components/RespondToInvitationModal.vue";

const props = defineProps({
    invitation: {
        required: true,
        type: Object,
    }
});

const showInvitationNotificationModal = ref(false);
</script>

<template>
    <div class="rounded-lg bg-gray-100 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <div class="max-w-sm">
                    <MainPlayerCard :player="invitation.inviting_player" :show-report="true" :show-invite="false"
                        :show-location="true" />
                </div>
            </div>
            <div class="flex flex-col justify-between items-start">
                <div>
                    <h2 class="font-bold text-gray-900">
                        <CalendarIcon class="inline h-6 w-6" />
                        {{ dayjs(invitation.date).format('DD MMMM YYYY, h:m A') }}
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
                    Message
                </button>

                <button v-if="invitation.state == 'declined'" :disabled="true"
                    class="w-full flex justify-center items-center px-4 py-2 bg-stone-300  border border-transparent rounded-full font-bold text-xs text-red-500 hover:cursor-not-allowed text-center uppercase tracking-widest focus:outline-none focus:ring transition">
                    Declined
                </button>

                <PrimaryButton v-if="invitation.state == null" @click="showInvitationNotificationModal = true">Respond
                </PrimaryButton>
            </div>
        </div>
    </div>

    <transition enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="showInvitationNotificationModal">
            <RespondToInvitationModal :invitation="invitation" :show="showInvitationNotificationModal"
                @close="showInvitationNotificationModal = false" />
        </div>
    </transition>
</template>
