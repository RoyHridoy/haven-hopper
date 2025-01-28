<script setup>
import BookingItem from '@/Components/BookingItem.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    bookings: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Your Bookings</h2>
        </template>

        <div class="grid grid-cols-2 gap-5">
            <BookingItem v-for="booking in bookings" :key="`booking-${booking.id}`" :booking />
        </div>
    </AuthenticatedLayout>
</template>
