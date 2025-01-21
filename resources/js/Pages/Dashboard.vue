<script setup>
import NavLink from '@/Components/NavLink.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-8">
                    <div class="col-span-1 bg-white p-6 shadow-sm sm:rounded-lg">
                        <ul class="flex flex-col space-y-2">
                            <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')"
                                >Profile</NavLink
                            >
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
                                >Bookings</NavLink
                            >
                        </ul>
                    </div>
                    <div class="col-span-3 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">You're logged in!</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
