<template>
    <app-layout title="Dashboard">
        <div class="block">
            <div class="max-w-lg mx-auto mb-12">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        {{ $page.props.inventory.reference }}
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Frais de déplacement & Confirmation
                        </span>
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-6 bg-white border border-grayone overflow-hidden"
                >
                    <form
                        @submit.prevent="submit"
                        class="flex flex-row gap-6 items-end"
                    >
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
                        </label>

                        <span class="p-float-label p-input-icon-right mt-4">
                            <i class="pi pi-euro" />
                            <InputText
                                id="inputtext-right"
                                type="text"
                                v-model="form.expense_travel"
                            />
                            <label for="inputtext-right"
                                >Frais de déplacement</label
                            >
                        </span>
                        <button
                            type="submit"
                            class="gradientMain-fast w-full py-3 px-6 text-lg leading-4 text-white rounded-lg font-bold hover:text-black hover:border-mainone"
                        >
                            <i class="pi pi-check"></i>&nbsp;Confirmer
                        </button>
                        <div v-if="errors.expense_travel" class="text-red-500">
                            {{ errors.expense_travel }}
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
import Button from "primevue/button";
import InputNumber from "primevue/inputnumber";
import InputText from "primevue/inputtext";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        InventoryCardComponent,
        Button,
        InputNumber,
        InputText,
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
            expense_travel: 0,
            status: "2", // Confirmé,
        });

        function submit() {
            Inertia.post(route("update.inventory.confirm", form));
        }

        return { form, submit };
    },
};
</script>
