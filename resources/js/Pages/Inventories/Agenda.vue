<template>
    <app-layout title="Dashboard">
        <template #header> Liste des états des lieux </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-12 py-12"
                >
                    <DataTable
                        :value="inventories"
                        :paginator="true"
                        class="p-datatable-customers"
                        :rows="10"
                        dataKey="id"
                        :rowHover="true"
                        :loading="loading"
                        sortField="id"
                        :sortOrder="-1"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                        responsiveLayout="scroll"
                    >
                        <Column
                            field="id"
                            header="ID"
                            :sortable="true"
                        ></Column>
                        <Column
                            field="user_id"
                            header="Demandeur"
                            :sortable="true"
                        >
                        </Column>
                        <Column
                            field="reference"
                            header="Référence de l'EDL"
                            :sortable="true"
                        ></Column>
                        <Column
                            field="type"
                            header="Type d'EDL"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <span
                                    v-if="data.type == 1"
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-green-700 rounded"
                                >
                                    EDL Entré</span
                                >
                                <span
                                    v-if="data.type == 2"
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-orange-700 rounded"
                                >
                                    EDL Sortie</span
                                >
                            </template>
                        </Column>
                        <Column
                            field="date_wanted"
                            header="Date souhaitée"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                {{ formattedDate(data.date_wanted) }}
                            </template>
                        </Column>
                        <Column field="if" header="Actions" :sortable="false">
                            <template #body="{ data }">
                                <Link
                                    :href="
                                        route('inventories.show', {
                                            id: data.id,
                                        })
                                    "
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                    >Voir</Link
                                >
                                <Link
                                    :href="
                                        route('edit.inventory', {
                                            id: data.id,
                                        })
                                    "
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4 mt-3 mb-3"
                                    >Editer</Link
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
