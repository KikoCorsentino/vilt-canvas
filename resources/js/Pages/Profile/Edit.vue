<script setup>
import { computed, ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import Alert from '@/Components/Alert.vue';

const page = usePage();
const flash = computed(() => page.props.flash);

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
        default: null,
    },
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

const status = computed(() => props.status || flash.value?.status);

const activeSection = ref('profile');

const setActiveSection = (section) => {
    activeSection.value = section;
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profile" />

        <template #header>
            <h2 class="font-semibold text-xl text-text-primary leading-tight">
                Profile
            </h2>
        </template>

        <div class="space-y-6">
            <Alert
                v-if="status === 'profile-information-updated'"
                type="success"
                message="Profile information updated successfully."
                :dismissible="true"
            />

            <div class="flex flex-col gap-8 lg:flex-row">
                <aside
                    class="bg-surface-0 lg:w-56"
                >
                    <nav class="flex flex-wrap gap-2 lg:flex-col">
                        <button
                            type="button"
                            :class="[
                                'w-full rounded-md px-3 py-2 text-left text-sm font-medium transition',
                                activeSection === 'profile'
                                    ? 'bg-surface-200 dark:bg-surface-50 text-text-primary'
                                    : 'text-text-primary hover:bg-surface-100',
                            ]"
                            @click="setActiveSection('profile')"
                        >
                            Profile
                        </button>
                        <button
                            type="button"
                            :class="[
                                'w-full rounded-md px-3 py-2 text-left text-sm font-medium transition',
                                activeSection === 'change-password'
                                    ? 'bg-surface-200 dark:bg-surface-50 text-text-primary'
                                    : 'text-text-primary hover:bg-surface-100',
                            ]"
                            @click="setActiveSection('change-password')"
                        >
                            Change Password
                        </button>
                        <button
                            type="button"
                            :class="[
                                'w-full rounded-md px-3 py-2 text-left text-sm font-medium transition',
                                activeSection === 'two-factor'
                                    ? 'bg-surface-200 dark:bg-surface-50 text-text-primary'
                                    : 'text-text-primary hover:bg-surface-100',
                            ]"
                            @click="setActiveSection('two-factor')"
                        >
                            Two Factor Authentication
                        </button>
                    </nav>
                </aside>

                <div class="flex-1 space-y-6">
                    <!-- Update Profile Information -->
                    <section
                        v-show="activeSection === 'profile'"
                        id="profile"
                        class="rounded-lg bg-surface-0 p-4 shadow sm:p-8 dark:bg-surface-100"
                    >
                        <div class="max-w-xl space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-text-primary">Profile Information</h3>

                                <p class="mt-1 text-sm text-text-muted">
                                    Update your account's profile information and email address.
                                </p>
                            </div>

                            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" />

                            <div class="border-t border-border pt-6">
                                <h4 class="text-base font-medium text-text-primary">Delete Account</h4>

                                <p class="mt-1 text-sm text-text-muted">
                                    Permanently remove your account and all associated data.
                                </p>

                                <div class="mt-6">
                                    <DeleteUserForm />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Update Password -->
                    <section
                        v-show="activeSection === 'change-password'"
                        id="change-password"
                        class="rounded-lg bg-surface-0 p-4 shadow sm:p-8 dark:bg-surface-100"
                    >
                        <div class="max-w-xl">
                            <h3 class="text-lg font-medium text-text-primary">Update Password</h3>

                            <p class="mt-1 text-sm text-text-muted mb-6">
                                Ensure your account is using a long, random password to stay secure.
                            </p>

                            <UpdatePasswordForm />
                        </div>
                    </section>

                    <!-- Two Factor Authentication -->
                    <section
                        v-show="activeSection === 'two-factor'"
                        id="two-factor"
                        class="rounded-lg bg-surface-0 p-4 shadow sm:p-8 dark:bg-surface-100"
                    >
                        <div class="max-w-xl">
                            <h3 class="text-lg font-medium text-text-primary dark:text-text-primary mb-4">
                                Two Factor Authentication
                            </h3>

                            <TwoFactorAuthenticationForm
                                :enabled="enabled"
                                :qr-code="qrCode"
                                :recovery-codes="recoveryCodes"
                            />
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

