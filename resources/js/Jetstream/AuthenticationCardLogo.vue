<template>
    <Link :href="'/'">
        <img src="/img/logo.png" class="w-24" alt="Logexpert" />
    </Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Link,
    },
});
</script>
