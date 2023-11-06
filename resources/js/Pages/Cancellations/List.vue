<template>
    <app-layout title="Dashboard">
        <template #header> Liste des types de bien </template>

        <div class="mx-auto max-w-screen-lg border border-grayone">
            <div class="w-full bg-darkone px-6 py-4">
                <h2
                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                >
                    Admin
                    <span
                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                    >
                        Liste des annulations</span
                    >
                </h2>
            </div>
            <div class="w-full bg-white overflow-hidden">
                <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-12"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-darkone text-white"
                    >
                        <tr>
                            <th class="px-6 py-4 text-center">EDL</th>
                            <th class="px-6 py-4 text-center">
                                Date d'annulation
                            </th>
                            <th class="px-6 py-4 text-center">Annulé par</th>
                            <th class="px-6 py-4 text-left">
                                Raison de l'annulation
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in $page.props.data"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <td class="px-6 py-4 text-center">
                                {{ item.inventory.reference }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ formattedDate(item.created_at) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ item.user.name }}
                            </td>
                            <td class="px-6 py-4 text-left">
                                {{ item.reason }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

// Datatable
import { format } from "date-fns";
import { intersectionTypeAnnotation } from "@babel/types";

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Link,
    },

    props: ["data", "errors"],
    data() {
        return {
            cancellations: this.data,
            // inventories: this.inventories,
            // users: this.users,
        };
    },
    mounted() {},

    methods: {
        destroy(id) {
            Inertia.delete(route("destroy.property_type", id));
        },
    },
    setup() {
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
            } else {
                return format(new Date(date), "dd/MM/yyyy");
            }
        }

        return { formattedDate };
    },
});
</script>
