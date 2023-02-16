<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {
    CalendarDaysIcon,
    MapPinIcon,
} from '@heroicons/vue/24/outline';
import RespondToInvitationModal from '@/Components/RespondToInvitationModal.vue';

const props = defineProps({
    invitedInvitations: Array,
    invitingInvitations: Array,
});

const display = ref([]);
const type = ref('invitation');
const playerId = ref('inviting_player');

onMounted(() => {
    display.value = props.invitedInvitations;
});

const switchDisplay = (selected) => {
    type.value = selected;

    if (selected == 'invitation') {
        display.value = props.invitedInvitations;
        playerId.value = 'inviting_player';
    }

    if (selected == 'hire') {
        display.value = props.invitingInvitations;
        playerId.value = 'invited_player';
    }
};

const showInvitationNotificationModal = ref(false);
const selectedInvitation = ref(null);

const respondToInvitation = (invitation) => {
    selectedInvitation.value = invitation;
    showInvitationNotificationModal.value = true;
}
</script>

<template>
    <Head title="Invitations"/>

    <AppLayout title="Invitations">
        <template #header>
            <p class="text-4xl md:text-7xl font-black">Invitations</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end items-center space-x-8">
                    <div class="sm:w-1/3 flex space-x-4">
                        <SecondaryButton @click="switchDisplay('invitation')">
                            <span
                                :class="{'text-gray-500': type != 'invitation', 'text-black': type == 'invitation'}">
                                Invitation
                            </span>
                        </SecondaryButton>
                        <SecondaryButton @click="switchDisplay('hire')">
                            <span :class="{'text-gray-500': type != 'hire', 'text-black': type == 'hire'}">
                                Hire
                            </span>
                        </SecondaryButton>
                    </div>
                </div>

                <div class="bg-white rounded-xl mt-4 min-h-[500px] py-6">
                    <template v-for="invitation in display" :key="invitation.id">
                        <div class="p-2">
                            <CalendarDaysIcon class="h-4 w-4 text-black inline mr-1 text-xs"/>
                            {{ dayjs(invitation.date).format('d MMMM YYYY') }}
                        </div>
                        <div class="flex items-center">
                            <div class="h-3 w-5 bg-black rounded-full rounded-l text-xs">
                            </div>
                            <div class="inline ml-2 text-xs">
                                {{ dayjs(invitation.date).format('h:MM A') }}
                            </div>
                        </div>

                        <div class="max-w-sm p-6">
                            <div class="rounded-xl p-4"
                                 style="background: url('/images/player_bg_sm.png'); background-size: cover; background-position: center;">
                                <div class="flex justify-between items-start">
                                    <div class="flex justify-start space-x-2 mb-2">
                                        <img :src="invitation[playerId].avatar_url" :alt="invitation[playerId].name"
                                             class="h-14 w-14 rounded-full border-2 border-white">
                                        <div>
                                            <h2 class="text-sm text-white font-bold">
                                                {{ invitation[playerId].first_name }} {{ invitation[playerId].last_name }}
                                            </h2>

                                            <p class="text-xs text-white opacity-50">@{{ invitation[playerId].username }}</p>
                                            <p class="text-sm text-white flex items-center space-x-2">
                                                <ElRate v-model="invitation[playerId].rating" size="small"/>
                                                {{ invitation[playerId].rating }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <p class="text-xs text-white opacity-50 text-light text-center">Position</p>
                                        <p class="text-sm text-white text-center font-semi-bold">{{ invitation[playerId].position.name }}</p>
                                    </div>
                                </div>

                                <button v-if="invitation.state == 'accepted'" class="bg-white opacity-50 rounded-full w-full py-1 uppercase font-bold mt-5">
                                    Message
                                </button>

                                <button v-if="invitation.state == 'declined'" class="bg-rose-300 opacity-50 rounded-full w-full py-1 uppercase font-bold mt-5" :disabled="true">
                                    Declined
                                </button>

                                <button v-if="invitation.state == null" class="bg-green-300 opacity-50 rounded-full w-full py-1 uppercase font-bold mt-5" @click="respondToInvitation(invitation)">
                                    Respond
                                </button>

                                <div class="flex justify-between items-center mt-2  border-t border-white">
                                    <p class="text-white text-sm flex items-center">
                                        <MapPinIcon class="inline h-4 w-4 text-white"/>
                                        Cairo
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <transition enter-active-class="transform ease-out duration-300 transition"
                    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                    leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
            <div v-if="showInvitationNotificationModal">
                <RespondToInvitationModal :invitation="selectedInvitation" :show="showInvitationNotificationModal" @close="showInvitationNotificationModal = false"/>
            </div>
        </transition>

    </AppLayout>
</template>
