<script setup>
defineProps({
    booking: {
        Type: Object,
        required: true,
    },
})

const bookingStatusClasses = {
    pending: 'bg-yellow-300 text-yellow-900',
    approved: 'bg-green-300 text-green-900',
    completed: 'bg-blue-300 text-blue-900',
    rejected: 'bg-red-300 text-red-900',
    cancelled: 'bg-orange-300 text-orange-900',
}

const paymentStatusClasses = {
    paid: 'bg-green-600',
    pending: 'bg-yellow-600',
    failed: 'bg-red-600',
}
</script>

<template>
    <div
        class="relative flex flex-col justify-between rounded border px-3 py-2 shadow-sm transition-all hover:shadow-lg"
    >
        <h3 class="me-20 line-clamp-2 text-xl font-medium" :title="booking.rental.title">{{ booking.rental.title }}</h3>
        <div>
            <p
                class="absolute right-3 top-2 rounded px-2 text-xs font-bold uppercase"
                :class="bookingStatusClasses[booking.bookingStatus]"
            >
                {{ booking.bookingStatus }}
            </p>

            <div class="mt-2 grid grid-cols-2 items-center gap-x-1 gap-y-1.5 border-b pb-2.5 text-sm">
                <p class="">
                    Check In: <span class="rounded-sm bg-slate-300 px-1">{{ booking.checkInDate }}</span>
                </p>
                <p class="text-right">
                    Check Out: <span class="rounded-sm bg-slate-300 px-1">{{ booking.checkOutDate }}</span>
                </p>
                <p class="">
                    Rental type: <span>{{ booking.rental.type }}</span>
                </p>
                <p class="text-right">
                    Payment Status:
                    <span
                        class="rounded px-1 text-xs font-semibold capitalize text-white"
                        :class="paymentStatusClasses[booking.paymentStatus]"
                        >{{ booking.paymentStatus }}</span
                    >
                </p>
                <p class="">
                    Total Guests: <span>{{ booking.totalGuests }}</span>
                </p>
            </div>
            <div class="mt-3 space-y-1 text-sm">
                <p class="flex items-center justify-between">
                    Price:
                    <span><span class="relative -top-0.5 text-xs">$</span>{{ booking.price }}</span>
                </p>
                <p class="flex items-center justify-between">
                    Tax:
                    <span><span class="relative -top-0.5 text-xs">$</span>{{ booking.tax }}</span>
                </p>
                <p class="flex items-center justify-between">
                    Discount:
                    <span><span class="relative -top-0.5 text-xs">$</span>{{ booking.discount }}</span>
                </p>
                <p class="flex items-center justify-between">
                    Total price:
                    <span><span class="relative -top-0.5 text-xs">$</span>{{ booking.totalPrice }}</span>
                </p>
            </div>
        </div>
    </div>
</template>
