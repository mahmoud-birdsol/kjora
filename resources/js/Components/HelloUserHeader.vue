<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
</script>

<template>
    <p class="text-2xl font-light">{{ $t('hello') }} , {{$page.props.user.last_known_ip}}</p>
    <p class="text-7xl font-bold">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</p>
    <p class="text-base font-semibold"><DateTranslation /></p>
</template>
