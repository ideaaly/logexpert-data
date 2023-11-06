<template>
    <app-layout title="Dashboard">
        <template #header> Liste des types de bien </template>

        <div class="mx-auto max-w-screen-lg border border-grayone">
            <div class="w-full bg-darkone px-6 py-4">
                <h2
                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                >
                    Édition
                    <span
                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                    >
                        Grille tarifaire</span
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
                            <th class="px-6 py-4 text-center">Nom</th>
                            <th class="px-6 py-4 text-center">Prix vendu</th>
                            <th class="px-6 py-4 text-center">
                                Prix acheté débutant
                            </th>
                            <th class="px-6 py-4 text-center">
                                Prix acheté confirmé
                            </th>
                            <th class="px-6 py-4 text-center"></th>
                            <th class="px-6 py-4 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in $page.props.data"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <td class="px-6 py-4 text-center">
                                {{ item.name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ item.sale_price }} €
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ item.price_beginner }} €
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ item.price_senior }} €
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form @submit.prevent="deleteItem(item.id)">
                                    <input :id="item.id" type="hidden" />
                                    <button type="submit">Supprimer</button>
                                </form>
                            </td>
                            <td>
                                <Link
                                    :href="route('edit.property_type', item.id)"
                                    class="bg-mainone hover:bg-darkone text-white font-bold py-1 px-1 rounded-lg"
                                >
                                    Modifier
                            </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <form
                    @submit.prevent="submit"
                    class="p-6 grid grid-cols-1 gap-6"
                >
                    <div class="grid grid-cols-5 gap-6">
                        <label
                            class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                            for="reference"
                        >
                            <span class="text-center">Nom</span>
                            <input
                                class="mt-1 block w-full text-center"
                                type="text"
                                id="name"
                                v-model="form.name"
                            />
                            <div v-if="errors.name" class="text-red-500">
                                {{ errors.name }}
                            </div>
                        </label>
                        <label
                            class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                            for="reference"
                        >
                            <span class="text-center">Prix vendu</span>
                            <input
                                class="mt-1 block w-full text-center"
                                type="text"
                                id="sale_price"
                                v-model="form.sale_price"
                            />
                            <div v-if="errors.sale_price" class="text-red-500">
                                {{ errors.sale_price }}
                            </div>
                        </label>
                        <label
                            class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                            for="reference"
                        >
                            <span class="text-center"
                                >Prix acheté débutant</span
                            >
                            <input
                                class="mt-1 block w-full text-center"
                                type="text"
                                id="price_beginner"
                                v-model="form.price_beginner"
                            />
                            <div
                                v-if="errors.price_beginner"
                                class="text-red-500"
                            >
                                {{ errors.price_beginner }}
                            </div>
                        </label>
                        <label
                            class="text-center block text-xs text-gray-700 font-bold uppercase text-xs uppercase font-bold text-gray-700"
                            for="reference"
                        >
                            <span class="text-center"
                                >Prix acheté confirmé</span
                            >
                            <input
                                class="mt-1 block w-full text-center"
                                type="text"
                                id="price_senior"
                                v-model="form.price_senior"
                            />
                            <div
                                v-if="errors.price_senior"
                                class="text-red-500"
                            >
                                {{ errors.price_senior }}
                            </div>
                        </label>

                        <button
                            type="submit"
                            class="bg-mainone hover:bg-darkone text-white font-bold py-1 px-1 rounded-lg"
                        >
                            + Ajouter
                        </button>
                    </div>
                </form>
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
import button from "@/Jetstream/Button.vue";

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
            property_types: this.data,
        };
    },
    mounted() {},

    methods: {
        destroy(id) {
            Inertia.delete(route("destroy.property_type", id));
        },
        edit(id) {
            Inertia.get(route("edit.property_type", id));
        },
    },
    setup() {
        const form = reactive({
            status: 1,
        });
        // const formDelete = reactive({
        //     property_type: null,
        // });

        // const destroy = (id) => {
        //     Inertia.delete(route("destroy.property_type", id));
        // };

        function submit() {
            Inertia.post("/property_types/store", form);
            this.$forceUpdate();
        }

        function deleteItem(id) {
            // console.log(route("destroy.property_type", id));
            Inertia.delete(route("destroy.property_type", id));
            this.$forceUpdate();
        }

        
        return { form, submit, deleteItem };
    },
});
</script>
