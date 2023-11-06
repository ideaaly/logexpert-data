<template>
    <app-layout title="Dashboard">
        <template #header>
            Liste des commandes
            <div class="flex justify-content-end">
                <DataViewLayoutOptions v-model="layout" />
            </div>
        </template>
        
        <div class="mx-auto max-w-screen-xl">
            <div
                class="bg-white drop-shadow-2xl rounded-xl my-6 overflow-hidden"
            >
                <div class="bg-white x-12 my-6 px-4">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-12"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            
                        </thead>
                        <tbody>
                            
                            <div class="card">
                            <Chart type="line" :data="chartData" :options="chartOptions" class="h-30rem" />
                            </div> 
                            
                        </tbody>
                        
                        
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataViewLayoutOptions from "@inertiajs/inertia-vue3";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link, } from "@inertiajs/inertia-vue3";
import { reactive } from "vue"; 
import { Inertia } from "@inertiajs/inertia";
import Chart from 'primevue/chart';
import { ref, onMounted } from "vue";


// Datatable
import { format } from "date-fns";
import { intersectionTypeAnnotation } from "@babel/types";

onMounted(() => {
    
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();



const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
        

export default defineComponent({
    components: {
        AppLayout,
        DataViewLayoutOptions,
        Head,
        Link,
        Chart,
       
    },
    

    props: ["errors", "orders", "total", "chartData"],

    setup(props) {
    const chartData = ref(props.chartData);

    onMounted(() => {
        
        chartOptions.value = setChartOptions();
    });

    return {
        
        chartOptions,
    };
},
    
});

</script>
