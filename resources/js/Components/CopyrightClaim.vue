<script setup>
import DateTranslation from '@/Components/DateTranslation.vue';
</script>

<template>
    <div class="flex justify-center h-10">
        <p class="text-xs text-white font-regular">{{ $t('Copyright') }} &copy;
            <DateTranslation format="YYYY" /> KJORA. {{ $t('All Rights Reserved') }}.
        </p>
    </div>
</template>
