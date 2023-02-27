<template>
    <div class="text-xl text-center text-white capitalize">
        <Radar :data="[28, 48, 40, 19, 96, 27]"/>
    </div>
</template>

<script setup>
import Radar from './Radar.vue';
    // scales: {
    //     r: {
    //         max: 5,
    //         min: 1,
    //         ticks: {
    //             count:9,
    //             stepSize: 0.5,
    //             color: '#000',
    //             backdropColor: 'transparent',
    //             z: 100,
    //         },
    //         grid: {
    //             color: '#DBDBDB',
    //             lineWidth: 8,
    //             circular: true,
    //         },
    //         angleLines: {
    //             display: false
    //         },
    //         pointLabels: {
    //             color: '#000',
    //         },
    //         backgroundColor: 'rgb(9, 70, 9)',
    //         beginAtZero: true,
    //     },
    // },

</script>

<style lang="scss" scoped></style>
