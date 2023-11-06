<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <form
                            @submit.prevent="submit"
                            class="grid grid-cols-1 gap-6"
                        >
                            <div class="w-full p-12">
                                <div>
                                    <jet-label for="name" value="Name" />
                                    <jet-input
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                </div>

                                <div class="mt-4">
                                    <jet-label for="email" value="Email" />
                                    <jet-input
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                    />
                                </div>

                                <div class="mt-4">
                                    <jet-label
                                        for="password"
                                        value="Password"
                                    />
                                    <jet-input
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>

                                <div class="mt-4">
                                    <jet-label
                                        for="password_confirmation"
                                        value="Confirm Password"
                                    />
                                    <jet-input
                                        id="password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>

                                <div class="mt-4 hidden">
                                    <jet-label
                                        for="expert_level"
                                        value="Niveau expert"
                                    />
                                    <jet-input
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        value="0"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                </div>
                                <div class="mt-4">
                                    <jet-label
                                        for="phone_number"
                                        value="Numéro de téléhpone"
                                    />
                                    <jet-input
                                        id="phone_number"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.phone_number"
                                        required
                                        autofocus
                                        autocomplete="g_calid"
                                    />
                                </div>
                                <div class="mt-4">
                                    <jet-label
                                        for="g_calid"
                                        value="ID Calendrier Google"
                                    />
                                    <jet-input
                                        id="g_calid"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.g_calid"
                                        required
                                        autofocus
                                        autocomplete="g_calid"
                                    />
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <Link
                                        :href="route('users.index')"
                                        class="bg-grayone text-center hover:opacity text-darkone font-bold py-2 px-4 rounded-lg mt-6"
                                        >Annuler</Link
                                    >
                                    <button
                                        type="submit"
                                        class="bg-mainone hover:bg-darkone text-white font-bold py-2 px-4 rounded-lg mt-6"
                                    >
                                        Enregistrer →
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";

import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";

export default {
    components: {
        Head,
        Link,
        AppLayout,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
    },
    props: {
        errors: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                expert_level: "",
                g_calid: "",
                terms: false,
            }),
        };
    },
    setup() {
        const form = reactive({
            status: 1,
        });

        function submit() {
            Inertia.post(route("users.create.informations", form));
        }

        return { form, submit };
    },
};
</script>
