<template>
    <div class="">
        <span
            v-if="data.type == 1"
            class="w-full block text-left font-black leading-none text-mainone"
        >
            Entrée</span
        >
        <span
            v-if="data.type == 2"
            class="w-full block text-left font-black leading-none text-orange-500"
        >
            Sortie</span
        >
    </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { format } from "date-fns";
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
    setup() {},
});
</script>
