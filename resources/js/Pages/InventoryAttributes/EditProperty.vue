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
                                class="grid grid-cols-1 gap-6"
                            >
                                <input
                                    class="hidden"
                                    type="text"
                                    name="inventory_id"
                                    id="inventory_id"
                                    v-model="form.inventory_id"
                                />

                                <div class="grid grid-cols-1">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="is_furnished"
                                        ><span class="ml-1">Type de bien</span>
                                        <select
                                            class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            aria-label="Default select example"
                                            v-model="form.property_type_id"
                                            id="property_type_id"
                                        >
                                            <option selected>
                                                Type de bien
                                            </option>
                                            <option
                                                v-for="property_type in $page
                                                    .props.property_types"
                                                :key="property_type.id"
                                                :value="property_type.id"
                                            >
                                                {{ property_type.name }}
                                            </option>
                                        </select>
                                    </label>
                                    <div
                                        v-if="errors.property_type_id"
                                        class="text-red-500"
                                    >
                                        {{ errors.property_type_id }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 hidden">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="is_furnished"
                                    >
                                        <span class="mt-1 block">Meublé ?</span>
                                        <input
                                            class="form-input"
                                            type="radio"
                                            id="furnished_false"
                                            value="0"
                                            name="is_furnished"
                                            v-model="form.is_furnished"
                                        />
                                        <span class="ml-1">Non</span>

                                        <input
                                            class="ml-4 form-input"
                                            type="radio"
                                            id="furnished_true"
                                            value="1"
                                            name="is_furnished"
                                            v-model="form.is_furnished"
                                        />
                                        <span class="ml-1">Oui</span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="address1"
                                    >
                                        <span>Adresse</span>
                                        <input
                                            class="mt-1 mb-4 block w-full rounded"
                                            type="text"
                                            id="address1"
                                            v-model="form.address1"
                                        />
                                        <div
                                            v-if="errors.address1"
                                            class="text-red-500"
                                        >
                                            {{ errors.address1 }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="address2"
                                    >
                                        <span>Complément d'adresse</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="address2"
                                            v-model="form.address2"
                                        />
                                        <div
                                            v-if="errors.address2"
                                            class="text-red-500"
                                        >
                                            {{ errors.address2 }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="zip_code"
                                    >
                                        <span>Code postal</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="zip_code"
                                            v-model="form.zip_code"
                                        />
                                        <div
                                            v-if="errors.zip_code"
                                            class="text-red-500"
                                        >
                                            {{ errors.zip_code }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="city"
                                    >
                                        <span>Ville</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="city"
                                            v-model="form.city"
                                        />
                                        <div
                                            v-if="errors.city"
                                            class="text-red-500"
                                        >
                                            {{ errors.city }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="country"
                                    >
                                        <span>Pays</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="country"
                                            v-model="form.country"
                                        />
                                        <div
                                            v-if="errors.country"
                                            class="text-red-500"
                                        >
                                            {{ errors.country }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="building_number"
                                    >
                                        <span>N° du bâtiment</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="building_number"
                                            v-model="form.building_number"
                                        />
                                        <div
                                            v-if="errors.building_number"
                                            class="text-red-500"
                                        >
                                            {{ errors.building_number }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="appt_number"
                                    >
                                        <span>N° d'appt</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="appt_number"
                                            v-model="form.appt_number"
                                        />
                                        <div
                                            v-if="errors.appt_number"
                                            class="text-red-500"
                                        >
                                            {{ errors.appt_number }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="owner_name"
                                    >
                                        <span>Nom du propriétaire</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="owner_name"
                                            v-model="form.owner_name"
                                        />
                                        <div
                                            v-if="errors.owner_name"
                                            class="text-red-500"
                                        >
                                            {{ errors.owner_name }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="year_construction"
                                    >
                                        <span>Année de construction</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="year_construction"
                                            v-model="form.year_construction"
                                        />
                                        <div
                                            v-if="errors.year_construction"
                                            class="text-red-500"
                                        >
                                            {{ errors.year_construction }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="surface"
                                    >
                                        <span>Surface (en m2)</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="surface"
                                            v-model="form.surface"
                                        />
                                        <div
                                            v-if="errors.surface"
                                            class="text-red-500"
                                        >
                                            {{ errors.surface }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="water"
                                    >
                                        <span>Étage</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="water"
                                            v-model="form.water"
                                        />
                                        <div
                                            v-if="errors.water"
                                            class="text-red-500"
                                        >
                                            {{ errors.water }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="heating"
                                    >
                                        <span>Type de chauffage </span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="heating"
                                            v-model="form.heating"
                                        />
                                        <div
                                            v-if="errors.heating"
                                            class="text-red-500"
                                        >
                                            {{ errors.heating }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="has_parking"
                                    >
                                        <span class="mt-1 block"
                                            >Possède un parking ?</span
                                        >
                                        <input
                                            class="form-input"
                                            type="radio"
                                            id="parking_false"
                                            value="0"
                                            name="has_parking"
                                            v-model="form.has_parking"
                                        />
                                        <span class="ml-1">Non</span>

                                        <input
                                            class="ml-4 form-input"
                                            type="radio"
                                            id="parking_true"
                                            value="1"
                                            name="has_parking"
                                            v-model="form.has_parking"
                                        />
                                        <span class="ml-1">Oui</span>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="parking_number"
                                        v-if="form.has_parking == '1'"
                                    >
                                        <span>Numéro Parking</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="parking_number"
                                            v-model="form.parking_number"
                                        />
                                        <div
                                            v-if="errors.parking_number"
                                            class="text-red-500"
                                        >
                                            {{ errors.parking_number }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="has_parking"
                                    >
                                        <span class="mt-1 block"
                                            >Possède une cave ?</span
                                        >
                                        <input
                                            class="form-input"
                                            type="radio"
                                            id="cellar_false"
                                            value="0"
                                            name="has_cellar"
                                            v-model="form.has_cellar"
                                        />
                                        <span class="ml-1">Non</span>

                                        <input
                                            class="ml-4 form-input"
                                            type="radio"
                                            id="cellar_true"
                                            value="1"
                                            name="has_cellar"
                                            v-model="form.has_cellar"
                                        />
                                        <span class="ml-1">Oui</span>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                                        for="parking_number"
                                        v-if="form.has_cellar == '1'"
                                    >
                                        <span>Numéro de la cave</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="cellar_number"
                                            v-model="form.cellar_number"
                                        />
                                        <div
                                            v-if="errors.parking_number"
                                            class="text-red-500"
                                        >
                                            {{ errors.cellar_number }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="notes"
                                    >
                                        <span>Notes</span>
                                        <textarea
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="notes"
                                            v-model="form.notes"
                                        />
                                        <div
                                            v-if="errors.notes"
                                            class="text-red-500"
                                        >
                                            {{ errors.notes }}
                                        </div>
                                    </label>
                                </div>
                                <button
                                    type="submit"
                                    class="bg-mainone hover:bg-darkone text-white font-bold py-2 px-4 rounded-lg"
                                >
                                    Enregistrer et continuer →
                                </button>
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import { FilterService, FilterMatchMode } from "primevue/api";
import InventoryEditResumeComponent from "@/Components/InventoryEditResumeComponent.vue";
// import { arrayBuffer } from "stream/consumers";

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
            form: {
                title: null,
                body: null,
            },
            selectedPropertyType: null,
            filteredPropertyTypes: null,

            property_types: this.$attrs.property_types,
        };
    },

    created() {
        this.propertyTypeService = this.property_types;
    },

    methods: {},
    setup(props, context) {
        const form = reactive({
            inventory_id: context.attrs.inventory_id,
            property_type_id: context.attrs.property.property_type_id,
            owner_name: context.attrs.property.owner_name,
            address1: context.attrs.property.address1,
            address2: context.attrs.property.address2,
            building_number: context.attrs.property.building_number,
            appt_number: context.attrs.property.appt_number,
            zip_code: context.attrs.property.zip_code,
            city: context.attrs.property.city,
            country: "France",
            year_construction: context.attrs.property.year_construction,
            surface: context.attrs.property.surface,
            water: context.attrs.property.water,
            heating: context.attrs.property.heating,
            is_furnished: context.attrs.property.is_furnished,
            has_parking: context.attrs.property.has_parking,
            parking_number: context.attrs.property.parking_number,
            has_cellar: context.attrs.property.has_cellar,
            cellar_number: context.attrs.property.cellar_number,
            notes: context.attrs.property.notes,
        });

        function submit() {
            Inertia.post("/update_property/inventory", form);
        }

        let propertyTypeService = null;
        function searchPropertyType(event) {
            this.filteredPropertyTypesBasic = propertyTypeService.search(
                event.query
            );
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
        return { form, submit, searchPropertyType, goList, toast };
    },
};
</script>
