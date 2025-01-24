<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Svg from '@/Components/Svg.vue'
import TextInput from '@/Components/TextInput.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    rental: {},
})

const form = useForm({
    check_in_date: '',
    check_out_date: '',
})

const checkAvailability = () => {
    router.post(route('bookings.availabilityValidate', props.rental.id), form, {
        onError: (errors) => {
            form.errors = errors
        },
        onSuccess: () => {
            form.errors = {}
        },
    })
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
                <div class="mt-2">
                    <div class="flex border-b border-t py-2">
                        <span class="mr-auto text-lg font-semibold">Price: </span>
                        <span class="text-sm">$</span>
                        <span class="text-lg font-semibold">{{ rental.price.toFixed(2) }}</span>
                        <span class="self-end text-sm">/night</span>
                    </div>
                    <ul class="mt-3 grid grid-cols-1 gap-1 text-slate-700">
                        <li class="flex items-center gap-1.5 capitalize">
                            <Svg name="users" class="size-4"></Svg>
                            <span>{{ rental.totalGuests }} guests</span>
                        </li>
                        <li
                            v-for="amenity in rental.amenities"
                            :key="`amenity-${amenity.id}`"
                            class="flex items-center gap-1.5 capitalize"
                        >
                            <Svg name="feature" class="size-3.5"></Svg>
                            <span>{{ amenity.name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </template>

        <section class="bg-white antialiased">
            <form @submit.prevent="checkAvailability" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                    <div class="min-w-0 flex-1 space-y-8">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="flex w-full flex-col">
                                    <InputLabel for="checkInDate" value="Check In Date" />

                                    <TextInput
                                        id="checkInDate"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.check_in_date"
                                        autocomplete="date"
                                    />

                                    <InputError class="mt-2" :message="form.errors.check_in_date" />
                                </div>

                                <div class="flex w-full flex-col">
                                    <InputLabel for="checkOutDate" value="Check Out Date" />

                                    <TextInput
                                        id="checkOutDate"
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.check_out_date"
                                        autocomplete="date"
                                    />
                                    <InputError class="mt-2" :message="form.errors.check_out_date" />
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="flex items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                            >
                                Check Availability
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </AuthenticatedLayout>
</template>
