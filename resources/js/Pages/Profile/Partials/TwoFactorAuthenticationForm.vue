<template>
    <jet-action-section>
        <template #title> Autentification à 2 facteurs. </template>

        <template #description>
            Ajoutez un niveau de sécurité supplémentaire.
        </template>

        <template #content>
            <h3
                class="text-lg font-medium text-gray-900"
                v-if="twoFactorEnabled"
            >
                Vous avez activé l'autentification à 2 facteurs.
            </h3>

            <h3 class="text-lg font-medium text-gray-900" v-else>
                Vous n'avez pas activé l'autentification à 2 facteurs.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>
                    Lorsque l'authentification à 2 facteurs est activée, vous
                    aurez un token aléatoire lors de votre connexion. Vous
                    retrouverez ce token sur votre mobile avec l'application
                    Google Authenticator.
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                            Vous avez activé l'autentification à 2 facteurs.
                            Scannez le QR code suivant via l'application Google
                            Authenticator.
                        </p>
                    </div>

                    <div class="mt-4" v-html="qrCode"></div>
                </div>

                <div v-if="recoveryCodes.length > 0">
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                            Enregistrez ces codes de recovery dans un manager de
                            mot de passe. Ils pourront être utilisé si vous
                            perdez votre téléphone.
                        </p>
                    </div>

                    <div
                        class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg"
                    >
                        <div v-for="code in recoveryCodes" :key="code">
                            {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div v-if="!twoFactorEnabled">
                    <jet-confirms-password
                        @confirmed="enableTwoFactorAuthentication"
                    >
                        <jet-button
                            type="button"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        >
                            Activer
                        </jet-button>
                    </jet-confirms-password>
                </div>

                <div v-else>
                    <jet-confirms-password @confirmed="regenerateRecoveryCodes">
                        <jet-secondary-button
                            class="mr-3"
                            v-if="recoveryCodes.length > 0"
                        >
                            Regénérer des Recovery Codes
                        </jet-secondary-button>
                    </jet-confirms-password>

                    <jet-confirms-password @confirmed="showRecoveryCodes">
                        <jet-secondary-button
                            class="mr-3"
                            v-if="recoveryCodes.length === 0"
                        >
                            Montrer les Recovery Codes
                        </jet-secondary-button>
                    </jet-confirms-password>

                    <jet-confirms-password
                        @confirmed="disableTwoFactorAuthentication"
                    >
                        <jet-danger-button
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        >
                            Désactiver
                        </jet-danger-button>
                    </jet-confirms-password>
                </div>
            </div>
        </template>
    </jet-action-section>
</template>

<script>
import { defineComponent } from "vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmsPassword from "@/Jetstream/ConfirmsPassword.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default defineComponent({
    components: {
        JetActionSection,
        JetButton,
        JetConfirmsPassword,
        JetDangerButton,
        JetSecondaryButton,
    },

    data() {
        return {
            enabling: false,
            disabling: false,

            qrCode: null,
            recoveryCodes: [],
        };
    },

    methods: {
        enableTwoFactorAuthentication() {
            this.enabling = true;

            this.$inertia.post(
                "/user/two-factor-authentication",
                {},
                {
                    preserveScroll: true,
                    onSuccess: () =>
                        Promise.all([
                            this.showQrCode(),
                            this.showRecoveryCodes(),
                        ]),
                    onFinish: () => (this.enabling = false),
                }
            );
        },

        showQrCode() {
            return axios.get("/user/two-factor-qr-code").then((response) => {
                this.qrCode = response.data.svg;
            });
        },

        showRecoveryCodes() {
            return axios
                .get("/user/two-factor-recovery-codes")
                .then((response) => {
                    this.recoveryCodes = response.data;
                });
        },

        regenerateRecoveryCodes() {
            axios.post("/user/two-factor-recovery-codes").then((response) => {
                this.showRecoveryCodes();
            });
        },

        disableTwoFactorAuthentication() {
            this.disabling = true;

            this.$inertia.delete("/user/two-factor-authentication", {
                preserveScroll: true,
                onSuccess: () => (this.disabling = false),
            });
        },
    },

    computed: {
        twoFactorEnabled() {
            return !this.enabling && this.$page.props.user.two_factor_enabled;
        },
    },
});
</script>
