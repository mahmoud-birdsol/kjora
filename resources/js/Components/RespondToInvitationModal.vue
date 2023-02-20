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
import {Inertia} from "@inertiajs/inertia";

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
                    <h2 class="text-center text-xl font-bold uppercase text-primary">Invitation</h2>
                    <p class="mt-6 text-sm font-light text-gray-700">
                        You have received an invitation from {{ invitation.inviting_player.name }}, to play a game on
                        <strong>{{ dayjs(invitation.date).format('DD MMMM YYYY, h:m A') }}</strong> at
                        <strong>{{ invitation.stadium.address }}, {{ invitation.stadium.city }}, {{ invitation.stadium.country }}</strong>
                    </p>
                </div>

                <div class="max-w-sm my-6">
                    <MainPlayerCard :player="invitation.inviting_player" :show-invite="false" :show-location="false" :show-report="false"/>
                </div>

                <div class="flex w-full flex-col space-y-4">
                    <PrimaryButton @click="accept">Accept</PrimaryButton>
                    <PrimaryButton @click="decline">Decline</PrimaryButton>
                </div>
            </div>
        </div>
    </Modal>
</template>
