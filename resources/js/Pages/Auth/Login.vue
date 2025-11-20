<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Button from '@/Components/Button.vue';
import { login, register } from '@/routes';
import { store as loginStore } from '@/actions/Laravel/Fortify/Http/Controllers/AuthenticatedSessionController';
import { request as forgotPassword } from '@/routes/password';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(loginStore(), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

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
                    :error="form.errors.email"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" required />

                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                    :error="form.errors.password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-text-muted">
                        Remember me
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="forgotPassword.url()"
                    class="underline text-sm text-text-muted hover:text-text-primary"
                >
                    Forgot your password?
                </Link>
            </div>

            <div class="flex items-center justify-end mt-6">
                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                    class="ml-4"
                >
                    Log in
                </Button>
            </div>

            <div class="mt-6 text-center">
                <span class="text-sm text-text-muted">
                    Don't have an account?
                    <Link
                        :href="register.url()"
                        class="underline text-primary-500 hover:text-primary-600"
                    >
                        Register
                    </Link>
                </span>
            </div>
        </form>
    </GuestLayout>
</template>

