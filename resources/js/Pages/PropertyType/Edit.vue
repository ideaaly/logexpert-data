<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["property_type", "errors"]);

const form = useForm({
    name: props.property_type.name,
    sale_price: props.property_type.sale_price,
    price_beginner: props.property_type.price_beginner,
    price_senior: props.property_type.price_senior,
});
</script>

<template>
    <app-layout title="Dashboard">
        <template #header> Edition de grille tarifaire </template>
        <div class="mx-auto max-w-screen-lg border border-grayone">
            <div class="w-full bg-darkone px-6 py-4">
                <h2
                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                >
                    Éditer le type de bien
                    <span
                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                    >
                        Grille tarifaire</span
                    >
                </h2>
            </div>
            <div
                class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
            >
                <form
                    @submit.prevent="
                        form.post(
                            route('update.property_type', this.property_type.id)
                        )
                    "
                    class="grid grid-cols-1 gap-6"
                >
                    <div class="w-full p-12">
                        <div class="grid grid-cols-5 gap-6">
                            <tr>
                                <span class="text-center">NOM</span>
                                <input
                                    class="mt-1 block w-full text-center"
                                    type="text"
                                    id="price_senior"
                                    v-model="form.name"
                                />
                                <span class="text-center">PRIX VENDU</span>
                                <input
                                    class="mt-1 block w-full text-center"
                                    type="number"
                                    id="price_senior"
                                    v-model="form.sale_price"
                                />
                                <span class="text-center"
                                    >PRIX ACHETÉ DÉBUTANT</span
                                >
                                <input
                                    class="mt-1 block w-full text-center"
                                    type="number"
                                    id="price_senior"
                                    v-model="form.price_beginner"
                                />
                                <span class="text-center"
                                    >PRIX ACHETÉ CONFIRMÉ</span
                                >
                                <input
                                    class="mt-1 block w-full text-center"
                                    type="number"
                                    id="price_senior"
                                    v-model="form.price_senior"
                                />

                                <div>
                                    <button
                                        type="submit"
                                        class="bg-mainone hover:bg-darkone text-white font-bold py-1 px-1 rounded-lg"
                                    >
                                        + Modifier
                                    </button>
                                </div>
                            </tr>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>
<script>
export default defineComponent({
    components: {
        AppLayout,
    },

    // data() {
    //     return {
    //         form: {
    //             name: this.data.name,
    //             sale_price: this.data.sale_price,
    //             price_beginner: this.data.price_beginner,
    //             price_senior: this.data.price_senior,
    //         },
    //         property_type: this.data,
    //     };
    // },
    // attrs() {
    //     return {
    //         form: this.$inertia.form({
    //             name: this.data.name,
    //             sale_price: this.data.sale_price,
    //             price_beginner: this.data.price_beginner,
    //             price_senior: this.data.price_senior,
    //         }),
    //         property_type: this.attrs,
    //     };
    // },
    // methods: {
    //     submit() {
    //         Inertia.post(
    //             route("update.property_type", [
    //                 this.property_type.id,
    //                 this.form,
    //             ])
    //         );
    //     },
    // },
    mounted() {},
});
</script>
