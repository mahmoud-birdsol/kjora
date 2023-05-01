<template>
    <Transition enter-from-class="opacity-0" enter-to-class="opacity-100 " appear
        enter-active-class="transition duration-300 ease-in-out " leave-active-class="transition duration-300 ease-in-out "
        leave-from-class="opacity-100 " leave-to-class="opacity-0 " mode="out-in">
        <slot />
    </Transition>
</template>

<script setup>

</script>

<style ></style>
