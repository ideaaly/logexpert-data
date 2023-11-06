<template>
  <app-layout title="Dashboard">
    <div class="mx-auto" ref="contentTop">
      <div class="bg-white border-0 md:border border-t-0 border-gray-100 overflow-hidden">
        <div class="bg-white x-12">
            <DataTable
                        id="table"
                        :value="inventories.data"
                        
                        class="p-datatable-lg"
                        dataKey="id"
                        v-model:filters="filters"
                        filterDisplay="menu"
                        :rows="10"
                        :rowHover="true"
                       
                        currentPageReportTemplate="Liste des EDL de {first} à {last} sur {totalRecords} entrées"
                        responsiveLayout="scroll"
                        breakpoint="640px"
                        ref="table"
                        @row-click="handleClick($event)"
                        @page="handleClickPage($event)"
              >
              <template #header>
                <div
                    class="block md:flex flex-column justify-between align-items-center"
                    data-v-6432df8e=""
                >
                 <h2
                    class="text-mainone m-0 leading-none flex flex-col font-bold text-xs md:text-sm mb-4 md:mb-0"
                  >
                  Liste des
                  <span
                    class="text-white mt-1 leading-none flex flex-col text-lg md:text-xl font-black"
                  >
                  États des lieux</span>
                  </h2>
                  <label
                     class="block align-center justify-center flex"
                     for="filter"
                  >
                  <input
                     type="search"
                     class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-sm font-normal text-gray-700 bg-white rounded-full transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:outline-none"
                     placeholder="Rechercher"
                     aria-label="Rechercher"
                     aria-describedby="button-addon2"
                      v-model="filters['global'].value"
                  />
                  </label>
                </div>          
              </template>
              <Column field="id" header="ID" sortable style="width: 25%"></Column>
              <Column field="reference" header="Réf." sortable style="width: 25%"></Column>
              <Column field="status" header="Status" sortable style="width: 25%"></Column>
              <Column field="type" header="Type" sortable style="width: 25%"></Column>
              <Column field="propertyType.name" header="Logement" sortable style="width: 25%"></Column>
              <Column field="property.city" header="Ville" sortable style="width: 25%"></Column>
              <Column field="user_referent.name" header="Expert" sortable style="width: 25%"></Column>
              <Column field="user_referent.name" header="Expert" sortable style="width: 25%"></Column>
              <Column field="tenant" header="Locataire" sortable style="width: 25%">
                <template #body="slotProps">
                  <span>{{ slotProps.data.tenant.last_name  }}</span>
                  <span>{{  slotProps.data.tenant.name }}</span>
                </template>
              </Column>

              <template #footer>
                <td>
                    <label class="text-white bg-gradient-to-r from-indigo-500 via-blue-900 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    for="reference">
                    Page {{ inventories.current_page }} of {{ inventories.last_page }}
                    </label>
                </td>
                
                <td>
                  <Link :href="inventories.prev_page_url"
                  class="text-white bg-gradient-to-r from-slate-500 via-blue-900 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                  >Previous</Link>
                </td>
                
                <td>
                    <Link :href="inventories.next_page_url"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-900 to-blue-900 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                    >Next</Link>
                </td>
      
              </template>
          </DataTable>
        </div>
      </div>
    </div>
    
  </app-layout>
    
  </template>
 <script>
import DataTable from "primevue/datatable";
import Button from 'primevue/button';
import { defineComponent, ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import Column from "primevue/column";

export default defineComponent({
    components: {
        Inertia,
        AppLayout,
        Head,
        Link,
        DataTable,
        Column,
        Button,
    },    
    props: ["data"],
    data() {
      return {
            inventories: this.data,
            test:"Bonjour",
            filters: reactive({
                global: {
                    value: "",
                    matchMode: "contains",
                },
            }),
            
        }
    }   

})
</script>