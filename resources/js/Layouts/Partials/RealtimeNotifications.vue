<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleNotification from '@/Components/Notifications/SimpleNotification.vue';
import RespondToInvitationModal from '@/Components/RespondToInvitationModal.vue';

const showNotificationPopup = ref(false);
const broadcastNotification = ref(null);

const showInvitationNotificationModal = ref(false);
const invitation = ref(null);

Echo.private('users.' + usePage().props.value.auth.user.id)
    .listen('.invitation.created', (event) => {
        invitation.value = event.invitation;
        showInvitationNotificationModal.value = true;
    })
    .notification((notification) => {
        broadcastNotification.value = notification;
        showNotificationPopup.value = true;

        Inertia.reload({
            only: ['notifications'],
        });
    });
</script>

<template>
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <transition enter-active-class="transform ease-out duration-300 transition"
                        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                        leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                <template v-if="showNotificationPopup && broadcastNotification.displayType == 'simple'">

                        <SimpleNotification :notification="broadcastNotification"
                                            @close="showNotificationPopup = false"/>
                </template>
            </transition>
        </div>
    </div>

    <transition enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
        <div v-if="showInvitationNotificationModal">
            <RespondToInvitationModal :invitation="invitation" :show="showInvitationNotificationModal" @close="showInvitationNotificationModal = false"/>
        </div>
    </transition>
</template>
