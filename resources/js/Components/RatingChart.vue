<script setup>
import { computed } from '@vue/reactivity';
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
    labels: {
        type: Array,
        default: [
            'Agility',
            'Stamina',
            'Sttrngth',
            'Passing',
            'Shooting',
            'pace',
        ]
    },
    data: Array,
    theme: {
        default: 'rgb(255, 255, 255)'
    },
    overlay: {
        default: 'rgba(255, 255, 255, 0.2)'
    }

})
const data = computed(() => {
    return {
        labels: props.labels,
        datasets: [
            {
                label: 'My Second Dataset',
                data: props.data,
                fill: true,
                backgroundColor: props.overlay,
                borderColor: props.theme,
                pointBackgroundColor: props.theme,
                pointBorderColor: props.theme,
                pointHoverBackgroundColor: props.theme,
                pointHoverBorderColor: 'rgb(54, 162, 235)'
            }
        ]
    }
})
const options = {
    responsive: true,
    maintainAspectRatio: false,
    elements: {
        line: {
            borderWidth: 3
        }
    },
    scales: {

        r: {
            max: 5,
            min: 0,
            grid: {
                color: props.theme,
                lineWidth: 2,
                circular: true,
            },
            ticks: {
                color: props.theme,
                backdropColor: 'transparent',
                z: 100,
            },
            pointLabels: {
                color: props.theme,
                font: {
                    weight: 900,
                    size: 11,

                }
            },
        }
    },
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
</script>
<template>
    <Radar :data="data" :options="options" />
</template>
