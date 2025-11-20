<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Alert from '@/Components/Alert.vue';

const page = usePage();

const flash = computed(() => page.props.flash);

const showSuccessAlert = computed(() => flash.value?.success);
const showErrorAlert = computed(() => flash.value?.error);
const showWarningAlert = computed(() => flash.value?.warning);
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface-50 dark:bg-surface-300 transition-colors duration-200">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-surface-100 dark:bg-surface-300 shadow-lg overflow-hidden rounded-lg transition-colors duration-200">
            <div class="flex justify-between items-center mb-6">
                <div class="flex-1 flex justify-center">
                    <ApplicationLogo />
                </div>
            </div>

            <div v-if="showSuccessAlert || showErrorAlert || showWarningAlert" class="mb-6 space-y-4">
                <Alert
                    v-if="showSuccessAlert"
                    type="success"
                    :message="flash.success"
                    :dismissible="true"
                />
                <Alert
                    v-if="showErrorAlert"
                    type="error"
                    :message="flash.error"
                    :dismissible="true"
                />
                <Alert
                    v-if="showWarningAlert"
                    type="warning"
                    :message="flash.warning"
                    :dismissible="true"
                />
            </div>

            <slot />
        </div>
    </div>
</template>

