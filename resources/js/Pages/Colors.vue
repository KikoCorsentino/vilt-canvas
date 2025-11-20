<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const paletteGroups = [
    {
        name: 'Primary Palette',
        description: 'Set a single hue/saturation/lightness for primary-500 inside app.css and every other shade is generated automatically.',
        colors: [
            { name: 'primary-50', class: 'bg-primary-50', text: 'text-text-primary' },
            { name: 'primary-100', class: 'bg-primary-100', text: 'text-text-primary' },
            { name: 'primary-200', class: 'bg-primary-200', text: 'text-text-primary' },
            { name: 'primary-300', class: 'bg-primary-300', text: 'text-text-primary' },
            { name: 'primary-400', class: 'bg-primary-400', text: 'text-white' },
            { name: 'primary-500', class: 'bg-primary-500', text: 'text-white' },
            { name: 'primary-600', class: 'bg-primary-600', text: 'text-white' },
            { name: 'primary-700', class: 'bg-primary-700', text: 'text-white' },
            { name: 'primary-800', class: 'bg-primary-800', text: 'text-white' },
            { name: 'primary-900', class: 'bg-primary-900', text: 'text-white' },
        ],
    },
    {
        name: 'Surface Palette',
        description: 'Neutral layers used for shells, cards, sheets, and overlays. Only five shades are required for both light and dark.',
        colors: [
            { name: 'surface-50', class: 'bg-surface-50', text: 'text-text-primary', border: 'border border-border' },
            { name: 'surface-100', class: 'bg-surface-100', text: 'text-text-primary', border: 'border border-border' },
            { name: 'surface-200', class: 'bg-surface-200', text: 'text-text-primary', border: 'border border-border' },
            { name: 'surface-300', class: 'bg-surface-300', text: 'text-text-primary', border: 'border border-border' },
            { name: 'surface-400', class: 'bg-surface-400', text: 'text-text-primary', border: 'border border-border' },
        ],
    },
];

const systemTokens = [
    {
        name: 'text-primary-500',
        label: 'Primary text',
        description: 'Default copy color with maximum contrast on any surface.',
        type: 'text',
        textClass: 'text-text-primary',
    },
    {
        name: 'text-muted',
        label: 'Muted text',
        description: 'Secondary copy for meta data, captions, and helper text.',
        type: 'text',
        textClass: 'text-text-muted',
    },
    {
        name: 'border-color',
        label: 'Border',
        description: 'Universal border color for cards, inputs, and separators.',
        type: 'border',
        borderClass: 'border-2 border-border',
    },
    {
        name: 'ring-color',
        label: 'Focus ring',
        description: 'Outline for focus states and interactive affordances.',
        type: 'ring',
        ringClass: 'ring-4 ring-ring',
    },
];
</script>

