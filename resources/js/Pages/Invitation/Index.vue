<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InvitationCard from "./Partials/InvitationCard.vue";
import DateTranslation from '@/Components/DateTranslation.vue';
import InvitationsFilter from '@/Components/InvitationsFilter.vue';
import { CalendarIcon } from "@heroicons/vue/20/solid";
import dayjs from 'dayjs';
const props = defineProps({
    invitations: Array,
});

</script>

<template>
    <Head title="Invitations" />

    <AppLayout title="Invitations">
        <template #header>
            <p class="text-4xl font-black md:text-7xl">{{ $t('invitations') }}</p>
        </template>

        <div class="py-12">
            <div class="">
                <div class="flex items-center justify-end gap-3">
                    <Link :href="route('invitation.index')">
                    <button
                        class="py-2 px-4 min-w-[120px] sm:min-w-[215px]  font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                        :class="{ 'border-primary': route().current('invitation.index'), 'border-none': !route().current('invitation.index') }">

                        <span :class="{ 'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index') }">
                            {{ $t('invitation') }}
                        </span>
                    </button>
                    </Link>
                    <Link :href="route('hire.index')">
                    <button
                        class="py-2 px-4 min-w-[120px] sm:min-w-[215px]  font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                        :class="{ 'border-primary': route().current('hire.index'), 'border-none': !route().current('hire.index') }">
                        <span :class="{ 'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index') }">
                            {{ $t('hire') }}
                        </span>
                    </button>
                    </Link>
                </div>

                <div class="bg-white rounded-xl mt-4 min-h-[500px] p-2 md:p-6">
                    <div class="flex gap-1 mb-4 text-xs font-bold" v-if="invitations.length">
                        <CalendarIcon class="w-4" />
                        <DateTranslation :start="invitations[invitations.length - 1].date" format="DD MMMM YYYY" />
                        <span v-if="dayjs(invitations[0].date).format('DD MMMM YYYY') !== dayjs(invitations[invitations.length - 1].date).format('DD MMMM YYYY')">
                            {{ $t('to') }}
                            <DateTranslation :start="invitations[0].date" format="DD MMMM YYYY" />
                        </span>
                    </div>
                    <div v-if="invitations.length" class="grid grid-cols-1 gap-4">
                        <template v-for="invitation in invitations" :key="invitation.id">
                            <InvitationCard :invitation="invitation" />
                        </template>
                    </div>

                    <div v-else class="grid place-items-center min-h-[480px] h-full">
                        <p class="text-sm font-bold text-black">{{ $t(`sorry, we don't have any result`) }} </p>
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
