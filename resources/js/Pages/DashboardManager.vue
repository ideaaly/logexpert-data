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

        <div
            class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-4 mb-6"
            ref="contentTop"
        >
            <div class="block mb-6 col-span-2">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        Dashboard
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Manager</span
                        >
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                >
                    <span class="block mb-3">
                        Créez un nouvel état des lieux sur votre interface
                        LogExpert. Vous recevrez un e-mail de confirmation à la
                        commande de votre état des lieux.
                    </span>

                    <Button
                        label="Créer un état des lieux"
                        icon="pi pi-plus-circle"
                        iconPos="left"
                        v-on:click="create"
                        class="p-button-primary"
                    />
                </div>
            </div>

            <div class="block mb-6">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        Stats
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Statistique des états des lieux</span
                        >
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                >
                    <div v-for="inventoryFiltered in inventoriesByStatus">
                        <p
                            class="block mb-6 p-0 border border-gray-100 navDiv flex items-center"
                            v-if="inventoryFiltered[0]"
                        >
                            <span v-if="inventoryFiltered[0].status == 0">
                                <Link
                                    class="status-badge dash gray"
                                    :href="route('list.draft.inventories')"
                                >
                                    Brouillons
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 1">
                                <Link
                                    class="status-badge dash yellow"
                                    :href="route('list.ordered.inventories')"
                                >
                                    À confirmer
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 2">
                                <Link
                                    class="status-badge dash purple"
                                    :href="route('list.confirmed.inventories')"
                                >
                                    À assigner
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 3">
                                <Link
                                    class="status-badge dash red"
                                    :href="route('list.assigned.inventories')"
                                >
                                    En attente de RDV
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 4">
                                <Link
                                    class="status-badge dash blue"
                                    :href="route('list.todo.inventories')"
                                >
                                    À réaliser
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 5">
                                <Link
                                    class="status-badge dash green"
                                    :href="route('list.finished.inventories')"
                                >
                                    Terminés
                                </Link>
                            </span>

                            <span
                                class="status-badge dash black"
                                v-if="inventoryFiltered[0].status == 99"
                            >
                                Annulé
                            </span>

                            <span
                                class="status-badge dash black"
                                v-if="inventoryFiltered[0].status == 100"
                            >
                                Archivés
                            </span>
                            <span class="font-bold mr-2 text-gray-500 text-sm">
                                {{ inventoryFiltered.length }} EDL
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Button from "primevue/button";
export default defineComponent({
    components: {
        AppLayout,
        JetNavLink,
        JetResponsiveNavLink,
        Head,
        Link,
        Button,
    },
    props: ["data", "errors", "inventoriesByStatus"],
    data() {
        return {};
    },
    setup() {
        function create() {
            Inertia.visit(route("inventories.create"));
        }

        return { create };
    },
});
</script>
