
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
    },
    responsive: [{
        breakpoint: 500,
        options: {
            // yaxis: {
            //     min: 0,
            //     max: 5,
            //     tickAmount: 10,
            //     labels: {
            //         style: {
            //             fontSize: '9px',
            //         },
            //     },
            // },
            xaxis: {
                labels: {
                    style: {
                        fontSize: '9px',
                    },
                }
            },
        },
    }],
    xaxis: {
        categories: props.labels,
        labels: {
            style: {
                fontSize: '12px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        }
    },

    yaxis: {
        show: false,
        min: 0,
        max: 5,
        tickAmount: 10,
        labels: {
            show: true,
            style: {
                fontSize: '12px',
                fontWeight: 800,
            },
        },
    },
    stroke: {
        show: true,
        colors: ['rgb(253,224,60)'],

    },
    fill: {
        colors: ['rgb(253 ,224 ,71)'],
        opacity: 1,
        type: 'solid',
    },
    plotOptions: {
        radar: {
            polygons: {
                strokeWidth: 0,
                // strokeColors: '#FFF',
                fill: {
                    colors: ['rgb(0,100,0)', '#FFF']
                }
            }
        }
    },

    markers: {
        size: 3,
        colors: ['#fff'],
        strokeColor: 'rgba(0, 100, 0)',
        strokeWidth: 1,
        hover: {
            size: 4
        }
    },
    tooltip: {
        enabled: true,
        custom: function ({ series, seriesIndex, dataPointIndex, w }) {
            return '<div class="arrow_box">' +
                '<span style="font-size:9px; padding:0px 10px; color:black; ">' + series[seriesIndex][dataPointIndex].toFixed(2) + '</span>' +
                '</div>'
        },
    },
};
const series = computed(() => {
    return [{
        name: 'Rating',
        data: props.data.length ? props.data : new Array(props.labels?.length).fill(0)
    }]
})

</script>
<template>
    <apexchart width="100%" type="radar" :options="options" :series="series" v-if="labels.length"></apexchart>
    <div v-else class="text-sm font-normal text-gray-100 h-56 grid place-items-center normal-case">{{ $t('no rating categories for this position untill now') }}</div>
</template>
<style>
.apexcharts-toolbar,
.apexcharts-menu-icon {
    display: none !important;
}

.apexcharts-canvas {
    margin: auto;
}

.apexcharts-series path:nth-child(2) {
    mix-blend-mode: lighten;
}

.apexcharts-datalabel {
    direction: ltr;
}

@media (max-width: 567px) {
    .vue-apexcharts svg {

        transform: scale(1.5);
        transform-origin: top;
    }

}
</style>
