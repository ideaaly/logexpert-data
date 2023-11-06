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
                            Annulation d'un EDL
                        </span>
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-6 bg-white border border-grayone overflow-hidden mb-6"
                >
                    <span class="block mb-3 text-sm">
                        Vous êtes sur le point d'annuler un EDL.Des
                        notifications seront envoyées <br />
                        à <strong>l'administrateur</strong>et au
                        <strong>locataire</strong>.
                    </span>
                    <form @submit.prevent="submit" class="grid">
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
                            <Textarea
                                id="inputtext-right"
                                v-model="form.reason"
                                rows="5"
                                class="w-full"
                            />

                            <label for="inputtext-right"
                                >Raison de l'annulation</label
                            >
                        </span>
                        <Button
                            type="submit"
                            label="Annuler l'état des lieux"
                        />
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
import Textarea from "primevue/textarea";
export default {
    components: {
        AppLayout,
        Head,
        Link,
        InventoryCardComponent,
        Button,
        InputNumber,
        InputText,
        Textarea,
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
            reason: "",
            expense_travel: 0,
            status: "99", // Annulé,
        });

        function submit() {
            Inertia.post(route("update.inventory.cancelled", form));
        }

        return { form, submit };
    },
};
</script>
