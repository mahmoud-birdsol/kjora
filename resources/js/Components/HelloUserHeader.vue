<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import { inject } from 'vue';

const greetings = inject('greetings')
</script>

<template>
    <p class="text-2xl font-light">{{ $t('hello') }} ,</p>
    <p class="text-3xl font-bold max-sm:whitespace-nowrap md:text-7xl">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</p>
    <p class="text-base font-semibold">
        <DateTranslation />
    </p>
</template>
