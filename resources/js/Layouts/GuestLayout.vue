<script setup>
import GuestNavbar from '@/Layouts/Partials/GuestNavbar.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import CopyrightClaim from '@/Components/CopyrightClaim.vue';
import SystemMessage from '@/Components/SystemMessage.vue';
const socials = usePage().props.value.socials;
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-black to-primaryDark">
        <div class="min-h-screen flex flex-col justify-between pt-6 sm:pt-0 space-y-8">
            <GuestNavbar/>
            <main class="flex justify-center my-4">
                <slot/>
            </main>

            <div class="w-full max-w-7xl mx-auto" v-if="route().current('login')">
                <div class="flex justify-start items-center space-x-4">
                    <template v-for="social in socials" :key="social.id">
                        <a :href="social.url">
                            <img :src="social.icon" alt="" class="h-10 w-10">
                        </a>
                    </template>
                </div>
            </div>

            <footer>
                <div class="h-10 flex justify-center">
                    <CopyrightClaim/>
                </div>
            </footer>
            <SystemMessage />
        </div>
    </div>
</template>
