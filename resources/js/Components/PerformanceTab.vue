<template>
    <div class="text-xl text-center text-white capitalize overflow-hidden max-sm:pb-20 ">
        <RatingChart :data="data" :labels="labels" />
    </div>
</template>

<script setup>
import RatingChart from './RatingChart.vue';
const props = defineProps(['playerRating'])

const data = props.playerRating.map(r => r.value)
// if no playerRating [empty array ] the chart will disappear even if in the chart component default values for props.labels
const labels = props.playerRating?.length ? props.playerRating.map(r => r.ratingCategory) : ['Agility', 'Stamina', 'Sttrngth', 'Passing', 'Shooting', 'pace',]
</script>

<style lang="scss" scoped></style>
