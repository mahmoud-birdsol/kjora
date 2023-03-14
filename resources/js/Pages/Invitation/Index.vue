<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InvitationCard from "./Partials/InvitationCard.vue";

import InvitationsFilter from '@/Components/InvitationsFilter.vue';
const props = defineProps({
    invitations: Array,
});

</script>

<template>
    <Head title="Invitations" />

    <AppLayout title="Invitations">
        <template #header>

            <p class="text-4xl font-black md:text-7xl">{{$t('invitations')}}</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-end space-x-4">
                    <Link :href="route('invitation.index')">
                    <SecondaryButton>
                        <span
                            :class="{ 'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index') }">
                            {{ $t('invitation') }}
                        </span>
                    </SecondaryButton>
                    </Link>
                    <Link :href="route('hire.index')">
                    <SecondaryButton>
                        <span
                            :class="{ 'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index') }">
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
        <InvitationsFilter url="invitation.index" />
    </AppLayout>
</template>
<style>
.el-input__wrapper {
    background-color: black;
    color: white;
}

.el-input__inner {
    color: white;

}
</style>
