<template>
    <app-layout title="Dashboard">
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-darkone border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert"
                v-if="$page.props.flash.message"
            >
                <div class="flex">
                    <div>
                        <p class="text-sm text-white">
                            {{ $page.props.flash.message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="w-full grid grid-cols-12 gap-6" ref="contentTop">
                <div class="block col-span-8">
                    <div class="w-full bg-darkone px-6 py-4">
                        <h2
                            class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                        >
                            EDL
                            <span
                                class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                            >
                                Informations générales</span
                            >
                        </h2>
                    </div>
                    <div
                        class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                    >
                        <div class="w-full p-12">
                            <form
                                @submit.prevent="submit"
                                class="grid grid-cols-1 gap-6 max-w-md mx-auto"
                            >
                                <input
                                    class="hidden"
                                    type="text"
                                    id="inventory_id"
                                    v-model="form.inventory_id"
                                />
                                <!-- Ref field -->
                                <div class="field flex flex-col mb-3">
                                    <label
                                        for="reference"
                                        class="font-semibold text-sm"
                                        >Référence</label
                                    >
                                    <InputText
                                        id="reference"
                                        type="text"
                                        v-model="form.reference"
                                        aria-describedby="reference-help"
                                    />
                                    <small
                                        id="reference-help"
                                        class="w-full flex justify-end text-gray-500"
                                        >La référence doit être unique</small
                                    >
                                    <div
                                        v-if="errors.reference"
                                        class="text-red-500"
                                    >
                                        {{ errors.reference }}
                                    </div>
                                </div>

                                <!-- Type field -->
                                <div class="field flex flex-col mb-3">
                                    <label class="font-semibold mb-3 text-sm"
                                        >Type d'état des lieux</label
                                    >
                                    <div
                                        class="flex flex-row items-center mb-3"
                                    >
                                        <RadioButton
                                            name="type"
                                            id="entry"
                                            :value="1"
                                            v-model="form.type"
                                        />
                                        <label class="ml-2" for="entry">
                                            Entrée
                                        </label>
                                    </div>
                                    <div class="flex flex-row items-center">
                                        <RadioButton
                                            name="type"
                                            id="exit"
                                            :value="2"
                                            v-model="form.type"
                                        />
                                        <label class="ml-2" for="exit">
                                            Sortie
                                        </label>
                                    </div>
                                </div>

                                <!-- Ref field -->
                                <div class="field flex flex-col mb-6">
                                    <label
                                        for="agency"
                                        class="font-semibold text-sm"
                                        >Sélectionnez l'agence :</label
                                    >
                                    <div
                                        class="flex flex-row items-center mb-2"
                                    >
                                        <RadioButton
                                            name="agency"
                                            id="ravezies"
                                            :value="'ravezies'"
                                            v-model="form.agency"
                                        />
                                        <label class="ml-2" for="ravezies">
                                            RAVEZIES
                                        </label>
                                    </div>
                                    <div
                                        class="flex flex-row items-center mb-2"
                                    >
                                        <RadioButton
                                            name="agency"
                                            id="merignac"
                                            :value="'merignac'"
                                            v-model="form.agency"
                                        />
                                        <label class="ml-2" for="merignac">
                                            MERIGNAC
                                        </label>
                                    </div>
                                    <div
                                        class="flex flex-row items-center mb-2"
                                    >
                                        <RadioButton
                                            name="agency"
                                            id="talence"
                                            :value="'talence'"
                                            v-model="form.agency"
                                        />
                                        <label class="ml-2" for="talence">
                                            TALENCE
                                        </label>
                                    </div>
                                    <div
                                        v-if="errors.agency"
                                        class="text-red-500"
                                    >
                                        {{ errors.agency }}
                                    </div>
                                </div>

                                <!-- Calendar entry field -->
                                <div
                                    class="field flex flex-col mb-2"
                                    v-if="form.type === 1"
                                >
                                    <label class="text-sm font-semibold mb-1"
                                        >Date de début de bail</label
                                    >
                                    <v-date-picker
                                        v-model="form.lease_begins_at"
                                        color="gray"
                                        is-expanded
                                        class="mb-4"
                                    />
                                </div>

                                <!-- Calendar exit field -->
                                <div
                                    class="field flex flex-col mb-2"
                                    v-if="form.type === 2"
                                >
                                    <label class="text-sm font-semibold mb-1"
                                        >Date de fin de bail</label
                                    >
                                    <v-date-picker
                                        v-model="form.lease_end_at"
                                        color="gray"
                                        is-expanded
                                        class="mb-4"
                                    />
                                </div>

                                <!-- Input -->
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    <Button
                                        label="Annuler"
                                        icon="pi pi-close"
                                        iconPos="left"
                                        v-on:click="cancel"
                                        class="p-button-secondary"
                                    />
                                    <Button type="submit" label="Enregistrer" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="block col-span-4">
                    <div
                        class="w-full px-6 py-6 bg-white border border-grayone overflow-hidden"
                    >
                        <inventory-edit-resume-component :data="data">
                        </inventory-edit-resume-component>
                    </div>
                </div>
            </div>
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

import InventoryEditResumeComponent from "@/Components/InventoryEditResumeComponent.vue";

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
        InventoryEditResumeComponent,
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
            type: context.attrs.inventory.type,
            agency: context.attrs.inventory.agency,
            reference: context.attrs.inventory.reference,
            lease_end_at: context.attrs.inventory.lease_end_at,
            lease_begins_at: context.attrs.inventory.lease_begins_at,
            date_wanted: context.attrs.inventory.date_wanted,
        });

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
            console.log(day);
            return day;
        }

        function cancel() {
            Inertia.visit(route("inventories.index"));
        }
        function submit() {
            Inertia.post("/update_inventory/inventory", form);
        }

        return { form, submit, cancel, formattedDate, getDay };
    },
};
</script>
