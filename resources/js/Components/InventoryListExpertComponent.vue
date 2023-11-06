<template>
    <div class="">
        <span
            class="inline-flex items-center leading-none font-bold text-black-100"
            v-if="data.user_referent"
        >
            <span
                class="flex justify-center items-center w-8 h-8 text-white bg-darkone rounded-full mr-2"
                >{{ getFirstChar(data.user_referent.name) }}</span
            >
            {{ data.user_referent.name }}
        </span>
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
        function getFirstChar(word) {
            return word.charAt(0);
        }

        return { getFirstChar };
    },
});
</script>
