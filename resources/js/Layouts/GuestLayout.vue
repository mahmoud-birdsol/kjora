<script setup>
import GuestNavbar from '@/Layouts/Partials/GuestNavbar.vue';
import dayjs from 'dayjs';
import { usePage } from '@inertiajs/inertia-vue3';

const socials = usePage().props.value.socials;
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-black to-primary">
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
                    <p class="text-white text-sm font-medium">Copyright &copy; {{ dayjs().format('YYYY') }} KJORA. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </div>
</template>
