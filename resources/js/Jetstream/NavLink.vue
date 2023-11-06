<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link,
    },
    props: ["href", "active"],

    computed: {
        classes() {
            return this.active
                ? "flex items-center content-center text-sm py-2 px-6 rounded-r-xl font-bold overflow-hidden text-white gradientMain-fast pl-8 mr-6 text-ellipsis whitespace-nowrap hover:text-white-900 transition duration-600 ease-in-out"
                : "flex items-center content-center text-sm py-2 px-6 rounded-r-xl font-regular overflow-hidden  text-ellipsis pl-8 mr-6 whitespace-nowrap hover:text-gray-900 hover:bg-gray-100 transition duration-300 ease-in-out  ";
        },
    },
});
</script>
