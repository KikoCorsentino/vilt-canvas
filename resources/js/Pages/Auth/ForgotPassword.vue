<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/Button.vue';
import Alert from '@/Components/Alert.vue';
import { login } from '@/routes';
import { store as forgotPasswordStore } from '@/actions/Laravel/Fortify/Http/Controllers/PasswordResetLinkController';

const page = usePage();
const flash = computed(() => page.props.flash);

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(forgotPasswordStore());
};

const status = computed(() => flash.value?.status);
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-text-muted">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <Alert
            v-if="status"
            type="success"
            message="We have emailed your password reset link!"
            :dismissible="true"
            class="mb-4"
        />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" required />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                    :error="form.errors.email"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="login.url()"
                    class="underline text-sm text-text-muted hover:text-text-primary"
                >
                    Back to login
                </Link>
            </div>

            <div class="flex items-center justify-end mt-6">
                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

