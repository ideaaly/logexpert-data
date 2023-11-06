<template>
    <div class="">
        <span
            v-if="data.date_wanted"
            class="flex text-sm font-bold leading-none uppercase text-black-100 mt-1"
        >
            {{ formattedDate(data.date_wanted) }}</span
        >
        <span v-else>-</span>

        <span
            v-if="data.period_wanted == 1"
            class="inline-flex text-xs font-medium leading-none text-black-100"
        >
            Matinée</span
        >
        <span
            v-if="data.period_wanted == 2"
            class="inline-flex text-xs font-medium leading-none text-black-100"
        >
            Après-midi</span
        >
        <span
            v-if="data.period_wanted == 3"
            class="inline-flex text-xs font-medium leading-none text-black-100"
        >
            Soirée</span
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
    setup() {
        function formattedDate(date) {
            if (
                date == "" ||
                date == null ||
                date == "0000-00-00" ||
                date == "1900-01-01"
            ) {
                return "-";
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
            return day;
        }
        return { formattedDate, getDay };
    },
});
</script>
