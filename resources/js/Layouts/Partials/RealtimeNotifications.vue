<script setup>
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import SimpleNotification from "@/Components/Notifications/SimpleNotification.vue";
import RespondToInvitationModal from "@/Components/RespondToInvitationModal.vue";
import UserNotification from "@/Components/Notifications/UserNotification.vue";

const showNotificationPopup = ref(false);
const broadcastNotification = ref(null);

const showInvitationNotificationModal = ref(false);
const invitation = ref(null);

Echo.private("users." + usePage().props.auth.user.id)
    .listen(".invitation.created", (event) => {
        axios
            .get(route("api.invitations.index", event.id))
            .then((res) => {
                invitation.value = res.data.data;
                showInvitationNotificationModal.value = true;
            })
            .catch((err) => console.error(err));
    })
    .notification((notification) => {
        broadcastNotification.value = notification;
        showNotificationPopup.value = true;

        router.reload({
            only: ["notifications"],
        });
        setTimeout(() => {
            showNotificationPopup.value = false;
        }, 10000);
    });
</script>

<template>
    <div
        aria-live="assertive"
        class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:items-start sm:p-6"
    >
        <div class="flex flex-col items-center w-full space-y-4 sm:items-end">
            <transition
                enter-active-class="transition duration-300 ease-out transform"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <template
                    v-if="
                        showNotificationPopup &&
                        broadcastNotification.displayType == 'simple'
                    "
                >
                    <SimpleNotification
                        :notification="broadcastNotification"
                        @close="showNotificationPopup = false"
                    />
                </template>
            </transition>

            <transition
                enter-active-class="transition duration-300 ease-out transform"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <template
                    v-if="
                        showNotificationPopup &&
                        broadcastNotification.displayType == 'user'
                    "
                >
                    <UserNotification
                        :notification="broadcastNotification"
                        @close="showNotificationPopup = false"
                    />
                </template>
            </transition>
        </div>
    </div>

    <transition
        enter-active-class="transition duration-300 ease-out transform"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition duration-100 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showInvitationNotificationModal">
            <RespondToInvitationModal
                :invitation="invitation"
                :show="showInvitationNotificationModal"
                @close="showInvitationNotificationModal = false"
            />
        </div>
    </transition>
</template>
