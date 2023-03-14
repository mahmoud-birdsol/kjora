<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
import dayjs from 'dayjs';
</script>

<template>
    <div class="h-10 flex justify-center">
        <p class="text-white text-xs font-regular">{{$t('Copyright')}} &copy; <DateTranslation format="YYYY"/> KJORA. {{$t('All Rights Reserved')}}.</p>
    </div>
</template>
