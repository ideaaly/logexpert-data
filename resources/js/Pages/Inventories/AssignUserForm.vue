<template>
    <app-layout title="Dashboard">
        <div class="block">
            <div class="max-w-lg mx-auto mb-12">
                <div class="w-full bg-darkone p-6">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        Répartition
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Assigner un expert à l'EDL
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
                        <div class="grid grid-cols-1">
                            <div class="grid grid-cols-1 gap-0">
                                <div
                                    class="flex flex-row items-center"
                                    v-for="expert in $page.props.experts"
                                    :key="expert.id"
                                >
                                    <div
                                        v-if="
                                            (expert.teams &&
                                                expert.teams[0].membership
                                                    .role == 'expert-senior') ||
                                            (expert.teams &&
                                                expert.teams[0].membership
                                                    .role == 'admin')
                                        "
                                    >
                                        <div class="mb-4">
                                            <RadioButton
                                                name="user_referent_id"
                                                :id="'expert' + expert.id"
                                                :value="expert.id"
                                                v-model="form.user_referent_id"
                                            />
                                            <label
                                                class="ml-2"
                                                :for="'expert' + expert.id"
                                            >
                                                {{ expert.name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <Button
                                type="submit"
                                label="Affecter cet utilisateur"
                            />
                        </div>
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
            user_referent_id: context.attrs.user_referent_id,
            // experts: context.attrs.experts,
            status: "3",
        });

        function submit() {
            // Inertia.post("/update_inventory/userref/", form);
            Inertia.post(route("update.userref", form));
        }
        function cancel() {
            Inertia.visit(route("assign.list"));
        }

        return { form, submit, cancel };
    },
};
</script>
