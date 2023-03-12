<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HireCard from "@/Pages/Hire/Partials/HireCard.vue";
import { ref } from 'vue'
import InvitationsFilter from '@/Components/InvitationsFilter.vue';
import InvitationCard from '../Invitation/Partials/InvitationCard.vue';
const props = defineProps({
    invitations: Array,
});

</script>

<template>
    <Head title="Invitations" />
    <AppLayout title="Invitations">
        <template #header>
            <p class="font-black text-7xl">Invitations</p>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-end space-x-4">
                    <Link :href="route('invitation.index')">
                    <SecondaryButton>
                        <span
                            :class="{ 'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index') }">
                            Invitation
                        </span>
                    </SecondaryButton>
                    </Link>
                    <Link :href="route('hire.index')">
                    <SecondaryButton>
                        <span
                            :class="{ 'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index') }">
                            Hire
                        </span>
                    </SecondaryButton>
                    </Link>
                </div>

                <div class="bg-white rounded-xl mt-4 min-h-[500px] p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <template v-for="invitation in invitations" :key="invitation.id">
                            <InvitationCard :invitation="invitation" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <InvitationsFilter form_route="hire.index" />
    </AppLayout>
</template>
