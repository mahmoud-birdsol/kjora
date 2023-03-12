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
            <p class="text-7xl font-black">{{$t('invitations')}}</p>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end items-cente gap-3 ">
                    <Link :href="route('invitation.index')">
                        <SecondaryButton>
                                <span
                                    :class="{'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index')}">
                                    {{ $t('invitation') }}
                                </span>
                        </SecondaryButton>
                    </Link>
                    <Link :href="route('hire.index')">
                        <SecondaryButton>
                                <span
                                    :class="{'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index')}">
                                    {{$t('hire')}}
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
