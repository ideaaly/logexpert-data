<template>
    <app-layout title="Dashboard">
        <div class="block">
            <div class="max-w-lg mx-auto mb-12">
                <div class="w-full bg-darkone p-6">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        Rendez-vous
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Modification de RDV pour l'EDL
                            {{ $page.props.inventory.reference }}</span
                        >
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                >
                    <form @submit.prevent="submit" class="">
                        <input
                            class="hidden"
                            type="text"
                            id="inventory_id"
                            v-model="form.inventory_id"
                        />
                        <label class="hidden" for="status">
                            <span>Status</span>
                            <input
                                class="mt-1 block w-full"
                                type="text"
                                id="status"
                                v-model="form.status"
                            />
                            <div v-if="errors.status" class="text-red-500">
                                {{ errors.status }}
                            </div>
                        </label>
                        <label class="hidden" for="status">
                            <span>appt_id</span>
                            <input
                                class="mt-1 block w-full"
                                type="text"
                                id="appt_id"
                                v-model="form.appt_id"
                            />
                        </label>
                        <label  for="status">
                            <span>g_event_id</span>
                            <input
                                class="mt-1 block w-full"
                                type="text"
                                id="g_event_id"
                                v-model="form.g_event_id"
                            />
                        </label>

                        <!-- Calendar field -->
                        <div class="field flex flex-col mb-2">
                            <label class="text-sm font-semibold mb-1"
                                >Date de rendez-vous</label
                            >
                            <v-date-picker
                                v-model="form.date"
                                color="gray"
                                is-expanded
                                is24hr
                                mode="dateTime"
                                :minute-increment="5"
                                :min-date="new Date()"
                                class="mb-4"
                            />
                        </div>

                        <!-- Input -->
                        <div class="grid grid-cols-2 gap-2 mt-6">
                            <Button
                                label="Annuler"
                                icon="pi pi-close"
                                iconPos="left"
                                v-on:click="cancel"
                                class="p-button-secondary"
                            />
                            <Button type="submit" label="Modifier le RDV" />
                        </div>
                        <span
                            class="block text-sm font-semibold mb-1 text-center mt-4"
                            >Une notification va être envoyée au Locataire</span
                        >
                    </form>
                </div>
            </div>

            <inventory-card-component></inventory-card-component>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { format } from "date-fns";
import { Head, Link } from "@inertiajs/inertia-vue3";
import InventoryCardComponent from "@/Components/InventoryCardComponent.vue";

// Form
import Calendar from "primevue/calendar";
import RadioButton from "primevue/radiobutton";
import InputText from "primevue/inputtext";
import Button from "primevue/button";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        InventoryCardComponent,
        Calendar,
        RadioButton,
        InputText,
        Button,
    },
    props: {
        errors: Object,
    },

    data() {
        return {
            form: {},
        };
    },
    setup(props, context) {
        const form = reactive({
            inventory_id: context.attrs.inventory_id,
            appt_id: context.attrs.inventory.appointment.id,
            g_event_id: context.attrs.inventory.appointment.g_event_id,
            user_referent_id: context.attrs.user_referent_id,
            date: context.attrs.inventory.appointment.date,
            status: "4",
        });

        function submit() {
            // Inertia.post("/update_inventory/userref/", form);
            Inertia.post(route("update.inventappt", form));
        }
        function cancel() {
            Inertia.visit(route("list.expert.todo"));
        }

        return { form, submit, cancel };
    },
};
</script>