<template>
    <Head title="Colors" />

    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
            <div>
                <p class="text-xs uppercase font-semibold tracking-[0.2em] text-text-muted mb-2">
                    Design Token System
                </p>
                <h1 class="text-4xl font-bold text-text-primary mb-4">
                    Flux Color Playground
                </h1>
                <p class="text-text-muted max-w-3xl">
                    Tweak a single hue in <code class="px-2 py-1 rounded bg-surface-100 text-xs font-mono">resources/css/app.css</code> and the entire palette reflows automatically.
                    Only primary and surface hues are required—text, borders, and rings follow the Flux UI specification.
                </p>
            </div>

            <!-- Preview playground -->
            <section class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl bg-surface-100 dark:bg-surface-50 p-6 border border-border relative overflow-hidden">
                    <div class="absolute -right-10 -top-16 h-48 w-48 bg-primary-500/20 blur-3xl pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div>
                            <p class="text-sm font-medium text-text-muted">Primary Actions</p>
                            <h2 class="text-2xl font-semibold text-text-primary mt-1">
                                Buttons + badges preview
                            </h2>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800 border border-border">
                            {{ paletteGroups[0].colors[4].name }}
                        </span>
                    </div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button class="px-5 py-2.5 rounded-xl bg-primary-500 text-white font-semibold shadow-lg shadow-primary-500/40 transition hover:-translate-y-0.5">
                                Primary CTA
                            </button>
                            <button class="px-5 py-2.5 rounded-xl bg-primary-100 text-primary-800 font-semibold border border-border">
                                Ghost CTA
                            </button>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-500/10 text-text-primary border border-dashed border-border">
                                badge
                            </span>
                        </div>
                        <div class="rounded-2xl border border-border p-4 bg-white/60 dark:bg-black/20 backdrop-blur">
                            <p class="text-xs uppercase tracking-widest text-text-muted mb-2">Card preview</p>
                            <h3 class="text-xl font-semibold text-text-primary mb-1">Surface stack</h3>
                            <p class="text-sm text-text-muted">
                                Surfaces inherit from <span class="font-mono">surface-*</span> tokens while typography uses <span class="font-mono">text-*</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-border p-6 bg-surface-50 dark:bg-surface-100 space-y-5">
                    <p class="text-sm font-medium text-text-muted">Surface Ladder</p>
                    <h2 class="text-2xl font-semibold text-text-primary">
                        Light ⇄ Dark parity
                    </h2>
                    <div class="space-y-4">
                        <div v-for="color in paletteGroups[1].colors" :key="color.name" class="flex items-center gap-3">
                            <div :class="['h-12 w-12 rounded-xl border border-border shadow-sm', color.class]"></div>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-text-primary">{{ color.name }}</span>
                                <span class="text-xs font-mono text-text-muted">--{{ color.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Palettes -->
            <section v-for="group in paletteGroups" :key="group.name" class="space-y-4">
                <div>
                    <h2 class="text-2xl font-semibold text-text-primary">
                        {{ group.name }}
                    </h2>
                    <p class="text-sm text-text-muted max-w-2xl">
                        {{ group.description }}
                    </p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4">
                    <div v-for="color in group.colors" :key="color.name" class="space-y-2">
                        <div
                            :class="[
                                'w-full aspect-square rounded-xl shadow-sm transition-colors duration-200 border',
                                color.class,
                                color.border || 'border-border',
                            ]"
                        >
                            <div
                                :class="[
                                    'h-full flex items-center justify-center text-xs font-mono font-semibold p-2 text-center',
                                    color.text,
                                ]"
                            >
                                {{ color.name }}
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-text-primary">{{ color.name }}</p>
                            <p class="text-xs text-text-muted font-mono mt-1">--{{ color.name }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- System tokens -->
            <section class="space-y-4">
                <div>
                    <h2 class="text-2xl font-semibold text-text-primary">
                        System Tokens
                    </h2>
                    <p class="text-sm text-text-muted">
                        Typography, borders, and focus states derive directly from the surface hue for guaranteed contrast.
                    </p>
                </div>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="token in systemTokens"
                        :key="token.name"
                        class="rounded-2xl border border-border p-4 bg-white/70 dark:bg-black/10 backdrop-blur"
                    >
                        <p class="text-xs font-mono uppercase tracking-[0.2em] text-text-muted mb-2">
                            --{{ token.name }}
                        </p>
                        <h3 class="text-base font-semibold text-text-primary">
                            {{ token.label }}
                        </h3>
                        <p class="text-sm text-text-muted mb-4">
                            {{ token.description }}
                        </p>
                        <div v-if="token.type === 'text'" class="h-20 rounded-xl flex flex-col items-center justify-center bg-surface-100 dark:bg-surface-50">
                            <span :class="['text-4xl font-semibold leading-none', token.textClass]">Aa</span>
                            <span :class="['text-xs font-mono mt-1', token.textClass]">Sample</span>
                        </div>
                        <div v-else-if="token.type === 'border'" class="h-20 rounded-xl flex items-center justify-center bg-surface-50 dark:bg-surface-100">
                            <div :class="['h-12 w-full rounded-lg bg-white/70 dark:bg-black/30', token.borderClass]"></div>
                        </div>
                        <div v-else-if="token.type === 'ring'" class="h-20 rounded-xl flex items-center justify-center bg-surface-100 dark:bg-surface-50">
                            <div :class="['h-10 w-10 rounded-full bg-white dark:bg-black/40', token.ringClass]"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Usage -->
            <section class="p-6 rounded-2xl border border-border bg-surface-50 dark:bg-surface-100 space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <h3 class="text-lg font-semibold text-text-primary">
                        How to customize
                    </h3>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800 border border-border">
                        single-source of truth
                    </span>
                </div>
                <p class="text-sm text-text-muted">
                    Update <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">--primary-h</code>, <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">--primary-s</code>, <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">--primary-l</code>, and <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">--surface-l</code> inside <strong>resources/css/app.css</strong>. All Tailwind utilities (e.g. <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">bg-primary-500</code>, <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">text-text-primary</code>, <code class="px-2 py-1 rounded bg-white/70 dark:bg-black/20 font-mono">ring-ring</code>) automatically update.
                </p>
            </section>
        </div>
    </AppLayout>
</template>