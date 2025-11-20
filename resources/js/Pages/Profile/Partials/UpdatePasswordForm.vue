<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/Button.vue';
import Alert from '@/Components/Alert.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { update as updatePassword } from '@/actions/Laravel/Fortify/Http/Controllers/PasswordController';

const page = usePage();
const flash = computed(() => page.props.flash);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(updatePassword(), {
        preserveScroll: true,
        onFinish: () => form.reset('current_password', 'password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <Alert
            v-if="flash?.status === 'password-updated'"
            type="success"
            message="Password updated successfully."
            :dismissible="true"
            class="mb-4"
        />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="current_password" value="Current Password" required />

                <TextInput
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="current-password"
                    :error="form.errors.current_password"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="New Password" required />

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

            <div class="flex items-center justify-end mt-6">
                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                >
                    Save
                </Button>
            </div>
        </form>
    </div>
</template>

