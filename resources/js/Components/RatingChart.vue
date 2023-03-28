
<script setup>
import { computed } from '@vue/reactivity';

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
const series = computed(()=>{
    return [{
    name: 'series-1',
    data: props.data
}]
})

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
</style>

