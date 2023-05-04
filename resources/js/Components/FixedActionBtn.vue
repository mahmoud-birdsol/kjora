<script setup>
defineEmits(["clicked"]);
</script>
<template>
    <!-- @click="$emit('clicked')" -->
    <div
        class="fixed bottom-0 z-10 pb-20 pointer-events-none right-[20px] sm:pb-24"
    >
        <button
            class="flex items-center justify-center w-16 h-16 text-center bg-black rounded-full shadow-xl pointer-events-auto"
        >
            <slot />
        </button>
    </div>
</template>
