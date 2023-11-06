<template>
    <app-layout title="Dashboard">
        <template #header> États des lieux à assigner </template>

        <div class="mx-auto max-w-screen-xl">
            <div
                class="bg-white drop-shadow-2xl rounded-xl my-6 overflow-hidden"
            >
                <div class="bg-white x-12 my-6 px-4">
                    <DataTable
                        :value="inventories"
                        :paginator="true"
                        class="p-datatable-sm"
                        v-model:filters="filters"
                        :rows="50"
                        dataKey="id"
                        :rowHover="true"
                        :loading="loading"
                        sortField="id"
                        :sortOrder="-1"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                        responsiveLayout="scroll"
                    >
                        <template #header>
                            <div
                                class="w-full flex justify-between align-items-center p-4"
                            >
                                <label
                                    class="block align-center justify-center flex"
                                    for="filter"
                                >
                                    <input
                                        type="search"
                                        class="form-control relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                            header="Référence"
                            headerStyle="font-size:0.75em; text-transform:uppercase; font-weight:700;"
                            class="text-sm"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <div class="">
                                    <span
                                        class="inline-flex px-2 py-1 text-sm font-bold leading-none text-black-100 rounded"
                                    >
                                        {{ data.reference }}</span
                                    >
                                </div>
                            </template>
                        </Column>

                        <Column
                            field="type"
                            header="E/S"
                            class="text-sm"
                            headerStyle="font-size:0.75em; text-transform:uppercase; font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <div class="">
                                    <span
                                        v-if="data.type == 1"
                                        class="inline-flex px-2 py-1 text-xs font-bold leading-none text-white bg-mainone rounded"
                                    >
                                        Entrée</span
                                    >
                                    <span
                                        v-if="data.type == 2"
                                        class="inline-flex px-2 py-1 text-xs font-bold leading-none text-white bg-darkone rounded"
                                    >
                                        Sortie</span
                                    >
                                </div>
                            </template>
                        </Column>

                        <Column
                            field="propertyType.name"
                            header="Type de bien"
                            class="text-sm"
                            headerStyle="font-size:0.75em; text-transform:uppercase; font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <div class="text-center">
                                    <span
                                        v-if="data.propertyType"
                                        class="inline-flex px-2 py-1 text-xs font-bold leading-none text-darkone bg-white shadow rounded"
                                    >
                                        {{ data.propertyType.name }}</span
                                    >
                                </div>
                            </template>
                        </Column>

                        <Column
                            field="property.city"
                            header="Ville"
                            class="text-sm"
                            headerStyle="font-size:0.75em; text-transform:uppercase; font-weight:700;"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <div class="">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-normal leading-none text-black-100 rounded"
                                    >
                                        {{ data.property.city }}</span
                                    >
                                </div>
                            </template>
                        </Column>

                        <Column
                            field="date_wanted"
                            header="Date souhaitée"
                            headerStyle="font-size:0.75em; text-transform:uppercase; font-weight:700;"
                            class="text-sm"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <span class="text-xs">
                                    {{ formattedDate(data.date_wanted) }}
                                </span>
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
                                    >&nbsp; Affecter →</Link
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

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Link,
        DataTable,
        Column,
        ColumnGroup,
        Row,
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
        return { formattedDate };
    },
});
</script>
