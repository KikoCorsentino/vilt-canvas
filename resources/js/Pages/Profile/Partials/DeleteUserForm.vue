<script setup>
import { computed, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const confirmingUserDeletion = ref(false);
const page = usePage();
const username = computed(() => page.props.auth?.user?.email ?? '');

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete('/user', {
        preserveScroll: true,
        onSuccess: () => {
            confirmingUserDeletion.value = false;
        },
        onError: () => {
            form.reset('password');
        },
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <div class="mb-4 text-sm text-text-muted">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your
            account, please download any data or information that you wish to retain.
        </div>

        <Button
            type="button"
            variant="danger"
            @click="confirmUserDeletion"
        >
            Delete Account
        </Button>

        <!-- Delete Account Confirmation Modal -->
        <Modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-text-primary">
                    Delete Account
                </h2>

                <p class="mt-1 text-sm text-text-muted">
                    Are you sure you want to delete your account? Once your account is deleted, all of its resources
                    and data will be permanently deleted. Please enter your password to confirm you would like to
                    permanently delete your account.
                </p>

                <form class="mt-6" @submit.prevent="deleteUser">
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

                    <InputLabel for="delete_password" value="Password" required />

                    <TextInput
                        id="delete_password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="current-password"
                        :error="form.errors.password"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />

                    <div class="mt-6 flex justify-end gap-3">
                        <Button
                            type="button"
                            variant="outlined"
                            @click="confirmingUserDeletion = false"
                        >
                            Cancel
                        </Button>

                        <Button
                            type="submit"
                            variant="danger"
                            :loading="form.processing"
                            :disabled="form.processing"
                        >
                            Delete Account
                        </Button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

