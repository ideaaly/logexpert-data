<template>
    <app-layout title="Dashboard">
        <div class="max-w-screen-xl mx-auto" ref="contentTop">
            <div
                class="bg-white border border-t-0 border-gray-100 overflow-hidden"
            >
                <div class="bg-white x-12">
                    <DataTable
                        id="table"
                        :value="users"
                        :paginator="true"
                        class="p-datatable-lg"
                        v-model:filters="filters"
                        :rows="25"
                        dataKey="id"
                        :rowHover="true"
                        sortField="id"
                        :sortOrder="-1"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
                        currentPageReportTemplate="Liste des EDL de {first} à {last} sur {totalRecords} entrées"
                        responsiveLayout="stack"
                        breakpoint="640px"
                        ref="table"
                        @row-click="handleClick($event)"
                        @page="handleClickPage($event)"
                    >
                        <template #header>
                            <div
                                class="flex flex-column justify-between align-items-center"
                                data-v-6432df8e=""
                            >
                                <h2
                                    class="m-0 leading-none text-mainone flex flex-col text-sm font-bold"
                                >
                                    Liste des
                                    <span
                                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                                    >
                                        Utilisateurs</span
                                    >
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
                        <Column
                            field="id"
                            header="ID"
                            :sortable="true"
                        ></Column>
                        <Column field="name" header="Nom" :sortable="true">
                        </Column>

                        <Column
                            headerStyle="width:2em; padding: 2em"
                            field="if"
                            header="&nbsp;"
                            class="text-sm"
                            :sortable="false"
                        >
                            <template #body="{ data }">
                                <Link
                                    :href="
                                        route('users.edit.informations', {
                                            id: data.id,
                                        })
                                    "
                                    class="bg-white border-mainone flex align-center text-xs justify-center hover:text-white hover:bg-mainone text-mainone leading-4 font-bold py-2 px-4 rounded-lg mr-3"
                                    ><i class="pi pi-user-edit"></i
                                    >&nbsp;Editer</Link
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
import { Inertia } from "@inertiajs/inertia";
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
        Inertia,
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
            users: this.data,
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
                route("users.edit.informations", {
                    id: e.data.id,
                }),
                { method: "get" }
            );
        }
        return { formattedDate, handleClick };
    },
});
</script>
