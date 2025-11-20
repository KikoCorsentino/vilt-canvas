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
import { store as registerStore } from '@/actions/Laravel/Fortify/Http/Controllers/RegisteredUserController';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(registerStore(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" required />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                    :error="form.errors.name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" required />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
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
                    autocomplete="new-password"
                    :error="form.errors.password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" required />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                    :error="form.errors.password_confirmation"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label class="flex items-start">
                    <Checkbox
                        v-model="form.terms"
                        name="terms"
                        required
                    />
                    <span class="ml-2 text-sm text-text-muted">
                        I agree to the
                        <a
                            href="#"
                            target="_blank"
                            class="underline text-primary-500 hover:text-primary-600"
                        >
                            Terms of Service
                        </a>
                        and
                        <a
                            href="#"
                            target="_blank"
                            class="underline text-primary-500 hover:text-primary-600"
                        >
                            Privacy Policy
                        </a>
                    </span>
                </label>
                <InputError :message="form.errors.terms" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <Link
                    :href="login.url()"
                    class="underline text-sm text-text-muted hover:text-text-primary"
                >
                    Already registered?
                </Link>

                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                    class="ml-4"
                >
                    Register
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

