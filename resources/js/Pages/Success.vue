<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Booking Confirmed" />
    <AuthenticatedLayout>
        <div class="text-center">
            <div class="mx-auto mb-5 w-3/5 rounded-md bg-green-100 px-3 py-2 text-center font-bold text-green-900">
                You have successfully booked the rental
            </div>
            <Link
                :href="route('bookings.index')"
                class="rounded-md bg-teal-700 px-5 py-2 font-bold text-white transition hover:bg-teal-800"
                >See all Bookings</Link
            >
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
