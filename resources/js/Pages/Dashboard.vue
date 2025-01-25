<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    message: {
        Type: String,
    },
})
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

        <div v-if="message" class="flex items-center justify-center">
            <div class="mb-5 inline-block rounded-md bg-green-300 px-3 py-1 font-semibold text-green-900">
                {{ message }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
