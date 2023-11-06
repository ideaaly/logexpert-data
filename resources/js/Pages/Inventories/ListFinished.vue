<template>
    <app-layout title="Dashboard">
        <div class="mx-auto">
            <div
                class="mb-6"
                v-if="$page.props.user.all_teams[0].membership.role == 'admin'"
            >
                <Button
                    label="Basculer en terminer"
                    icon="pi pi-times"
                    iconPos="left"
                    v-on:click="finished()"
                    class="p-button-warning"
                />
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
                                        Réalisés</span
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
                            header="Date souhaitée"
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

                        <Column
                            field="appointment.date"
                            header="Date de RDV"
                            headerStyle=" font-weight:700;"
                            class="text-sm"
                            sortable
                            dataType="date"
                        >
                            <template #body="{ data }">
                                {{ formattedDateTime(data.appointment_date) }}
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
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
import { FilterMatchMode, FilterOperator } from "primevue/api";
import { format } from "date-fns";
import Calendar from "primevue/calendar";
import MultiSelect from "primevue/multiselect";
import Message from "primevue/message";

import InventoryListReferenceComponent from "@/Components/InventoryListReferenceComponent.vue";
import InventoryListStatusComponent from "@/Components/InventoryListStatusComponent.vue";
import InventoryListTypeComponent from "@/Components/InventoryListTypeComponent.vue";
import InventoryListPropertyTypeComponent from "@/Components/InventoryListPropertyTypeComponent.vue";
import InventoryListPropertyCityComponent from "@/Components/InventoryListPropertyCityComponent.vue";
import InventoryListExpertComponent from "@/Components/InventoryListExpertComponent.vue";
import InventoryListDateWantedComponent from "@/Components/InventoryListDateWantedComponent.vue";

import Button from "primevue/button";
import { useToast } from "vue-toastification";

export default defineComponent({
    components: {
        Inertia,
        AppLayout,
        Head,
        Link,
        DataTable,
        Column,
        ColumnGroup,
        Row,
        FilterMatchMode,
        FilterOperator,
        format,
        Button,
        Calendar,
        MultiSelect,
        Message,
        InventoryListReferenceComponent,
        InventoryListStatusComponent,
        InventoryListTypeComponent,
        InventoryListPropertyTypeComponent,
        InventoryListPropertyCityComponent,
        InventoryListExpertComponent,
        InventoryListDateWantedComponent,
        useToast,
    },

    props: ["data", "errors"],
    data() {
        return {
            inventories: this.data,

            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                "user_referent.name": {
                    value: null,
                    matchMode: FilterMatchMode.CONTAINS,
                },

                date_wanted: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.DATE_IS },
                    ],
                },
                "appointment.date": {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.DATE_IS },
                    ],
                },
            },
        };
    },

    mounted() {
        this.inventories.forEach(
            (inventories) =>
                (inventories.appointment.date = new Date(
                    inventories.appointment.date
                ))
        );
    },
    setup(props, context) {
        function formatDate(value) {
            return value.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
        }
        function formattedDate(date) {
            if (
                date == "Invalid Date" ||
                date == "" ||
                date == null ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
            } else {
                return format(new Date(date.replace(" ", "T")), "dd/MM/yyyy");
            }
        }
        function formattedDateTime(date) {
            if (
                date == "Invalid Date" ||
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00" ||
                date == "0000-00-00" ||
                date == "1900-01-01" ||
                date == []
            ) {
                return "-";
            } else {
                return format(
                    new Date(date.replace(" ", "T")),
                    "dd/MM/yyyy à HH:mm"
                );
            }
        }
        function getDay(date) {
            var days = [
                "Dimanche",
                "Lundi",
                "Mardi",
                "Mercredi",
                "Jeudi",
                "Vendredi",
                "Samedi",
            ];

            var dayNumber = new Date(date.replace(" ", "T")).getDay();
            var day = days[dayNumber];
            return day;
        }
        function handleClick(e) {
            Inertia.visit(
                route("inventories.show", {
                    id: e.data.id,
                }),
                { method: "get" }
            );
        }
        function handleClickPage(e) {
            window.scrollTo(0, 0);
        }
        function finished() {
            Inertia.visit(route("update.inventory.finished"));
        }

        // Get toast interface
        const toast = useToast();

        // Notification Toast
        if (context.attrs.flash.message) {
            // or with options
            toast.success(context.attrs.flash.message, {
                timeout: 2000,
            });
            // These options will override the options defined in the "app.use" plugin registration for this specific toast
        }

        return {
            formattedDate,
            formattedDateTime,
            getDay,
            handleClick,
            formatDate,
            finished,
            toast,
        };
    },
});
</script>
