<template>
    <div class="">
        <span class="inline-flex font-medium text-black-100">
            {{ data.property.city }}</span
        >
    </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
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
