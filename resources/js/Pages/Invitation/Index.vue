<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InvitationCard from "./Partials/InvitationCard.vue";
import DateTranslation from '@/Components/DateTranslation.vue';
import InvitationsFilter from '@/Components/InvitationsFilter.vue';
import Pagination from '@/Components/Pagination.vue';
import { CalendarIcon } from "@heroicons/vue/20/solid";
import dayjs from 'dayjs';
import { computed, ref } from 'vue';
import { paginationEmits } from 'element-plus';
import InvitationHireTaps from '../../Components/InvitationHireTaps.vue';
const props = defineProps({
    invitations: Object,
});

const fromDate = ref(null)
const toDate = ref(null)

function groupInvitationsByDate(invitations) {
    return invitations.reduce((groups, invitation) => {
        const date = dayjs(invitation.date).format('DD MMMM YYYY');
        if (groups[date]) {
            groups[date].push(invitation);
        } else {
            groups[date] = [invitation];
        }
        return groups;
    }, {});
}

const invitationsGroups = computed(() => groupInvitationsByDate(props.invitations.data))


function showFromToDates(date1, date2) {
    fromDate.value = dayjs(date1).format('DD MMMM YYYY')
    toDate.value = dayjs(date2).format('DD MMMM YYYY')
}
</script>

<template>
    <Head title="Invitations" />

    <AppLayout title="Invitations">
        <template #header>
            <p class="text-4xl font-black md:text-7xl">{{ $t('invitations') }}</p>
        </template>

        <div class="py-12">
            <div class="">
                <InvitationHireTaps />

                <div class="bg-white rounded-xl mt-4 min-h-[500px] p-2 md:p-6">
                    <div class="flex gap-1 mb-4 text-xs font-bold" v-if="fromDate && toDate">
                        <CalendarIcon class="w-4" />
                        <span>
                            {{ $t('from') }}
                        </span>
                        <DateTranslation :start="fromDate" format="DD MMMM YYYY" />
                        <span>
                            {{ $t('to') }}
                        </span>
                        <DateTranslation :start="toDate" format="DD MMMM YYYY" />
                    </div>
                    <div v-if="invitations.data.length" class="grid grid-cols-1 gap-4">
                        <template v-for="( invitationsGroup, date) in invitationsGroups" :key="date">
                            <div class="text-xs font-bold flex gap-1">
                                <CalendarIcon class="w-4" />
                                <DateTranslation :start="date" format="DD MMMM YYYY" />
                            </div>
                            <template v-for="(invitation, index) in invitationsGroup" :key="invitation.id">
                                <InvitationCard :invitation="invitation" />
                            </template>
                        </template>
                    </div>

                    <div v-else class="grid place-items-center min-h-[480px] h-full">
                        <p class="text-sm font-bold text-black">{{ $t(`Sorry, we couldn't find any results`) }} </p>
                    </div>
                    <div class="mt-4 flex justify-center">
                        <Pagination :links="invitations.links"></Pagination>
                    </div>
                </div>
            </div>
        </div>
        <InvitationsFilter url="invitation.index" @filter="showFromToDates" />
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
