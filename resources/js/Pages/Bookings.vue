<script setup>
import BookingItem from '@/Components/BookingItem.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    bookings: {
        type: Array,
        required: true,
    },
    message: {
        type: String,
        required: false,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Your Bookings</h2>
        </template>

        <div v-if="message" class="flex items-center justify-center">
            <div class="mb-5 inline-block rounded-md bg-green-300 px-3 py-1 font-semibold text-green-900">
                {{ message }}
            </div>
        </div>
        <div class="grid grid-cols-2 gap-5">
            <BookingItem v-for="booking in bookings" :key="`booking-${booking.id}`" :booking />
        </div>
    </AuthenticatedLayout>
</template>
