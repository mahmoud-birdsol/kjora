<template>
    <div class="text-xl text-center text-white capitalize">
        <Radar :data="data" :options="options" />
    </div>
</template>

<script setup>
import {
    Chart as ChartJS,
    RadialLinearScale,
    PointElement,
    LineElement,
    Filler,
    Tooltip,
} from 'chart.js'
import { Radar } from 'vue-chartjs'

ChartJS.register(
    RadialLinearScale,
    PointElement,
    LineElement,
    Filler,
    Tooltip,
)
const data = {
    labels: [
        'Agility',
        'Stamina',
        'Sttrngth',
        'Passing',
        'Shooting',
        'pace',
    ],
    datasets: [
  {
    label: 'My Second Dataset',
    data: [28, 48, 40, 19, 96, 27],
    fill: true,
    backgroundColor: 'rgba(255, 255, 255, 0.2)',
    borderColor: 'rgb(255, 255, 255)',
    pointBackgroundColor: 'rgb(255, 255, 255)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(54, 162, 235)'
  }
]
}
const options = {
    responsive: true,
    maintainAspectRatio: false,
    elements: {
      line: {
        borderWidth: 3
      }
    },
    scales:{
        r:{
            grid: {
                color: '#DBDBDB',
                lineWidth: 1,
                // circular: true,
            },
            ticks: {
                color: '#FFF',
                backdropColor: 'transparent',
                z: 100,
            },
            pointLabels: {
                color: '#FFF',
            },
        }
    }
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
}
</script>

<style lang="scss" scoped></style>
