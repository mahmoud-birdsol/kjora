<template>
    <Transition enter-from-class="rtl:translate-x-full ltr:-translate-x-full opacity-0" enter-to-class="translate-x-0 opacity-100 " enter-active-class="transition duration-300 ease-in-out " leave-active-class="transition duration-300 ease-in-out " leave-from-class="translate-x-0 opacity-100"
        leave-to-class="rtl:translate-x-full ltr:-translate-x-full opacity-0">
        <slot />
    </Transition>
</template>

<script setup>

</script>

<style  ></style>
