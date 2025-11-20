<script setup>
import { ref, computed } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Alert from '@/Components/Alert.vue';
import { store as enable2FA, destroy as disable2FA } from '@/actions/Laravel/Fortify/Http/Controllers/TwoFactorAuthenticationController';
import { index as getRecoveryCodes, store as regenerateRecoveryCodes } from '@/actions/Laravel/Fortify/Http/Controllers/RecoveryCodeController';

const props = defineProps({
    enabled: {
        type: Boolean,
        default: false,
    },
    qrCode: {
        type: String,
        default: null,
    },
    recoveryCodes: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const confirmingPassword = ref(false);
const showingRecoveryCodes = ref(false);
const username = computed(() => page.props.auth?.user?.email ?? '');

const enableForm = useForm({
    password: '',
});

const disableForm = useForm({});

const confirmPassword = () => {
    confirmingPassword.value = true;
};

const enableTwoFactor = () => {
    enableForm.post(enable2FA(), {
        preserveScroll: true,
        onSuccess: () => {
            confirmingPassword.value = false;
            enableForm.reset();
            // Refresh to get QR code and recovery codes
            router.reload({ only: ['qrCode', 'recoveryCodes'] });
        },
        onError: () => {
            enableForm.reset('password');
        },
    });
};

const disableTwoFactor = () => {
    disableForm.delete(disable2FA(), {
        preserveScroll: true,
    });
};

const showRecoveryCodes = () => {
    router.get(getRecoveryCodes().url(), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            showingRecoveryCodes.value = true;
        },
    });
};

const regenerateRecoveryCodesAction = () => {
    router.post(regenerateRecoveryCodes().url(), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            showingRecoveryCodes.value = true;
        },
    });
};
</script>

<template>
    <div>
        <div v-if="!enabled">
            <div class="mb-4 text-sm text-text-muted">
                When two factor authentication is enabled, you will be prompted for a secure, random token during
                authentication. You may retrieve this token from your phone's Google Authenticator application.
            </div>

            <Button
                type="button"
                @click="confirmPassword"
            >
                Enable
            </Button>
        </div>

        <div v-else>
            <div class="mb-4 text-sm text-text-muted">
                Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator
                application.
            </div>

            <div v-if="qrCode" class="mb-4">
                <div class="inline-block p-4 bg-surface-100 dark:bg-surface-300 rounded-lg transition-colors duration-200">
                    <div v-html="qrCode" />
                </div>
            </div>

            <div v-if="recoveryCodes && recoveryCodes.length > 0" class="mb-4">
                <div class="mb-2 text-sm font-medium text-text-primary">
                    Store these recovery codes in a secure password manager. They can be used to recover access to your
                    account if your two factor authentication device is lost.
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-surface-200 rounded-lg">
                    <div v-for="code in recoveryCodes" :key="code" class="text-text-primary">
                        {{ code }}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button
                    v-if="recoveryCodes && recoveryCodes.length === 0"
                    type="button"
                    variant="outlined"
                    @click="showRecoveryCodes"
                >
                    Show Recovery Codes
                </Button>

                <Button
                    v-if="recoveryCodes && recoveryCodes.length > 0"
                    type="button"
                    variant="outlined"
                    @click="regenerateRecoveryCodesAction"
                >
                    Regenerate Recovery Codes
                </Button>

                <Button
                    type="button"
                    variant="danger"
                    @click="disableTwoFactor"
                    :loading="disableForm.processing"
                >
                    Disable
                </Button>
            </div>
        </div>

        <!-- Confirm Password Modal -->
        <Modal :show="confirmingPassword" @close="confirmingPassword = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-text-primary">
                    Confirm Password
                </h2>

                <p class="mt-1 text-sm text-text-muted">
                    For your security, please confirm your password to continue.
                </p>

                <form class="mt-6" @submit.prevent="enableTwoFactor">
                    <input
                        v-if="username"
                        type="text"
                        name="username"
                        :value="username"
                        autocomplete="username"
                        class="sr-only"
                        tabindex="-1"
                        aria-hidden="true"
                        readonly
                    />

                    <InputLabel for="two_factor_password" value="Password" required />

                    <TextInput
                        id="two_factor_password"
                        v-model="enableForm.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="current-password"
                        :error="enableForm.errors.password"
                    />

                    <InputError :message="enableForm.errors.password" class="mt-2" />

                    <div class="mt-6 flex justify-end gap-3">
                        <Button
                            type="button"
                            variant="outlined"
                            @click="confirmingPassword = false"
                        >
                            Cancel
                        </Button>

                        <Button
                            type="submit"
                            :loading="enableForm.processing"
                            :disabled="enableForm.processing"
                        >
                            Confirm
                        </Button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Recovery Codes Modal -->
        <Modal :show="showingRecoveryCodes" @close="showingRecoveryCodes = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-text-primary">
                    Recovery Codes
                </h2>

                <div class="mt-4 text-sm text-text-muted">
                    Store these recovery codes in a secure password manager. They can be used to recover access to your
                    account if your two factor authentication device is lost.
                </div>

                <div v-if="recoveryCodes && recoveryCodes.length > 0" class="mt-4">
                    <div class="grid gap-1 max-w-xl px-4 py-4 font-mono text-sm bg-surface-200 rounded-lg">
                        <div v-for="code in recoveryCodes" :key="code" class="text-text-primary">
                            {{ code }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <Button
                        type="button"
                        variant="outlined"
                        @click="showingRecoveryCodes = false"
                    >
                        Close
                    </Button>
                </div>
            </div>
        </Modal>
    </div>
</template>

