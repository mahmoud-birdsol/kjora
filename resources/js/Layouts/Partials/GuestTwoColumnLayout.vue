<script setup>

</script>

<template>
    <div class="w-full sm:flex sm:justify-between sm:space-x-4 px-4 sm:px-8">
        <div class="w-full sm:flex sm:justify-end sm:w-1/2">
            <div>
                <h2 class="text-white text-2xl font-light uppercase">Welcome to</h2>
                <h1 class="text-white text-6xl font-black uppercase">KJORA</h1>
            </div>
        </div>

        <div class="w-full sm:w-1/2">
            <slot/>
        </div>
    </div>
</template>
