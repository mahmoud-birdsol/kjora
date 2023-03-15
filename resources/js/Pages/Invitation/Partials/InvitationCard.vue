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
    },
});


</script>

<template>
    <div class="p-2 md:p-8 bg-gray-100 rounded-2xl">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="max-w-sm">
                    <InvitationPlayerCard :player="invitation.inviting_player" :invitation="invitation" />
                </div>
            </div>

        </div>
    </div>
</template>
