<template>
    <app-layout title="Dashboard">
        <template #header> Liste des commandes </template>
        <button @click="createPDF">Export Pdf</button>
        <div class="mx-auto max-w-screen-xl">
            <div
                class="bg-white drop-shadow-2xl rounded-xl my-6 overflow-hidden"
            >
                <div class="bg-white x-12 my-6 px-4">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-12"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th class="px-6 py-4 text-center">ID</th>
                                <th class="px-6 py-4 text-center">Ref EDL</th>
                                <th class="px-6 py-4 text-center">Date RDV</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Date RDV</th>
                                <th class="px-6 py-4 text-center">
                                    Type de bien
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Coût Expert
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Prix vendu
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in $page.props.data"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <td class="px-6 py-4 text-center">
                                    {{ item.id }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ item.status }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ item.appointment.date }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span v-if="item.propertyType">
                                        {{ item.propertyType.name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span v-if="item.propertyType">
                                        {{ item.propertyType.price_senior }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span v-if="item.propertyType">
                                        {{ item.propertyType.sale_price }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center"></td>
                            </tr>
                        </tbody>
                    </table>

                    <button
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 rounded-lg"
                    >
                        Calculer le total
                    </button>
                    <button
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
                    >
                        Calculer le total coût expert
                    </button>
                    <button
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
                    >
                        Calculer le total coût de transport
                    </button>

                    <div>
                        <apexchart
                            width="100%"
                            type="bar"
                            :options="options"
                            :series="series"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
// Datatable
import { format } from "date-fns";
import { intersectionTypeAnnotation } from "@babel/types";
import VueApexCharts from "vue3-apexcharts";

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Link,
        VueApexCharts,
    },

    props: ["data", "orderDates", "ordersCount", "reportData", "errors"],
    data() {
        return {
            data: this.data,
            orderDates: this.orderDates,
            ordersCount: this.ordersCount,
            reportData: this.reportData,
            options: {
                chart: {
                    id: "vuechart-example",
                },
                xaxis: {
                    categories: this.orderDates,
                },
            },
            series: [
                {
                    name: "Commandes EDL",
                    data: this.ordersCount,
                },
            ],
        };
    },
    mounted() {},

    methods: {
        destroy(id) {},
    },
    setup() {},
});
</script>
