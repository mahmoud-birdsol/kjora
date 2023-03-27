
<script setup>
const props = defineProps({
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
})
const options = {
    chart: {
        id: 'vuechart-example',
        redrawOnWindowResize: true,
        foreColor: '#000',
        dropShadow: {
            enabled: true,
            enabledOnSeries: true,
            top: 0,
            left: 0,
            blur: 3,
            color: '#000',
            opacity: 0.35
        }
    },
    xaxis: {
        categories: props.labels
    },
    yaxis: {
        show: true,
        min: 0,
        max: 5,
        tickAmount: 5,
        labels: {
          show: true,
          style: {
              fontSize: '12px',
              fontWeight: 900,
          },
        }
    },
    stroke:{
        show:false,
    },
    // colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800']
    fill: {
        colors: ['rgba(0,100,0)'],
        opacity: 1,
        type: 'solid',
    },
    plotOptions: {
        radar: {
            polygons: {
                strokeWidth: 10,
                strokeColors: '#aaaaaa',
                fill: {
                    // colors: ['#f8f8f8', 'rgba(0,100,0)'],
                  }
                
            }
        }
    },

    markers: {
        size: 2,
        colors: ['#CCC'],
        hover: {
            size: 10
        }
    },
    tooltip: {
        enabled: false,
    },
    // responsive: [{
    //     breakpoint: 640,
    //     options: {
    //         chart: {
    //             width: '100%'
    //         }
    //     },
    // }]
};
const series = [{
    name: 'series-1',
    // data: props.data
    data: props.data
}]
</script>
<template>
    <apexchart width="100%" type="radar" :options="options" :series="series"></apexchart>
</template>
<style>
.apexcharts-toolbar,
.apexcharts-menu-icon {
    display: none;
}

.apexcharts-canvas {
    margin: auto;
}
.apexcharts-series{
    mix-blend-mode: multiply;
}
/* .apexcharts-plot-series polygon{
 
mix-blend-mode: difference;
} */
</style>
<!-- <script setup>
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
} -->
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
<!-- </script> -->
<!-- <template>
    <Radar :data="data" :options="options"/>
</template> -->
