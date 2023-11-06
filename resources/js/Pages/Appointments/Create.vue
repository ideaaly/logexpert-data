<template>
    <app-layout title="Dashboard">
        <div class="block">
            <div class="max-w-lg mx-auto">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        {{ $page.props.inventory.reference }}
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Fixer un RDV
                        </span>
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-6 bg-white border border-grayone overflow-hidden mb-6"
                >
                    <form
                        @submit.prevent="submit"
                        class="grid grid-cols-1 gap-6"
                    >
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

                        <label class="block" for="lease_end_at">
                            <label class="block text-sm font-semibold mb-1"
                                >Date de RDV</label
                            >
                            <v-date-picker
                                v-model="form.date"
                                mode="dateTime"
                                is24hr
                                is-expanded
                                :minute-increment="5"
                                :min-date="new Date()"
                            />
                        </label>
                        <label class="block hidden" for="inventory_id">
                            <span>Hidden</span>
                            <input
                                class="mt-1 block w-full"
                                type="text"
                                id="id"
                                v-model="form.inventory_id"
                            />
                        </label>

                        <Button type="submit" label="Fixer le RDV" />
                        <span
                            class="block text-sm font-semibold mb-1 text-center"
                        ></span>
                    </form>
                </div>
            </div>

            <inventory-card-component></inventory-card-component>

            <div class="text-center">
                <div
                    class="flex flex-row mt-6 justify-center"
                    v-if="
                        $page.props.user.all_teams[0].membership.role ==
                            'admin' ||
                        $page.props.user.all_teams[0].membership.role ==
                            'manager' ||
                        $page.props.user.all_teams[0].membership.role ==
                            'expert-senior'
                    "
                >
                    <Button
                        label="Annuler cet EDL"
                        icon="pi pi-times"
                        iconPos="left"
                        v-on:click="cancel($page.props.inventory.id)"
                        class="p-button-warning"
                    />
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
import Calendar from "primevue/calendar";
import InventoryCardComponent from "@/Components/InventoryCardComponent.vue";
import Button from "primevue/button";

export default {
    components: {
        AppLayout,
        Calendar,
        InventoryCardComponent,
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
            status: 4,
            inventory_id: context.attrs.inventory.id,
        });

        function submit() {
            Inertia.post("/appointments", form);
        }
        function cancel(inventory_id) {
            Inertia.visit(
                route("cancel.inventory", {
                    id: inventory_id,
                })
            );
        }

        return { form, submit, cancel };
    },
};
</script>
