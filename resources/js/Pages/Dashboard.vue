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
            class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4"
            ref="contentTop"
        >
            <div class="block">
                <div class="w-full bg-darkone px-6 py-4">
                    <h2
                        class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                    >
                        Logexpert
                        <span
                            class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                        >
                            Bienvenue</span
                        >
                    </h2>
                </div>
                <div
                    class="w-full px-6 py-4 bg-white border border-grayone overflow-hidden"
                >
                    Bienvenue sur LogExpert, votre plateforme de gestion d'état
                    des lieux.
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { useToast } from "vue-toastification";

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
        useToast,
    },

    setup(props, context) {
        // Notification Toast
        // Get toast interface
        const toast = useToast();

        if (context.attrs.flash.message) {
            // or with options
            toast.success(context.attrs.flash.message, {
                timeout: 2000,
            });
            // These options will override the options defined in the "app.use" plugin registration for this specific toast
        }
        return {
            toast,
        };
    },
});
</script>
