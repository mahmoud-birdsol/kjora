<script setup>
defineEmits(["clicked"]);
</script>
<template>
    <!-- @click="$emit('clicked')" -->
    <div
        class="fixed bottom-0 right-0 z-10 p-4 pb-32 pointer-events-none sm:pb-24"
    >
        <button
            class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl pointer-events-auto"
        >
            <slot />
        </button>
    </div>
</template>
