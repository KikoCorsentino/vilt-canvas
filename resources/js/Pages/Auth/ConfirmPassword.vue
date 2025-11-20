<script setup>
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/Button.vue';
import { store as confirmPasswordStore } from '@/routes/password/confirm';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(confirmPasswordStore(), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-text-muted">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" required />

                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="current-password"
                    :error="form.errors.password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                >
                    Confirm
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>

