<script setup>
import { computed } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Button from '@/Components/Button.vue';
import Alert from '@/Components/Alert.vue';
import { logout } from '@/routes';

const page = usePage();
const flash = computed(() => page.props.flash);

const props = defineProps({
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({});
const logoutForm = useForm({});

const submit = () => {
    form.post('/email/verification-notification', {
        onFinish: () => form.reset(),
    });
};

const logoutUser = () => {
    logoutForm.post(logout.url());
};

const status = computed(() => props.status || flash.value?.status);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-text-muted">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <Alert
            v-if="status === 'verification-link-sent'"
            type="success"
            message="A new verification link has been sent to the email address you provided during registration."
            :dismissible="true"
            class="mb-4"
        />

        <div class="mt-4 flex items-center justify-between">
            <form @submit.prevent="submit">
                <Button
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </Button>
            </form>

            <form @submit.prevent="logoutUser" class="ml-4">
                <Button
                    type="submit"
                    variant="outlined"
                    :loading="logoutForm.processing"
                >
                    Log Out
                </Button>
            </form>
        </div>
    </GuestLayout>
</template>

