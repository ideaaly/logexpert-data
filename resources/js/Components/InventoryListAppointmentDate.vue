<template>
    <div class="">{{ data.appointment.date }}</div>
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
    mounted() {
        this.inventories.forEach(
            (inventories) =>
                (inventories.appointment.date = new Date(
                    inventories.appointment.date
                ))
        );
    },
    setup(props, context) {
        function formatDate(value) {
            return value.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
        }
        function formattedDate(date) {
            if (
                date == "Invalid Date" ||
                date == "" ||
                date == null ||
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
                date == "Invalid Date" ||
                date == "" ||
                date == null ||
                date == "0000-00-00 00:00:00" ||
                date == "1900-01-01 00:00:00" ||
                date == "0000-00-00" ||
                date == "1900-01-01" ||
                date == []
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

            var dayNumber = new Date(date.replace(" ", "T")).getDay();
            var day = days[dayNumber];
            return day;
        }
        function handleClick(e) {
            Inertia.visit(
                route("inventories.show", {
                    id: e.data.id,
                }),
                { method: "get" }
            );
        }
        function handleClickPage(e) {
            window.scrollTo(0, 0);
        }

        const experts = props.experts;
        const expertNames = props.expertNames;

        return {
            formattedDate,
            formattedDateTime,
            getDay,
            handleClick,
            handleClickPage,
            experts,
            expertNames,
            formatDate,
        };
    },
});
</script>
