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
            class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-4"
            ref="contentTop"
        >
            <div class="block mb-6">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-6 md:leading-4 flex flex-col text-sm font-bold"
                    >
                        Stats
                        <span
                            class="text-white mt-1 leading-6 md:leading-4 flex flex-col text-xl font-black"
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
                            <span v-if="inventoryFiltered[0].status == 3">
                                <Link
                                    class="status-badge dash red"
                                    :href="route('list.expert.assigned')"
                                >
                                    En attente de RDV
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 4">
                                <Link
                                    class="status-badge dash blue"
                                    :href="route('list.expert.todo')"
                                >
                                    À réaliser
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 5">
                                <Link
                                    class="status-badge dash green"
                                    :href="route('list.expert.finished')"
                                >
                                    Terminés
                                </Link>
                            </span>
                            <span v-if="inventoryFiltered[0].status == 99">
                                <span class="status-badge dash green">
                                    Archivés
                                </span>
                            </span>

                            <span class="font-bold mr-2 text-gray-500 text-sm">
                                {{ inventoryFiltered.length }} EDL
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="block mb-6 col-span-2">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-6 md:leading-4 flex flex-col text-sm font-bold"
                    >
                        {{ $page.props.user.name }}
                        <span
                            class="text-white mt-1 leading-6 md:leading-4 flex flex-col text-xl font-black"
                        >
                            Informations importantes pour la prise de
                            rendez-vous</span
                        >
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                >
                    <div class="mb-3">
                        <h4 class="text-lg font-bold mb-1 text-mainone">
                            Délai de prise de rendez-vous
                        </h4>
                        <p class="mb-6 text-sm text-darkone_dark">
                            Pour une gestion optimale des planning veuillez svp
                            prendre RDV le plus rapidement.<br />
                            <strong>> Le délai recommandé est de 48H</strong>.
                        </p>
                        <hr class="mb-6" />
                        <h4 class="text-lg font-bold mb-1 text-mainone">
                            État des lieux d’entrée
                        </h4>
                        <p class="mb-6 text-sm text-darkone_dark">
                            Lorsque vous fixez un RDV pour une entrée, la date
                            communiquée par l’agence (<u>date souhaitée</u>) est
                            la date de début de bail. Si vous ne pouvez pas
                            fixer le RDV à la date souhaitée (demande du
                            locataire…).<br />
                            <strong>
                                > Il faut expliquer au locataire que son bail
                                commence le jour de la date souhaitée, et nous
                                prévenir par email à contact@logexpert33.com et
                                lmigliore@nexity.fr
                            </strong>
                        </p>
                        <hr class="mb-6" />
                        <h4 class="text-lg font-bold mb-1 text-mainone">
                            État des lieux de sortie
                        </h4>
                        <p class="mb-6 text-sm text-darkone_dark">
                            Lorsque vous fixez un RDV pour une sortie,
                            <u>la date de fin de bail</u> est affichée au-dessus
                            des informations locataires. Si vous ne pouvez pas
                            fixer le RDV la date souhaitée (demande du
                            locataire…).<br />
                            <strong>
                                > Il ne faut donc pas dépasser la date de fin de
                                bail et nous prévenir par email à
                                contact@logexpert33.com et lmigliore@nexity.fr.
                            </strong>
                        </p>
                    </div>
                    <hr class="mb-6" />
                    <div class="text-center mb-2">
                        <Button
                            label="Fixer mes rendez-vous"
                            icon="pi pi-plus-circle"
                            iconPos="left"
                            v-on:click="list"
                            class="p-button-primary"
                        />
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
        function list() {
            Inertia.visit(route("list.expert.assigned"));
        }

        return { list };
    },
});
</script>
