<template>
    <app-layout title="Dashboard">
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
                                Informations sur le locataire</span
                            >
                        </h2>
                    </div>
                    <!-- content -->
                    <div
                        class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                    >
                        <div
                            class="w-full bg-white p-6"
                            v-if="$page.props.flash.message"
                        >
                            <Message
                                severity="success"
                                :closable="false"
                                :class="'col-span-3'"
                                >{{ $page.props.flash.message }}</Message
                            >
                        </div>

                        <div class="w-full px-12 py-6 max-w-2xl mx-auto">
                            <form
                                @submit.prevent="submit"
                                class="grid grid-cols-1 gap-6"
                            >
                                <input
                                    class="hidden"
                                    type="text"
                                    id="inventory_id"
                                    v-model="form.inventory_id"
                                />

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="gender"
                                    >
                                        <span class="mt-1 block">Civilité</span>
                                        <input
                                            class="form-input"
                                            type="radio"
                                            id="mr"
                                            value="1"
                                            name="gender"
                                            v-model="form.gender"
                                            checked
                                        />
                                        <span class="ml-1">Monsieur</span>

                                        <input
                                            class="ml-4 form-input"
                                            type="radio"
                                            id="mme"
                                            value="2"
                                            name="gender"
                                            v-model="form.gender"
                                        />
                                        <span class="ml-1">Madame</span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="last_name"
                                    >
                                        <span>Nom</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="last_name"
                                            v-model="form.last_name"
                                        />
                                        <div
                                            v-if="errors.last_name"
                                            class="text-red-500"
                                        >
                                            {{ errors.last_name }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="name"
                                    >
                                        <span>Prénom</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="name"
                                            v-model="form.name"
                                        />
                                        <div
                                            v-if="errors.name"
                                            class="text-red-500"
                                        >
                                            {{ errors.name }}
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="email"
                                    >
                                        <span>E-mail</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="email"
                                            v-model="form.email"
                                        />
                                        <div
                                            v-if="errors.email"
                                            class="text-red-500"
                                        >
                                            {{ errors.email }}
                                        </div>
                                    </label>
                                    <label
                                        class="block text-xs text-gray-700 font-bold uppercase"
                                        for="phone"
                                    >
                                        <span>Téléphone</span>
                                        <input
                                            class="mt-1 block w-full rounded"
                                            type="text"
                                            id="phone"
                                            v-model="form.phone"
                                        />
                                        <div
                                            v-if="errors.phone"
                                            class="text-red-500"
                                        >
                                            {{ errors.phone }}
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
            last_name: context.attrs.tenant.last_name,
            name: context.attrs.tenant.name,
            gender: context.attrs.tenant.gender,
            email: context.attrs.tenant.email,
            phone: context.attrs.tenant.phone,
            notes: context.attrs.tenant.notes,
        });

        function submit() {
            Inertia.post("/update_tenant/inventory", form);
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

        return { form, submit, goList, toast };
    },
};
</script>
