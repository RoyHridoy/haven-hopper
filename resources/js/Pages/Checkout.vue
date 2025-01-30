<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Svg from '@/Components/Svg.vue'
import TextInput from '@/Components/TextInput.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

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
    availablePaymentMethods: {
        type: Array,
        required: true,
    },
    totalPrice: Number,
    totalStay: Number,
})

const form = useForm({
    check_in_date: props.checkInDate,
    check_out_date: props.checkOutDate,
    user_name: usePage().props.auth.user.name,
    user_email: usePage().props.auth.user.email,
    billing_address: {
        country: '',
        city: '',
        state: '',
        address_line_one: '',
        address_line_two: '',
    },
    price: props.rental.price,
    total_price: props.totalPrice,
    total_guests: props.rental.totalGuests,
    paymentMethod: '',
    rental_id: props.rental.id,
})

const bookNow = () => {
    router.post(route('bookings.checkout', props.rental.id), form, {
        onError: (errors) => {
            form.errors = errors
            if (form.errors?.check_in_date) {
                useToast()('The selected date range is already booked.', { type: 'error' })
            }
        },
        onSuccess: () => {
            form.errors = {}
        },
        preserveScroll: true,
        preserveState: true,
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
            <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                <div class="min-w-0 flex-1 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900">Billing Address</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <InputLabel for="user_name" value="Name" />

                                <TextInput
                                    id="user_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.user_name"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.user_name" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.user_email"
                                    required
                                    autocomplete="email"
                                />

                                <InputError class="mt-2" :message="form.errors.user_email" />
                            </div>

                            <div>
                                <InputLabel for="country" value="Country" />

                                <TextInput
                                    id="country"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.billing_address.country"
                                    required
                                    autocomplete="country"
                                />

                                <InputError class="mt-2" :message="form.errors.country" />
                            </div>

                            <div>
                                <InputLabel for="city" value="City" />

                                <TextInput
                                    id="city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.billing_address.city"
                                    required
                                    autocomplete="city"
                                />

                                <InputError class="mt-2" :message="form.errors.city" />
                            </div>

                            <div>
                                <InputLabel for="state" value="State" />

                                <TextInput
                                    id="state"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.billing_address.state"
                                    required
                                    autocomplete="state"
                                />

                                <InputError class="mt-2" :message="form.errors.state" />
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

                            <div>
                                <InputLabel for="addressLineOne" value="Address Line 1" />

                                <TextInput
                                    id="addressLineOne"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.billing_address.address_line_one"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.address_line_one" />
                            </div>

                            <div>
                                <InputLabel for="addressLineTwo" value="Address Line 1" />

                                <TextInput
                                    id="addressLineTwo"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.billing_address.address_line_two"
                                />

                                <InputError class="mt-2" :message="form.errors.address_line_two" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full space-y-5 border-t pt-5">
                <h2 class="text-xl font-semibold text-gray-900">Payment Details</h2>
                <div class="divide-y divide-gray-200">
                    <dl class="flex items-center justify-between gap-4 py-3">
                        <dt class="text-base font-normal text-gray-500">Price</dt>
                        <dd class="text-base font-medium text-gray-900">
                            {{ `${totalStay} x ` }} $ {{ rental.price.toFixed(2) }}
                        </dd>
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
                        <dt class="text-base font-bold text-gray-900">Total Price</dt>
                        <dd class="text-base font-bold text-gray-900">${{ totalPrice.toFixed(2) }}</dd>
                    </dl>
                </div>
            </div>

            <div class="space-y-4 border-t pt-5">
                <h3 class="text-xl font-semibold text-gray-900">Choose Payment Method</h3>
                <div class="max-w-sm">
                    <select
                        id="paymentMethod"
                        v-model="form.paymentMethod"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option
                            v-for="paymentMethod in availablePaymentMethods"
                            :key="`payment-method-${paymentMethod.name}`"
                            :value="paymentMethod.value"
                        >
                            {{ paymentMethod.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.paymentMethod" />
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
