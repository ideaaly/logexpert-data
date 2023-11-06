<template>
    <div class="">
        <span v-if="data.status == 0" class="status-badge gray">
            Brouillon</span
        >
        <span v-if="data.status == 1" class="status-badge yellow">
            À confirmer</span
        >
        <span v-if="data.status == 2" class="status-badge purple">
            À assigner</span
        >
        <span v-if="data.status == 3" class="status-badge red">
            En attente de RDV</span
        >
        <span v-if="data.status == 4" class="status-badge blue">
            À réaliser</span
        >
        <span v-if="data.status == 5" class="status-badge green"> Terminé</span>

        <span v-if="data.status == 99" class="status-badge black"> Annulé</span>
        <span v-if="data.status == 100" class="status-badge black">
            Archivé</span
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
