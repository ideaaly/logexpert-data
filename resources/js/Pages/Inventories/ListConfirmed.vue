<template>
    <app-layout title="Dashboard">
        <div class="mx-auto">
            <div class="w-full p-6" v-if="$page.props.flash.message">
                <Message
                    severity="success"
                    :closable="false"
                    :class="'col-span-3'"
                    >{{ $page.props.flash.message }}</Message
                >
            </div>
            <div
                class="bg-white border border-t-0 border-gray-100 overflow-hidden"
            >
                <div class="bg-white x-12">
                    <DataTable
                        id="table"
                        :value="inventories"
                        :paginator="true"
                        class="p-datatable-lg"
                        v-model:filters="filters"
                        :rows="50"
                        dataKey="id"
                        :rowHover="true"
                        sortField="id"
                        :sortOrder="-1"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
                        currentPageReportTemplate="Liste des EDL de {first} à {last} sur {totalRecords} entrées"
                        responsiveLayout="scroll"
                        breakpoint="640px"
                        ref="uniqueName"
                        @row-click="handleClick($event)"
                    >
                        <template #header>
                            <div
                                class="flex flex-column justify-between align-items-center"
                                data-v-6432df8e=""
                            >
                                <h2
                                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                                >
                                    États des lieux
                                    <span
                                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                                    >
                                        À affecter</span
                                    >
                                </h2>
                                <label
                                    class="block align-center justify-center flex"
                                    for="filter"
                                >
                                    <input
                                        type="search"
                                        class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-sm font-normal text-gray-700 bg-white rounded-full transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        placeholder="Rechercher"
                                        aria-label="Rechercher"
                                        aria-describedby="button-addon2"
                                        v-model="filters['global'].value"
                                    />
                                </label>
                            </div>
                        </template>
                        <Column
                            field="id"
                            class="hidden"
                            header="ID"
                            :sortable="true"
                        ></Column>
                        <Column
                            field="user_id"
                            header="Demandeur"
                            class="hidden"
                            :sortable="true"
                        >
                        </Column>
                        <Column
                            field="reference"
                            header="Réf."
                            headerStyle=" font-weight:700;"
                            class="text-sm"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-reference-component
                                    :data="data"
                                ></inventory-list-reference-component>
                            </template>
                        </Column>

                        <Column
                            field="status"
                            class="text-sm status-row"
                            header="Status"
                            headerStyle=" font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-status-component
                                    :data="data"
                                ></inventory-list-status-component>
                            </template>
                        </Column>

                        <Column
                            field="type"
                            header="Type"
                            class="text-sm"
                            headerStyle=" font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-type-component
                                    :data="data"
                                ></inventory-list-type-component>
                            </template>
                        </Column>

                        <Column
                            field="propertyType.name"
                            header="Logement"
                            class="text-sm"
                            headerStyle=" font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-property-type-component
                                    :data="data"
                                >
                                </inventory-list-property-type-component>
                            </template>
                        </Column>

                        <Column
                            field="property.city"
                            header="Ville"
                            class="text-sm"
                            headerStyle=" font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-property-city-component
                                    :data="data"
                                >
                                </inventory-list-property-city-component>
                            </template>
                        </Column>

                        <Column
                            field="date_wanted"
                            header="Date"
                            headerStyle=" font-weight:700;"
                            class="text-sm"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <inventory-list-date-wanted-component
                                    :data="data"
                                >
                                </inventory-list-date-wanted-component>
                            </template>
                        </Column>

                        <Column field="if" header="Actions" :sortable="false">
                            <template #body="{ data }">
                                <Link
                                    :href="
                                        route('assign.userref', {
                                            id: data.id,
                                        })
                                    "
                                    class="bg-white border-mainone flex align-center text-xs justify-center hover:text-white hover:bg-mainone text-mainone leading-4 font-bold py-2 px-4 pt-3 rounded-lg mr-3"
                                >
                                    <span class="block">
                                        <i class="pi pi-link"></i> </span
                                    >&nbsp; Affecter</Link
                                >
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

// Datatable
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; //optional for column grouping
import Row from "primevue/row"; //optional for row
import { FilterMatchMode } from "primevue/api";
import { format } from "date-fns";

import Message from "primevue/message";

import InventoryListReferenceComponent from "@/Components/InventoryListReferenceComponent.vue";
import InventoryListStatusComponent from "@/Components/InventoryListStatusComponent.vue";
import InventoryListTypeComponent from "@/Components/InventoryListTypeComponent.vue";
import InventoryListPropertyTypeComponent from "@/Components/InventoryListPropertyTypeComponent.vue";
import InventoryListPropertyCityComponent from "@/Components/InventoryListPropertyCityComponent.vue";
import InventoryListExpertComponent from "@/Components/InventoryListExpertComponent.vue";
import InventoryListDateWantedComponent from "@/Components/InventoryListDateWantedComponent.vue";

export default defineComponent({
    components: {
        AppLayout,
        Inertia,
        Head,
        Link,
        DataTable,
        Column,
        ColumnGroup,
        Row,
        Message,

        InventoryListReferenceComponent,
        InventoryListStatusComponent,
        InventoryListTypeComponent,
        InventoryListPropertyTypeComponent,
        InventoryListPropertyCityComponent,
        InventoryListExpertComponent,
        InventoryListDateWantedComponent,
    },

    props: ["data", "errors"],
    data() {
        return {
            inventories: this.data,

            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            },
        };
    },
    setup() {
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00"
            ) {
                return "-";
            } else {
                return format(new Date(date), "dd/MM/yyyy");
            }
        }
        function handleClick(e) {
            Inertia.visit(
                route("assign.userref", {
                    id: e.data.id,
                }),
                { method: "get" }
            );
        }
        return { formattedDate, handleClick };
    },
});
</script>
