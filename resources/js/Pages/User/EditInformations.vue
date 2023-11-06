<template>
    <app-layout title="Profile">
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
        <div class="max-w-md mx-auto">
            <div class="w-full bg-darkone px-6 py-4">
                <h2
                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                >
                    Éditer un utilisateur
                    <span
                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                    >
                        {{ form.name }}</span
                    >
                </h2>
            </div>
            <div
                class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
            >
                <form @submit.prevent="submit" class="grid grid-cols-1 gap-6">
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
                        <div class="mt-4 hidden">
                            <jet-label for="id" value="ID" />
                            <jet-input
                                id="id"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.id"
                                required
                                autofocus
                                autocomplete="name"
                            />
                        </div>
                        <div class="mt-4">
                            <jet-label
                                for="phone_number"
                                value="Numéro de téléphone"
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
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
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
                expert_level: "",
                g_calid: "",
                terms: false,
            }),
        };
    },
    setup(props, context) {
        const form = reactive({
            id: context.attrs.userToEdit.id,
            name: context.attrs.userToEdit.name,
            email: context.attrs.userToEdit.email,
            g_calid: context.attrs.userToEdit.g_calid,
            phone_number: context.attrs.userToEdit.phone_number,
        });

        function submit() {
            Inertia.post(route("users.update.informations", form));
        }

        return { form, submit };
    },
    methods: {
        // submit() {
        //     this.form.post(this.route("register"), {
        //         onFinish: () =>
        //             this.form.reset("password", "password_confirmation"),
        //     });
        // },
    },
});
</script>
