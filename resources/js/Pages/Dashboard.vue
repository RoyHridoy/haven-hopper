<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="p-6 text-gray-900">
            Welcome! <span class="font-medium"> {{ $page.props.auth.user.name }}</span>
        </div>
    </AuthenticatedLayout>
</template>
