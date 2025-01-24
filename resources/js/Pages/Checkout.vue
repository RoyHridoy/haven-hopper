<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Svg from '@/Components/Svg.vue'
import TextInput from '@/Components/TextInput.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    rental: {},
    checkInDate: {
        type: String,
        required: true,
    },
    checkOutDate: {
        type: String,
        required: true,
    },
    tax: {
        type: Number,
        default: 0,
    },
})

const form = useForm({
    check_in_date: props.checkInDate,
    check_out_date: props.checkOutDate,
    user_name: usePage().props.auth.user.name,
    user_email: usePage().props.auth.user.email,
    user_phone: usePage().props.auth.user.phone,
    total_price: props.rental.totalPrice,
    total_guests: props.rental.totalGuests,
})

const bookNow = () => {
    router.post(route('bookings.checkout', props.rental.id), form, {
        onError: (errors) => {
            form.errors = errors
        },
    })
}
</script>

<template>
    <Head title="Checkout" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Checkout details</h2>
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
                    <div class="divide-y border-b border-t">
                        <div class="flex py-2">
                            <span class="mr-auto font-medium">Check In Date: </span>
                            <span class="font-medium">{{ form.check_in_date }}</span>
                        </div>
                        <div class="flex py-2">
                            <span class="mr-auto font-medium">Check Out Date: </span>
                            <span class="font-medium">{{ form.check_out_date }}</span>
                        </div>
                        <div class="flex py-2">
                            <span class="mr-auto font-medium">Rental Type: </span>
                            <span class="font-medium">{{ rental.type.toString().split('_').join(' ') }}</span>
                        </div>
                        <div class="flex py-2">
                            <span class="mr-auto font-medium">Guests: </span>
                            <span class="font-medium">{{ rental.totalGuests }}</span>
                        </div>
                    </div>
                    <h3 class="mt-5 font-medium">Other Benefits</h3>
                    <ul class="mt-1 grid grid-cols-1 gap-1 text-slate-700">
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

        <section class="space-y-8 bg-white antialiased">
            {{ form }}
            <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                <div class="min-w-0 flex-1 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900">Billing Address</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <InputLabel for="userName" value="Name" />

                                <TextInput
                                    id="userName"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.user_name"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.user_name" />
                            </div>

                            <div>
                                <InputLabel for="userEmail" value="Email" />

                                <TextInput
                                    id="userEmail"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.user_email"
                                    required
                                    autocomplete="email"
                                />

                                <InputError class="mt-2" :message="form.errors.user_email" />
                            </div>

                            <div>
                                <InputLabel for="userPhone" value="Phone" />

                                <TextInput
                                    id="userPhone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                    v-model="form.user_phone"
                                    required
                                    autocomplete="phone"
                                />

                                <InputError class="mt-2" :message="form.errors.user_phone" />
                            </div>

                            <div>
                                <InputLabel for="totalGuests" value="Total Guests" />

                                <TextInput
                                    id="totalGuests"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.total_guests"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.total_guests" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full space-y-3">
                <h2 class="text-xl font-semibold text-gray-900">Payment Details</h2>
                <div class="mt-4">
                    <div class="divide-y divide-gray-200">
                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Price</dt>
                            <dd class="text-base font-medium text-gray-900">$ {{ rental.price.toFixed(2) }}</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Discount</dt>
                            <dd class="text-base font-medium text-green-500">0</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Tax</dt>
                            <dd class="text-base font-medium text-gray-900">{{ props.tax }}</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900">Total</dt>
                            <dd class="text-base font-bold text-gray-900">${{ rental.price.toFixed(2) }}</dd>
                        </dl>
                    </div>
                </div>
                <button
                    @click="bookNow"
                    type="button"
                    class="flex items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                >
                    Proceed to Payment
                </button>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
