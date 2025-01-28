<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import Svg from '@/Components/Svg.vue'
</script>

<template>
    <GuestLayout>
        <Head title="Become a Host" />

        <div class="mb-3 text-center">
            <h3
                class="mb-5 inline-block border-b-4 border-double border-slate-500 px-3 text-xl font-bold text-slate-600"
            >
                Become a Host
            </h3>
        </div>
        <ul class="flex flex-col gap-6">
            <li>
                <p
                    class="inline-flex items-center gap-1.5 rounded bg-slate-500 px-1 text-sm font-medium uppercase tracking-wide text-white"
                >
                    <Svg name="check-round" class="size-4"></Svg>Step: 01
                </p>
                <p class="font-medium">At first, You have to register as an user</p>
            </li>
            <li>
                <p
                    class="inline-flex items-center gap-1.5 rounded bg-slate-500 px-1 text-sm font-medium uppercase tracking-wide text-white"
                >
                    <Svg name="check-round" class="size-4"></Svg>Step: 02
                </p>
                <p class="font-medium">Verify your email address</p>
            </li>
            <li>
                <p
                    class="inline-flex items-center gap-1.5 rounded bg-slate-500 px-1 text-sm font-medium uppercase tracking-wide text-white"
                >
                    <Svg name="check-round" class="size-4"></Svg>Step: 03
                </p>
                <p class="font-medium">You will find <b>Become a Host</b> button in the dashboard</p>
            </li>
            <li>
                <p
                    class="inline-flex items-center gap-1.5 rounded bg-slate-500 px-1 text-sm font-medium uppercase tracking-wide text-white"
                >
                    <Svg name="check-round" class="size-4"></Svg>Step: 04
                </p>
                <p class="font-medium">Fill up necessary requirements and wait for admin approval</p>
            </li>
        </ul>
        <div class="mt-5 text-center">
            <Link
                :href="route('register')"
                class="inline-flex items-center justify-center gap-2 rounded bg-slate-500 px-4 py-2 text-sm font-semibold uppercase tracking-wide text-white transition-colors hover:bg-slate-700"
            >
                Go to first Step
                <Svg name="right-arrow" class="size-4"></Svg>
            </Link>
        </div>
    </GuestLayout>
</template>
