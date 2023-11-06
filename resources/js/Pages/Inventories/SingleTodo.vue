<template>
    <app-layout title="Dashboard">
        <div
            class="w-full py-6 px-4 flex-col md:flex-row flex justify-between mx-auto max-w-7xl"
        >
            <Link
                :href="route('list.expert.todo')"
                class="text-darkone hover:text-mainone hover:border-mainone font-bold py-2 px-4 rounded-lg"
            >
                « Retour</Link
            >
        </div>

        <inventory-card-component></inventory-card-component>

        <div class="flex flex-col md:flex-row mt-6 justify-center gap-6">
            <Button
                label="Modifier l'heure du RDV"
                icon="pi pi-calendar-times"
                iconPos="left"
                v-on:click="edit($page.props.inventory.id)"
            />
            <Button
                label="Annuler cet EDL"
                icon="pi pi-times"
                iconPos="left"
                v-on:click="cancel($page.props.inventory.id)"
                class="p-button-warning"
            />
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { format } from "date-fns";
import InventoryCardComponent from "@/Components/InventoryCardComponent.vue";

import Button from "primevue/button";

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Link,
        format,
        Button,
        InventoryCardComponent,
    },
    props: ["data", "errors"],
    data() {
        return {};
    },
    setup(context) {
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00" ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
            } else {
                return format(new Date(date), "dd/MM/yyyy");
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

            var dayNumber = new Date(date).getDay();
            var day = days[dayNumber];
            return day;
        }
        function cancel(inventory_id) {
            Inertia.visit(
                route("cancel.inventory", {
                    id: inventory_id,
                })
            );
        }
        function edit(inventory_id) {
            Inertia.visit(
                route("edit.inventappt", {
                    id: inventory_id,
                })
            );
        }

        return { formattedDate, getDay, cancel, edit };
    },
});
</script>
