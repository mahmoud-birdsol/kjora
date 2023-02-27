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
let props = defineProps({
    labels:{
        type:Array,
        default: [
        'Agility',
        'Stamina',
        'Sttrngth',
        'Passing',
        'Shooting',
        'pace',
    ]
    },
    data: Array
})
const data = {
    labels: props.labels,
    datasets: [
  {
    label: 'My Second Dataset',
    data: props.data,
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
}
</script>
<template>
    <Radar :data="data" :options="options" />
</template>