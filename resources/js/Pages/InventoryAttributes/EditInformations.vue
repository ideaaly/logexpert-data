<template>
    <app-layout title="Dashboard">
        <!-- <template #header>
            <Link
                class="font-semibold text-sm text-gray-400 leading-tight"
                :href="
                    route('edit.inventory', {
                        id: $page.props.inventory_id,
                    })
                "
            >
                1. Informations sur l'EDL
            </Link>
            <span class="mr-3 ml-3">></span>
            <Link
                class="font-semibold text-sm text-gray-800 leading-tight"
                :href="
                    route('edit.property', {
                        id: $page.props.inventory_id,
                    })
                "
            >
                2. Informations sur le logement
            </Link>
            <span class="mr-3 ml-3">></span>
            <Link
                class="font-semibold text-sm text-gray-400 leading-tight"
                :href="
                    route('edit.tenant', {
                        id: $page.props.inventory_id,
                    })
                "
            >
                3. Informations sur le locataire
            </Link>
            <span class="mr-3 ml-3">></span>
            <Link
                class="font-semibold text-sm text-gray-400 leading-tight"
                :href="
                    route('edit.informations', {
                        id: $page.props.inventory_id,
                    })
                "
            >
                4. Autres informations
            </Link>
        </template> -->
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
                                Informations sur le logement</span
                            >
                        </h2>
                    </div>
                    <!-- content -->
                    <div
                        class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                    >
                        <div class="w-full px-12 py-6 max-w-2xl mx-auto">
                            <form
                                @submit.prevent="submit"
                                class="max-w-md mx-auto grid grid-cols-1 gap-6"
                            >
                                <input
                                    class="hidden"
                                    type="text"
                                    id="inventory_id"
                                    v-model="form.inventory_id"
                                />

                                <!-- Calendar entry field -->
                                <div class="field flex flex-col mb-2">
                                    <label class="text-sm font-semibold mb-1"
                                        >Date souhaitée</label
                                    >
                                    <v-date-picker
                                        v-model="form.date_wanted"
                                        color="gray"
                                        is-expanded
                                        class="mb-4"
                                    />
                                </div>

                                <!-- Period field -->
                                <div class="field flex flex-col mb-3">
                                    <label class="font-semibold mb-3 text-sm"
                                        >Horaire souhaitée</label
                                    >
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="flex flex-row items-center">
                                            <RadioButton
                                                name="period_wanted"
                                                id="morning"
                                                :value="1"
                                                v-model="form.period_wanted"
                                            />
                                            <label class="ml-2" for="morning">
                                                Matin
                                            </label>
                                        </div>
                                        <div class="flex flex-row items-center">
                                            <RadioButton
                                                name="period_wanted"
                                                id="afternoon"
                                                :value="2"
                                                v-model="form.period_wanted"
                                            />
                                            <label class="ml-2" for="afternoon">
                                                Après-midi
                                            </label>
                                        </div>
                                        <div class="flex flex-row items-center">
                                            <RadioButton
                                                name="period_wanted"
                                                id="evening"
                                                :value="3"
                                                v-model="form.period_wanted"
                                            />
                                            <label class="ml-2" for="evening">
                                                Soirée
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Key note field -->
                                <div class="field flex flex-col mb-3">
                                    <label
                                        for="reference"
                                        class="font-semibold text-sm"
                                        >Récupération / dépôt des clés</label
                                    >
                                    <InputText
                                        id="key_notes"
                                        type="text"
                                        v-model="form.key_notes"
                                        aria-describedby="reference-help"
                                    />
                                    <div
                                        v-if="errors.key_notes"
                                        class="text-red-500"
                                    >
                                        {{ errors.key_notes }}
                                    </div>
                                </div>

                                <!-- Input -->
                                <div
                                    v-if="
                                        $page.props.inventory.status == 0 ||
                                        $page.props.inventory.status == 1 ||
                                        $page.props.inventory.status == 99
                                    "
                                >
                                    <div class="grid grid-cols-2 gap-6 mt-6">
                                        <div
                                            class="flex flex-end items-center justify-end"
                                        >
                                            <Button
                                                label="Enregistrer en brouillon"
                                                icon="pi pi-save"
                                                iconPos="left"
                                                v-on:click="save"
                                                class="p-button-text p-button-secondary"
                                            />
                                        </div>
                                        <div>
                                            <Button
                                                type="submit"
                                                class="p-button-lg"
                                                icon="pi pi-arrow-right"
                                                iconPos="right"
                                                label="Commander"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div>
                                        <Button
                                            v-on:click="update"
                                            class="p-button-lg"
                                            icon="pi pi-save"
                                            iconPos="right"
                                            label="Mettre à jour"
                                        />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="block col-span-4">
                    <div class="mb-6 flex justify-end">
                        <Button
                            label="Retour à la liste"
                            icon="pi pi-sign-out"
                            icon-pos="right"
                            class="p-button-text"
                            v-on:click="goList"
                        />
                    </div>
                    <div
                        class="sticky top-52px w-full px-6 py-6 bg-white border border-grayone overflow-hidden"
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

import Message from "primevue/message";

// Form
import AutoComplete from "primevue/autocomplete";
import Calendar from "primevue/calendar";
import RadioButton from "primevue/radiobutton";
import InputText from "primevue/inputtext";
import Button from "primevue/button";

import { useToast } from "vue-toastification";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        InventoryEditResumeComponent,
        Message,
        AutoComplete,
        Calendar,
        RadioButton,
        InputText,
        Button,
        useToast,
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
            key_notes: context.attrs.inventory.key_notes,
            date_wanted: formattedDate(context.attrs.inventory.date_wanted),
            period_wanted: context.attrs.inventory.period_wanted,
        });

        function formattedDate(date) {
            if (
                date != "" ||
                date != null ||
                date != "0000-00-00 00:00:00" ||
                date != "1900-01-01 00:00:00"
            ) {
                // return format(new Date(date), "dd/MM/yyyy");
                return date;
            } else {
                return "-";
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

        function submit() {
            Inertia.post("/update_inventory/informations", form);
        }
        function save() {
            Inertia.post("/update_inventory/informations-draft", form);
        }
        function update() {
            Inertia.post("/update_inventory/informations-after", form);
        }

        function goList() {
            Inertia.visit(route("inventories.index"));
        }

        // Get toast interface
        const toast = useToast();

        // // Use it!
        // toast("I'm a toast!");
        console.log(context.attrs.flash.message);
        if (context.attrs.flash.message) {
            // or with options
            toast.success(context.attrs.flash.message, {
                timeout: 2000,
            });
            // These options will override the options defined in the "app.use" plugin registration for this specific toast
        }

        return {
            form,
            submit,
            goList,
            formattedDate,
            getDay,
            save,
            update,
            toast,
        };
    },
};
</script>
