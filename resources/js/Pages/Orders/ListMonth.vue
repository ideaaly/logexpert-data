<template>
    <app-layout title="Dashboard">
        <template #header>
            Liste des commandes
            <div class="flex justify-content-end">
                <DataViewLayoutOptions v-model="layout" />
            </div>
        </template>
        <button @click="createPDF">Export Pdf</button>
        <select id="month" v-model="currentSelectedMonth" @change="redirectToSelectedMonth(currentSelectedMonth)">
            <option value="0">Tous les mois</option>
            <option v-for="(month, index) in months" :value="index + 1" :key="index">{{ month }}</option>
         </select>
        


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
                            <tr>
                                <th :key="selectedMonthName" class="month-header">
                                    {{ selectedMonthName }}
                                </th>
                            </tr>
                            
                        </thead>
                        <tbody>
                                                            
                                <tr 
                                    v-for="order in orders"

                                >
                                <td class="px-6 py-4 text-center">
                                    {{ order.inventory.reference }}
                                </td> 

                                <td class="px-6 py-4 text-center">
                                    {{formatDate (order.created_at) }}
                                </td>
                                
                                <td class="px-6 py-4 text-center">
                                    {{ order.total_price }}
                                </td>
                                
                                

                                </tr>
                                
                            
                        </tbody>
                        <label
                            class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                            for="Totql"
                        > Total des commandes ce mois-ci
                        <div v-if="total" class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"> 
                                {{ total}}
                        </div>

                        </label>
                        
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
import { jsPDF } from "jspdf";





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
       
    },

    props: ["errors", "orders", "total"],

    data() {
        return {
            selectedMonth: 0, // Initialize to "Tous les mois" (All months)
                months: [
                "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
            ],
            filteredOrders: [], // Store filtered orders
            selectedMonthName: "", // Nouvelle propriété pour stocker le nom du mois sélectionné

        };
    },
    
    
    
   
    mounted() {},
    methods: {
        
        redirectToSelectedMonth(month) {
        // Obtenir l'URL correspondant à l'option sélectionnée
        const selectedMonthUrl = month;

        this.selectedMonthName = this.months[month - 1]; // -1 car les index commencent à 0


        // Rediriger l'utilisateur vers l'URL
        Inertia.visit(route("list.month.orders", selectedMonthUrl));
        },
      
        getSelectedMonthUrl() {
        // Logique pour déterminer l'URL en fonction de l'option sélectionnée
        // Vous pouvez ajouter votre propre logique ici
        // Par exemple, vous pouvez avoir un tableau d'URLs correspondant à chaque mois.
       

        return `/month/${this.selectedMonth}`; // Exemple : "/month/1" pour le mois 1
        },

        formatDate(date) {
            return format(new Date(date), "dd/MM/yyyy HH:mm");
        },
        destroy(id) {
            Inertia.delete(route("destroy.property_type", id));
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
    },
    
    
});

</script>
<style>
.month-header {
  transition: opacity 0.5s; /* Ajoute une transition d'opacité */
}
</style>
