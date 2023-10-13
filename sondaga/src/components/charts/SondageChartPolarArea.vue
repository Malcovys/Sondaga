<template>
    <div>
        <apexchart v-if="options" type="polarArea" :options="options.chartOptions" :series="options.series"></apexchart>
    </div>
  </template>
  
  <script setup>
  import { ref, watchEffect } from 'vue';
  
  const options = ref({});
  const props = defineProps([
    'data', 'title', 'options'
  ]);

  watchEffect( () => {
    options.value = (
        {
            series: props.data,
            chartOptions: {
                chart: {
                    type: 'polarArea',
                    whidth: 150,
                },
                stroke: {
                    colors: ['#fff']
                },
                fill: {
                    opacity: 0.8
                },
                title: {
                    text: props.title,
                    align: 'left',
                },
                legend: {
                    show:true,
                    formatter: function (seriesName) {
                        seriesName = props.options[seriesName.slice(7)-1];
                        return seriesName;
                    }
                },
            },
        }
    );
  })
  </script>
  