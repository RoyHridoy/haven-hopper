<script setup>
import DateRangePicker from '@/Components/DateRangePicker.vue'
import InputError from '@/Components/InputError.vue'
import Svg from '@/Components/Svg.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    rental: {},
})

const isAvailable = ref(false)

const form = useForm({
    check_in_date: '',
    check_out_date: '',
    rental_id: props.rental.id,
})

const checkAvailability = () => {
    router.post(route('bookings.availabilityValidate', props.rental.id), form, {
        onError: (errors) => {
            form.errors = errors
            isAvailable.value = false
        },
        onSuccess: () => {
            form.errors = {}
            isAvailable.value = true
        },
    })
}

const goToCheckout = () => {
    router.get(
        route('bookings.checkout', {
            rental: props.rental.id,
            checkInDate: form.check_in_date,
            checkOutDate: form.check_out_date,
        }),
    )
}
</script>

<template>
    <Head title="Booking Availability" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Check Available Date</h2>
        </template>

        <template #sidebar>
            <h2 class="mb-3 flex items-center gap-0.5 text-xl font-bold leading-tight text-gray-800">
                <Svg name="check-round" class="size-6"></Svg>
                Rental Info
            </h2>
            <h3 class="text-lg font-medium">{{ rental.title }}</h3>
            <p class="text-sm">{{ rental.location.city }}, {{ rental.location.country }}</p>
            <div class="w-full space-y-6 lg:max-w-xs xl:max-w-md">
                <div class="mt-3 space-y-5">
                    <div class="flex border border-b p-2">
                        <span class="mr-auto text-lg font-semibold">Price: </span>
                        <span class="text-sm">$</span>
                        <span class="text-lg font-semibold">{{ rental.price.toFixed(2) }}</span>
                        <span class="self-end text-sm">/night</span>
                    </div>
                    <ul class="mt-3 grid grid-cols-1 gap-1 divide-y border text-slate-700">
                        <li class="flex items-center gap-1.5 p-1.5 capitalize">
                            <Svg name="users" class="size-4"></Svg>
                            <span>{{ rental.totalGuests }} guests</span>
                        </li>
                        <li
                            v-for="amenity in rental.amenities"
                            :key="`amenity-${amenity.id}`"
                            class="flex items-center gap-1.5 p-1.5 capitalize"
                        >
                            <Svg name="feature" class="size-3.5"></Svg>
                            <span>{{ amenity.name }}</span>
                        </li>
                    </ul>
                    <div class="divide-y border text-sm">
                        <p class="flex justify-between p-2">
                            <span>Check in Time:</span>
                            <span class="font-medium">{{ rental.checkInTime }}</span>
                        </p>
                        <p class="flex justify-between p-2">
                            <span>Check out Time:</span>
                            <span class="font-medium">{{ rental.checkOutTime }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </template>

        <section class="bg-white antialiased">
            <div
                class="mx-auto mb-5 w-3/5 rounded-md bg-green-100 px-3 py-2 text-center font-bold text-green-900"
                v-if="isAvailable"
            >
                This rental is available for booking.
            </div>
            <div class="mx-auto grid max-w-screen-xl grid-cols-4 px-4 2xl:px-0">
                <div class="col-span-2 col-start-2 space-y-4">
                    <div class="">
                        <DateRangePicker
                            v-model:checkInDate="form.check_in_date"
                            v-model:checkOutDate="form.check_out_date"
                        />
                        <InputError class="mt-2" :message="form.errors.check_in_date" />
                        <InputError class="mt-2" :message="form.errors.check_out_date" />
                    </div>
                    <div class="flex gap-4">
                        <button
                            @click="checkAvailability"
                            type="button"
                            class="flex items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                        >
                            Check Availability
                        </button>

                        <div v-if="isAvailable">
                            <button
                                @click="goToCheckout"
                                type="button"
                                class="flex items-center justify-center rounded-lg bg-green-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                            >
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
