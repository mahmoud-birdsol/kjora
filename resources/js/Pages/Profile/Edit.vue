<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import HelloUserHeader from "@/Components/HelloUserHeader.vue";

defineProps({
    countries: Array,
    positions: Array,
});
</script>

<template>
    <Head title="Profile" />

    <AppLayout title="Profile" :showBall="false">
        <template #header>
            <HelloUserHeader />
        </template>

        <UpdateProfileInformationForm
            :user="$page.props.user"
            :countries="countries"
            :positions="positions"
        />
    </AppLayout>
</template>
