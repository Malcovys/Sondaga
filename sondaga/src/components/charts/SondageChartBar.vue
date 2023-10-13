<template>
  <div>
    <apexchart
      v-if="options"
      type="bar"
      :options="options.chartOptions"
      :series="options.series"
      height="150"
    ></apexchart>
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import ApexCharts from 'vue3-apexcharts';

const props = defineProps([
  'data', 'categories', 'title'
])

const options = ref(null);

watchEffect(() => {
  options.value = {
    series: [
      { data: props.data }
    ],
    chartOptions: {
      chart: {
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
          dataLabels: {
            position: 'bottom'
          },
        }
      },
      colors: ['#082f49'],
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
          colors: ['#fff']
        },
        formatter: function (val) {
          return val;
        }
      },
      xaxis: {
        categories: props.categories,
        labels: {
          show: false
        },
      },
      title: {
        text: props.title
      }  
    }
  };
});
</script>
