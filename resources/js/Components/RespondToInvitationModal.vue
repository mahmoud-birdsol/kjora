<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from "@inertiajs/vue3";
import InvitationPlayerCard from "./PlayerCards/InvitationPlayerCard.vue";

const props = defineProps({
    invitation: {
        required: true,
        type: Object,
    },
    show: {
        required: true,
        type: Boolean,
    }
});

const emit = defineEmits(['close']);


</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <div class="rounded-xl bg-white min-h-[300px]">
            <div class="flex flex-col items-center justify-between px-6 pb-6">
                <div class="w-full">
                    <h2 class="text-xl font-bold text-center uppercase text-primary">{{ $t('invitation') }}</h2>
                    <p class="mt-6 text-sm font-light text-gray-700">
                        {{ $t('you-have-received-an-invitation-from- :name ,-to-play-a-game-on', { name: invitation.inviting_player.name }) }}
                        <strong>
                            <DateTranslation format="DD MMMM YYYY, h:m A" :start="invitation.date" />
                        </strong><span> {{ $t('at') }} </span>
                        <strong>{{ invitation.stadium.address }}, {{ invitation.stadium.city }}, {{ invitation.stadium.country }},({{ invitation.stadium.name
                        }})</strong>
                    </p>
                </div>
                <div class="mt-4">
                    <InvitationPlayerCard :player="invitation.inviting_player" :invitation="invitation" />
                </div>

            </div>
        </div>
    </Modal>
</template>
