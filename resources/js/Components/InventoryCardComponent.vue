<template>
    <div
        class="grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-6 max-w-7xl mx-auto mt-6 md:mt-0"
    >
        <div class="col-span-2">
            <div
                class="grid grid-cols-1 md:grid-cols-3 border border-grayone border-b-0"
            >
                <div
                    class="block px-6 md:px-12 py-6 bg-mainone flex flex-col justify-center"
                >
                    <span
                        v-if="$page.props.inventory.type == 1"
                        class="text-2xl font-black text-white block"
                    >
                        Entrée</span
                    >
                    <span
                        v-if="$page.props.inventory.type == 2"
                        class="text-xl font-bold text-white block"
                    >
                        Sortie</span
                    >
                    <span class="text-sm text-white font-bold">
                        {{ $page.props.inventory.reference }}
                    </span>
                    <div class="font-l">
                        <span
                            v-if="$page.props.inventory.propertyType"
                            class="text-xl font-black text-black block uppercase"
                        >
                            {{ $page.props.inventory.propertyType.name }}</span
                        >
                    </div>
                </div>

                <div
                    class="col-span-2 block px-6 md:px-12 py-6 bg-white flex flex-col justify-center"
                    v-if="$page.props.inventory.appointment"
                >
                    <span class="text-xs block"> Date de RDV </span>
                    <span class="text-xl font-bold text-black block">
                        {{ getDay($page.props.inventory.appointment.date) }}
                        {{
                            formattedDateTime(
                                $page.props.inventory.appointment.date
                            )
                        }}
                    </span>
                    <span class="text-xs block"> Lien de Google event </span>
                    <span>
                        <span v-if="$page.props.appointment">{{ $page.props.appointment.g_event_id  }}</span>
                         
                    </span>
                    
                </div>
            </div>
            <div
                class="bg-white border border-grayone overflow-hidden p-4 md:p-8"
            >
                <div class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="block">
                            <p
                                class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
                            >
                                Propriétaire
                            </p>
                            <ul class="mb-4 grid grid-cols-3 gap-6">
                                <li class="mb-6">
                                    <span class="text-xs block"
                                        >Nom Prénom</span
                                    >
                                    <span class="text-l font-bold block">
                                        {{
                                            $page.props.property.owner_name
                                        }}</span
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="block col-span-2 px-0 md:px-8">
                            <p
                                class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
                            >
                                Date souhaitée
                            </p>
                            <ul class="mb-4 grid grid-cols-2 gap-6">
                                <li class="mb-6">
                                    <span class="text-xs block"> Date</span>
                                    <span class="text-l font-bold block block">
                                        {{
                                            getDay(
                                                $page.props.inventory
                                                    .date_wanted
                                            )
                                        }}
                                        {{
                                            formattedDate(
                                                $page.props.inventory
                                                    .date_wanted
                                            )
                                        }}
                                    </span>
                                </li>
                                <li class="mb-6">
                                    <span class="text-xs block"> Heure </span>

                                    <span
                                        v-if="
                                            $page.props.inventory
                                                .period_wanted == 1
                                        "
                                        class="text-l font-bold block"
                                    >
                                        Matinée</span
                                    >
                                    <span
                                        v-if="
                                            $page.props.inventory
                                                .period_wanted == 2
                                        "
                                        class="text-l font-bold block"
                                    >
                                        Après-midi</span
                                    >
                                    <span
                                        v-if="
                                            $page.props.inventory
                                                .period_wanted == 3
                                        "
                                        class="text-l font-bold block"
                                    >
                                        Soirée</span
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>

                    <ul>
                        <li class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p
                                    class="font-black text-mainone uppercase text-xl mb-1"
                                >
                                    Logement
                                </p>
                                <span class="text-xs block">Adresse</span>
                                <span class="text-l font-bold block">
                                    {{ $page.props.property.address1 }}
                                </span>
                            </div>
                            <div class="col-span-2 px-0 md:px-6">
                                <p
                                    class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
                                >
                                    Récupération / dépôt des clés
                                </p>
                                <span
                                    class="text-l font-bold block"
                                    v-if="$page.props.inventory.key_notes"
                                >
                                    {{ $page.props.inventory.key_notes }}
                                </span>
                                <span class="text-l font-bold block" v-else>
                                    -
                                </span>
                            </div>
                        </li>
                    </ul>
                    <ul
                        class="grid grid-cols-2 md:grid-cols-3 gap-x-24 gap-y-6 mt-6"
                    >
                        <li class="mt-5">
                            <span class="text-xs block"
                                >Complément d'adresse</span
                            >
                            <span class="text-l font-bold block">
                                {{ $page.props.property.address2 }}
                            </span>
                        </li>
                        <li class="mt-5">
                            <span class="text-xs block">N° Bâtiment</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.building_number }}
                            </span>
                        </li>
                        <li class="mt-5">
                            <span class="text-xs block">N° d'appt</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.appt_number }}
                            </span>
                        </li>
                        <li class="mt-5">
                            <span class="text-xs block">Code postal</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.zip_code }}
                            </span>
                        </li>
                        <li class="mt-5">
                            <span class="text-xs block">Ville</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.city }}
                            </span>
                        </li>
                        <li class="mt-5">
                            <span class="text-xs block">Pays</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.country }}
                            </span>
                        </li>
                    </ul>
                    <hr class="my-6" />
                    <ul
                        class="grid grid-cols-2 md:grid-cols-3 gap-x-24 gap-y-6"
                    >
                        <li>
                            <span class="text-xs block">
                                Année de construction
                                <span class="text-l font-bold block">
                                    {{ $page.props.property.year_construction }}
                                </span>
                            </span>
                        </li>
                        <li>
                            <span class="text-xs block">Surface</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.surface }}
                            </span>
                        </li>
                        <li>
                            <span class="text-xs block">
                                Étage
                                <span class="text-l font-bold block">
                                    {{ $page.props.property.water }}
                                </span>
                            </span>
                        </li>
                        <li>
                            <span class="text-xs block">
                                Type de chauffage
                                <span class="text-l font-bold block">
                                    {{ $page.props.property.heating }}
                                </span>
                            </span>
                        </li>

                        <li>
                            <span class="text-xs block"> Numéro Parking</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.parking_number }}
                            </span>
                        </li>

                        <li>
                            <span class="text-xs block">Numéro Cave</span>
                            <span class="text-l font-bold block">
                                {{ $page.props.property.cellar_number }}
                            </span>
                        </li>
                        <li>
                            <span class="text-xs block"
                                >Notes sur le logement</span
                            >
                            <span class="text-l font-bold block">
                                {{ $page.props.property.notes }}
                            </span>
                        </li>
                        <li>
                            <span class="text-xs block">Agence</span>
                            <span class="text-l font-bold block uppercase">
                                {{ $page.props.inventory.agency }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <div class="block px-12 py-8 bg-white flex flex-col justify-center">
                <span class="text-xs block text-center mb-2">Status</span>

                <span
                    v-if="$page.props.inventory.status == 0"
                    class="status-badge large gray"
                >
                    Brouillon</span
                >
                <span
                    v-if="$page.props.inventory.status == 1"
                    class="status-badge large yellow"
                >
                    À confirmer</span
                >
                <span
                    v-if="$page.props.inventory.status == 2"
                    class="status-badge large purple"
                >
                    Commandé</span
                >
                <span
                    v-if="$page.props.inventory.status == 3"
                    class="status-badge large red"
                >
                    En attente de RDV</span
                >
                <span
                    v-if="$page.props.inventory.status == 4"
                    class="status-badge large blue"
                >
                    À réaliser</span
                >
                <span
                    v-if="$page.props.inventory.status == 5"
                    class="status-badge large green"
                >
                    Terminé</span
                >

                <span
                    v-if="$page.props.inventory.status == 99"
                    class="status-badge large black"
                >
                    Annulé</span
                >
                <span
                    v-if="$page.props.inventory.status == 100"
                    class="status-badge large"
                >
                    <span
                        class="flex w-2 h-2 mt-1 bg-darkone rounded-full bg-gray-700 mr-2"
                    ></span>
                    Archivé</span
                >
            </div>
            <div
                class="bg-white overflow-hidden bg-white border border-grayone p-4 md:p-8"
            >
                <div
                    class=""
                    v-if="$page.props.inventory.lease_end_at != '0000-00-00'"
                >
                    <p class="font-black text-mainone uppercase text-xl mb-1">
                        Date de fin de bail
                    </p>
                    <span class="text-l font-bold block">
                        {{ formattedDate($page.props.inventory.lease_end_at) }}
                    </span>
                </div>
                <div class="mt-4">
                    <p class="font-black text-mainone uppercase text-xl mb-1">
                        Locataire
                    </p>
                    <ul>
                        <li class="mb-4">
                            <span class="text-xs block">Civilité</span>

                            <span
                                v-if="$page.props.tenant.gender == 0"
                                class="text-l font-bold block"
                            >
                                Monsieur</span
                            >
                            <span
                                v-if="$page.props.tenant.gender == 1"
                                class="text-l font-bold block"
                            >
                                Madame</span
                            >
                        </li>
                        <li class="mb-4">
                            <span class="text-xs block">Nom</span
                            ><span class="text-l font-bold block">
                                {{ $page.props.tenant.last_name }}</span
                            >
                        </li>
                        <li class="mb-4">
                            <span class="text-xs block">Prénom</span
                            ><span class="text-l font-bold block">
                                {{ $page.props.tenant.name }}</span
                            >
                        </li>
                        <li class="mb-4">
                            <span class="text-xs block">E-mail</span
                            ><span class="text-l font-bold block">
                                {{ $page.props.tenant.email }}</span
                            >
                        </li>
                        <li class="mb-4">
                            <span class="text-xs block">Téléphone</span
                            ><span class="text-l font-bold block">
                                {{ $page.props.tenant.phone }}</span
                            >
                        </li>
                        <li class="mb-4">
                            <span class="text-xs block">Note</span
                            ><span class="text-l font-bold block">
                                {{ $page.props.tenant.notes }}</span
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { format } from "date-fns";
import { reactive } from "vue";

import Button from "primevue/button";
import { onMounted } from "vue";

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Link,
        format,
        Button,
    },
    props: ["data", "errors", "g_event_id"],
    data() {
        
        return {};
        
    },
    setup(context) {
        
        
        
        
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00" ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
            } else {
                return format(new Date(date.replace(" ", "T")), "dd/MM/yyyy");
            }
        }
        function formattedDateTime(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00" ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
            } else {
                return format(
                    new Date(date.replace(" ", "T")),
                    "dd/MM/yyyy à HH:mm"
                );
            }
        }
        function getDay(date) {
            var days = [
                "Dimanche",
                "Lundi",
                "Mardi",
                "Mercredi",
                "Jeudi",
                "Vendredi",
                "Samedi",
            ];

            var dayNumber = new Date(date).getDay();
            var day = days[dayNumber];
            return day;
        }
        function cancel(inventory_id) {
            Inertia.visit(
                route("cancel.inventory", {
                    id: inventory_id,
                })
            );
        }
        function edit(inventory_id) {
            Inertia.visit(
                route("edit.inventory", {
                    id: inventory_id,
                })
            );
        }

        return { formattedDate, getDay, cancel, edit, formattedDateTime };
    },
});
</script>
