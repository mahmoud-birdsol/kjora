<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InvitationsFilter from '@/Components/InvitationsFilter.vue';
import HireCard from './Partials/HireCard.vue';

const props = defineProps({
    invitations: Array,
});

</script>

<template>
    <Head title="Invitations"/>
    <AppLayout title="Invitations">
        <template #header>
            <p class="text-7xl font-black">{{ $t('invitations') }}</p>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end items-center gap-3 ">
                    <Link :href="route('invitation.index')">
                        <button
                            class="py-2 px-4  min-w-[215px] w-1/5 font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                            :class="{ 'border-primary': route().current('invitation.index'), 'border-none': !route().current('invitation.index') }">

                            <span :class="{'text-gray-500': !route().current('invitation.index'), 'text-black': route().current('invitation.index')}">
                                    {{ $t('invitation') }}
                            </span>
                        </button>
                    </Link>
                    <Link :href="route('hire.index')">
                        <button
                            class="py-2 px-4  min-w-[215px] w-1/5 font-bold  text-center items-center bg-white border-2 border-gray-300 rounded-full text-xs  text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition whitespace-nowrap"
                            :class="{ 'border-primary': route().current('hire.index'), 'border-none': !route().current('hire.index') }">
                                <span
                                    :class="{'text-gray-500': !route().current('hire.index'), 'text-black': route().current('hire.index')}">
                                    {{ $t('hire') }}
                                </span>
                        </button>
                    </Link>
                </div>

                <div class="bg-white rounded-xl mt-4 min-h-[500px] p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <template v-for="invitation in invitations" :key="invitation.id">
                            <HireCard :invitation="invitation"/>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <InvitationsFilter url="hire.index"/>
    </AppLayout>
</template>
