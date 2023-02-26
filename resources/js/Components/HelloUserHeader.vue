<script setup>
import dayjs from 'dayjs';
</script>

<template>
    <p class="text-2xl font-light">Hello,</p>
    <p class="text-7xl font-bold">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}</p>
    <p class="text-base font-semibold">{{ dayjs().format('dddd, DD MMMM YYYY') }}</p>
</template>
