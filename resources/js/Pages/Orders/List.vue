<template>
    <app-layout title="Dashboard">
        <template #header> Liste des commandes 
            <div class="flex justify-content-end">
                <DataViewLayoutOptions v-model="layout" />
                
            </div> 
        </template>
        <button @click="createPDF">Export Pdf</button>
        
        <Link
            :href="route('list.month.orders', month)"
            class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
        >Afficher les commandes du mois</Link>

        <Link
            :href="route('chart.orders')"
            class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
        >Graphique de la commande </Link>
        
        <div v-if="showListMonth">
            <ListMonth></ListMonth>
        </div>
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
                                <th class="px-6 py-4 text-center">
                                    Prix vendu EDL
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Frais de déplacement
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Total commande
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Coût expert
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Date de commande 
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
                                    {{ item.inventory_id }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ item.expense_expert }} €
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ item.expense_travel }} €
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ item.total_price }} €
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ item.cost_expert }} €
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{formatDate(item.created_at)  }} 
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button
                        v-on:click="computeTotal(orders)"
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 rounded-lg"
                    >
                        Calculer le total
                    </button>
                    <button
                        v-on:click="computeExpertFees(orders)"
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
                    >
                        Calculer le total coût expert
                    </button>
                    <button
                        v-on:click="computeTravelFees(orders)"
                        class="bg-mainone hover:bg-darkone text-white font-bold py-3 px-6 ml-6 rounded-lg"
                    >
                        Calculer le total coût de transport
                    </button>
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { jsPDF } from "jspdf";
import ListMonth from "@/Pages/Orders/ListMonth.vue";


// Datatable
import { format } from "date-fns";
import { intersectionTypeAnnotation } from "@babel/types";


export default defineComponent({
    
    components: {
        AppLayout,
        DataViewLayoutOptions,
        Head,
        Link,
        jsPDF,
        ListMonth,
    },
    
      
    data() {
        return {
            month: new Date().getMonth()+1,//mois courant par défaut
        };
        
    },
    mounted() {},
    

    methods: {
                
        toggleListMonth() {
        this.showListMonth = !this.showListMonth;
        },
        
        formatDate(date) {
            return format(new Date(date), "dd/MM/yyyy HH:mm");
        },
        destroy(id) {
            Inertia.delete(route("destroy.property_type", id));
        },
        computeTotal(orders) {
            var items = orders;
            var total = 0;

            items.forEach(function (item) {
                total += item["total_price"];
            });
            console.log(total);
            return total;
        },
        computeExpertFees(orders) {
            var items = orders;
            var total = 0;

            items.forEach(function (item) {
                total += item["cost_expert"];
            });
            console.log(total);
            return total;
        },
        computeTravelFees(orders) {
            var items = orders;
            var total = 0;

            items.forEach(function (item) {
                total += item["expense_travel"];
            });
            console.log(total);
            return total;
        },
    },
    setup() {
        // const formDelete = reactive({
        //     property_type: null,
        // });

        // const destroy = (id) => {
        //     Inertia.delete(route("destroy.property_type", id));
        // };
        function createPDF() {
            let pdfName = "test";
            var doc = new jsPDF("l", "in", [3, 5]);
            // doc.text("Salut Connard", 10, 10);
            // doc.save(pdfName + ".pdf");

            doc.setFont("helvetica");
            doc.setFontSize(2);

            var source = window.document.getElementsByTagName("table")[0];
            doc.html(source, {
                callback: function (doc) {
                    doc.save(pdfName + ".pdf");
                },
                x: 0,
                y: 0,
            });
            return;
        }
        return { createPDF };
        function toggleSousPage(){

        }
    },
});
</script>
