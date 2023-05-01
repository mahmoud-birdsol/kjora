<template>
    <Transition enter-from-class="opacity-0 rtl:translate-y-full ltr:-translate-y-full" enter-to-class="translate-y-0 opacity-100 " enter-active-class="transition duration-300 ease-in-out " leave-active-class="transition duration-300 ease-in-out " leave-from-class="translate-y-0 opacity-100"
        leave-to-class="opacity-0 rtl:translate-y-full ltr:-translate-y-full">
        <slot />
    </Transition>
</template>

<script setup>

</script>

<style  ></style>
