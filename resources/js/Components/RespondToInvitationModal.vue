<script setup>
import { defineEmits } from 'vue';
import { useForm } from "@inertiajs/inertia-vue3";
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ElRate } from 'element-plus';
import dayjs from 'dayjs';
import Avatar from '@/Components/Avatar.vue';
import {
    MapPinIcon,
} from '@heroicons/vue/24/outline';

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
    form.patch(route('invitation.accept', props.invitation.id), {}, {
        preserveState: true,
        onFinish: () => {
            emit('close');
        }
    });
};

const decline = () => {
    const form = useForm({});
    form.patch(route('invitation.decline', props.invitation.id), {}, {
        preserveState: true,
        onFinish: () => {
            emit('close');
        }
    });
};
</script>

<template>
    <Modal :show="show" max-width="sm" @close="$emit('close')">
        <div class="bg-white rounded-xl p-6 min-h-[300px]">
            <div class="flex flex-col justify-between items-center">
                <div class="flex justify-center my-4">
                    <div class="w-full">
                        <h2 class="text-xl text-primary font-bold uppercase text-center">Invitation</h2>
                        <p class="text-sm text-gray-700 font-light text-center mt-6">You have received an invitation.</p>
                    </div>
                </div>

                <div class="max-w-sm p-6">
                    <div class="rounded-xl p-4"
                         style="background: url('/images/player_bg_sm.png'); background-size: cover; background-position: center;">
                        <div class="flex justify-start mb-4">
                            <p class="text-white text-xs font-bold uppercase">{{ dayjs(invitation.date).format('d MMMM YYYY, h:m P') }}</p>
                        </div>

                        <div class="flex justify-between items-start">
                            <div class="flex justify-start space-x-2 mb-2">
                                <Avatar :image-url="invitation.inviting_player.avatar_url" size="md" :username="invitation.inviting_player.name" :border="true"/>
                                <div>
                                    <h2 class="text-sm text-white font-bold">
                                        {{ invitation.inviting_player.first_name }} {{ invitation.inviting_player.last_name }}
                                    </h2>

                                    <p class="text-xs text-white opacity-50">@{{ invitation.inviting_player.username }}</p>
                                    <p class="text-sm text-white flex items-center space-x-2">
                                        <ElRate v-model="invitation.inviting_player.rating" size="small"/>
                                        {{ invitation.inviting_player.rating }}
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <p class="text-xs text-white opacity-50 text-light text-center">Position</p>
                                <p class="text-sm text-white text-center font-semi-bold">{{ invitation.inviting_player.position.name }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-8 mb-4 border-t border-white">
                            <div>
                                <p class="text-white text-sm flex items-center capitalize">
                                    <MapPinIcon class="inline h-4 w-4 text-white"/>
                                    {{ invitation.stadium.name }}
                                </p>
                                <p class="text-white text-xs font-extralight">
                                    {{ invitation.stadium.address }}, {{ invitation.stadium.city }}, {{ invitation.stadium.country }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-4 w-full">
                    <PrimaryButton @click="accept">Accept</PrimaryButton>
                    <PrimaryButton @click="decline">Decline</PrimaryButton>
                </div>
            </div>
        </div>
    </Modal>
</template>
