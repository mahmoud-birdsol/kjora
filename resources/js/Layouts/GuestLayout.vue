<script setup>
import GuestNavbar from '@/Layouts/Partials/GuestNavbar.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import CopyrightClaim from '@/Components/CopyrightClaim.vue';
import SystemMessage from '@/Components/SystemMessage.vue';
import { loadLanguageAsync } from 'laravel-vue-i18n';
import { onMounted } from 'vue';
const socials = usePage().props.value.socials;

onMounted(() => {
    loadLanguageAsync(usePage().props.value.locale)
})

</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-black to-primaryDark ltr:font-sans rtl:font-tahoma" :dir="$page.props.locale == 'ar' ? 'rtl' : 'ltr'">
        <div class="flex flex-col justify-between min-h-screen pt-6 space-y-8 sm:pt-0 ltr:font-sans rtl:font-tahoma">
            <GuestNavbar />
            <main class="flex justify-center my-4">
                <slot />
            </main>

            <div class="w-full mx-auto max-w-7xl pis-4" v-if="route().current('login')">
                <div class="flex items-center justify-start gap-4">
                    <template v-for="social in socials" :key="social.id">
                        <a :href="social.url">
                            <img :src="social.icon" alt="" class="w-10 h-10">
                        </a>
                    </template>
                </div>
            </div>

            <footer>
                <div class="flex justify-center h-10">
                    <CopyrightClaim />
                </div>
            </footer>
            <SystemMessage />
        </div>
    </div>
</template>
