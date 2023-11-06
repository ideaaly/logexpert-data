<template>
    <div class="">
        <div class="mb-6 pb-3 border border-transparent border-b-gray-200">
            <p
                class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
            >
                EDL
            </p>
            <ul class="grid grid-cols-2 gap-2">
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Type</span>
                    <span
                        v-if="$page.props.inventory.type == 1"
                        class="text-l font-bold block"
                        >Entrée</span
                    >
                    <span
                        v-if="$page.props.inventory.type == 2"
                        class="text-l font-bold block"
                        >Sortie</span
                    >
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Référence</span>
                    <span class="text-l font-bold block">{{
                        $page.props.inventory.reference
                    }}</span>
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Date souhaitée</span>
                    <span class="text-l font-bold block">
                        {{ getDay($page.props.inventory.date_wanted) }}
                        {{ formattedDate($page.props.inventory.date_wanted) }}
                    </span>

                    <span
                        v-if="$page.props.inventory.period_wanted == 1"
                        class="text-l font-bold block"
                        >Matin</span
                    >
                    <span
                        v-if="$page.props.inventory.period_wanted == 2"
                        class="text-l font-bold block"
                        >Après-midi</span
                    >
                    <span
                        v-if="$page.props.inventory.period_wanted == 3"
                        class="text-l font-bold block"
                        >Soirée</span
                    >
                </li>
            </ul>
        </div>
        <div
            class="mb-6 pb-3 border border-transparent border-b-gray-200"
            v-if="$page.props.property.owner_name != ''"
        >
            <p
                class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
            >
                Logement
            </p>
            <ul class="grid grid-cols-2 gap-2">
                <li
                    class="mb-2 pb-2 col-span-2"
                    v-if="$page.props.property.owner_name != ''"
                >
                    <span class="text-xs block">Nom du Propriétaire</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.owner_name
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.address1 != ''"
                >
                    <span class="text-xs block">Adresse</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.address1
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.address2 != ''"
                >
                    <span class="text-xs block">Complément d'adresse</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.address2
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.building_number != ''"
                >
                    <span class="text-xs block">N° Bâtiment</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.building_number
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.appt_number != ''"
                >
                    <span class="text-xs block">N° d'appt</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.appt_number
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.zip_code != ''"
                >
                    <span class="text-xs block">Code postal</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.zip_code
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.city != ''">
                    <span class="text-xs block">Ville</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.city
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.country != ''">
                    <span class="text-xs block">Pays</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.country
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.year_construction != ''"
                >
                    <span class="text-xs block">Année de construction</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.year_construction
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.surface != ''">
                    <span class="text-xs block">Surface</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.surface
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.water != ''">
                    <span class="text-xs block">Type eau chaude sanitaire</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.water
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.heating != ''">
                    <span class="text-xs block">Type de chauffage</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.heating
                    }}</span>
                </li>
                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.is_furnished != ''"
                >
                    <span class="text-xs block">Meublé ?</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.is_furnished
                    }}</span>
                </li>
                <li class="mb-2 pb-2" v-if="$page.props.property.notes != ''">
                    <span class="text-xs block">Notes sur le logement</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.notes
                    }}</span>
                </li>

                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.parking_number != ''"
                >
                    <span class="text-xs block">Numéro Parking</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.parking_number
                    }}</span>
                </li>

                <li
                    class="mb-2 pb-2"
                    v-if="$page.props.property.cellar_number != ''"
                >
                    <span class="text-xs block">Numéro Cave</span>
                    <span class="text-l font-bold block">{{
                        $page.props.property.cellar_number
                    }}</span>
                </li>
            </ul>
        </div>
        <div class="mb-3" v-if="$page.props.tenant.last_name != ''">
            <p
                class="font-black text-mainone uppercase text-xl text-extrabold mb-1"
            >
                Locataire
            </p>
            <ul class="grid grid-cols-2 gap-2">
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Civilité</span>
                    <span
                        class="text-l font-bold block"
                        v-if="$page.props.tenant.gender == 0"
                        >Monsieur</span
                    >
                    <span
                        class="text-l font-bold block"
                        v-if="$page.props.tenant.gender == 1"
                        >Mme</span
                    >
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Nom</span>
                    <span class="text-l font-bold block">{{
                        $page.props.tenant.last_name
                    }}</span>
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Prénom</span>
                    <span class="text-l font-bold block">{{
                        $page.props.tenant.name
                    }}</span>
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">E-mail</span>
                    <span class="text-l font-bold block">{{
                        $page.props.tenant.email
                    }}</span>
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Téléphone</span>
                    <span class="text-l font-bold block">{{
                        $page.props.tenant.phone
                    }}</span>
                </li>
                <li class="mb-2 pb-2">
                    <span class="text-xs block">Notes sur le locataire</span>
                    <span class="text-l font-bold block">{{
                        $page.props.tenant.notes
                    }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { format } from "date-fns";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        Link,
        AppLayout,
        format,
    },
    props: ["data", "errors"],
    data() {
        return {};
    },
    setup() {
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "";
            } else {
                return format(new Date(date), "dd/MM/yyyy");
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
            console.log(day);
            return day;
        }
        return { formattedDate, getDay };
    },
});
</script>
