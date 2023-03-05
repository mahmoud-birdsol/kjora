<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InvitationCard from "./Partials/InvitationCard.vue";
import TextInput from '../../Components/TextInput.vue';
import { ref, watch } from 'vue';


const props = defineProps({
    invitations: Array,
});

const loading = ref(false);
const form = useForm({
    search: null,

})
function searchInvitations() {
    loading.value = true;
    form.get(route('invitation.index'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
        }
    })
}

watch(() => form.search, () => {
    _.debounce(searchInvitations, 500)();
});
</script>

<template>
    <Head title="Invitations" />

    <AppLayout title="Invitations">
        <template #header>
            <p class="text-4xl md:text-7xl font-black">Invitations</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end items-center space-x-4">
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
                    <div class="">
                        <TextInput type="search" v-model="form.search" placeholder="Search" />
                    </div>
                    <div class="grid grid-cols-1 gap-4" v-loading="loading">
                        <template v-for="invitation in invitations" :key="invitation.id">
                            <InvitationCard :invitation="invitation" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
