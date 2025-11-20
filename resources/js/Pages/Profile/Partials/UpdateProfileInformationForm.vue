<script setup>
import { computed, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/Button.vue';
import Alert from '@/Components/Alert.vue';
import { update as updateProfile } from '@/actions/Laravel/Fortify/Http/Controllers/ProfileInformationController';

const page = usePage();
const auth = computed(() => page.props.auth);

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    name: auth.value.user.name,
    email: auth.value.user.email,
});

const emailChanged = computed(() => form.email !== auth.value.user.email);

const submit = () => {
    form.put(updateProfile(), {
        preserveScroll: true,
        onSuccess: () => {
            if (props.mustVerifyEmail && emailChanged.value) {
                // Email verification notice will be shown
            }
        },
    });
};
</script>

<template>
    <div>
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

            <div v-if="mustVerifyEmail && emailChanged" class="mt-4">
                <Alert
                    type="info"
                    message="Your email address is unverified. Please click the link in the email we sent you to verify your email address."
                    :dismissible="false"
                />
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

