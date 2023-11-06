<template>
    <transition-group
        name="fade"
        enter-active-class="duration-400 transition-all ease"
        leave-active-class="duration-400 transition-all ease"
        :enter-class="'opacity'"
    >
        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
            v-if="loaded"
        >
            <div>
                <slot name="logo" />
            </div>

            <div class="w-full sm:max-w-md bg-darkone mt-6 px-6 py-4">
                <h2
                    class="text-mainone m-0 leading-none flex flex-col text-sm font-bold"
                >
                    Bienvenue
                    <span
                        class="text-white mt-1 leading-none flex flex-col text-xl font-black"
                    >
                        Identifiez-vous</span
                    >
                </h2>
            </div>

            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white border border-grayone overflow-hidden"
            >
                <slot />
            </div>
        </div>
    </transition-group>
</template>

<script>
export default {
    data() {
        return {
            loaded: false,
        };
    },

    mounted() {
        this.loaded = true;
    },
};
</script>
