<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
</script>

<template>
    <p class="text-2xl font-light">{{ $t('hello') }} ,</p>
    <p class="text-3xl max-sm:whitespace-nowrap md:text-7xl font-bold">ahmed el sheridah</p>
    <p class="text-base font-semibold"><DateTranslation /></p>
</template>
