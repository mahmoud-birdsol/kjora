<script setup>
import GuestNavbar from '@/Layouts/Partials/GuestNavbar.vue';
import dayjs from 'dayjs';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-black to-primary">
        <div class="min-h-screen flex flex-col justify-between pt-6 sm:pt-0 space-y-8">
            <GuestNavbar/>

            <main class="flex justify-center my-4">
                <slot/>
            </main>

            <footer>
                <div class="h-10 flex justify-center">
                    <p class="text-white text-sm font-light">Copyright &copy; {{ dayjs().format('YYYY') }} KJORA. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </div>
</template>
