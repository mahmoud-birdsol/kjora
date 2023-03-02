<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import HelloUserHeader from '@/Components/HelloUserHeader.vue';


defineProps({
    countries: Array,
    positions: Array,
});
</script>

<template>
    <Head title="Profile" />

    <AppLayout title="Profile">
        <template #header>
            <HelloUserHeader />
        </template>

        <UpdateProfileInformationForm :user="$page.props.user" :countries="countries" :positions="positions" />
    </AppLayout>
</template>



