<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import Avatar from '@/Components/Avatar.vue';
import {
    MapPinIcon,
} from '@heroicons/vue/24/outline';
import MainPlayerCard from "./PlayerCards/MainPlayerCard.vue";
import { Inertia } from "@inertiajs/inertia";
import DateTranslation from '@/Components/DateTranslation.vue';
import { CheckIcon, XMarkIcon } from "@heroicons/vue/24/solid";
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
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <div class="rounded-xl bg-white min-h-[300px]">
            <div class="flex flex-col items-center justify-between px-6 pb-6">
                <div class="w-full">
                    <h2 class="text-center text-xl font-bold uppercase text-primary">{{ $t('invitation') }}</h2>
                    <p class="mt-6 text-sm font-light text-gray-700">
                        {{ $t('you-have-received-an-invitation-from- :name ,-to-play-a-game-on', { name: invitation.inviting_player.name }) }}
                        <strong>
                            <DateTranslation format="DD MMMM YYYY, h:m A" :start="invitation.date" />
                        </strong><span> {{ $t('at') }} </span>
                        <strong>{{ invitation.stadium.address }}, {{ invitation.stadium.city }}, {{ invitation.stadium.country }},({{ invitation.stadium.name }})</strong>
                    </p>
                </div>
                <div class="mt-4">
                    <InvitationPlayerCard :player="invitation.inviting_player" :invitation="invitation" />
                </div>

            </div>
        </div>
    </Modal>
</template>
