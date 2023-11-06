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
                            Archivage d'un EDL
                        </span>
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-6 bg-white border border-grayone overflow-hidden"
                >
                    <span class="block mb-3 text-sm">
                        Vous êtes sur le point d'archiver un EDL. Continuer ?
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

                        <Button type="submit" label="Archiver cet EDL" />
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
            status: "100", // Archivé,
        });

        function submit() {
            Inertia.post(route("update.inventory.archived", form));
        }

        return { form, submit };
    },
};
</script>
