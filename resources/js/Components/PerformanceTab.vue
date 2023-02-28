<template>
    <div class="text-xl text-center text-white capitalize">
        <RatingChart :data="data" :labels="labels" />
    </div>
</template>

<script setup>
import RatingChart from './RatingChart.vue';
const props = defineProps(['playerRating'])

const data = props.playerRating.map(r => r.value)
const labels = props.playerRating.map(r => r.ratingCategory)
</script>

<style lang="scss" scoped></style>
