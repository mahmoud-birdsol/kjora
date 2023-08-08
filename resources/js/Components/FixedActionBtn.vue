<script setup>
import { usePage } from '@inertiajs/vue3';

const state = usePage().props.auth.user.state_name;

</script>
<template>
    <div class="fixed bottom-0 z-50 pb-20 pointer-events-none sm:pb-24 right-5 BeaconFabButtonFrame !shadow-none">
        <button class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full pointer-events-auto enabled:hover:bg-stone-800 active:bg-gray-900 focus:border-gray-900 disabled:bg-stone-500 user-premium:bg-golden user-premium:enabled:hover:bg-golden/50 user-premium:focus:border-golden/90 user-premium:focus:ring-golden user-premium:disabled:bg-golden/30">
            <slot />
        </button>
    </div>
</template>
