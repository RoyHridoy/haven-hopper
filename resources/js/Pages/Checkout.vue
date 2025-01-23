<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Svg from '@/Components/Svg.vue'
import TextInput from '@/Components/TextInput.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    rental: {},
})

const form = useForm({
    name: '',
    email: '',
    phone: '',
    totalGuests: '1',
    remember: false,
})
</script>

<template>
    <Head title="Checkout" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Checkout details</h2>
        </template>
        {{ rental.location }}
        <template #sidebar>
            <h2 class="flex items-center gap-0.5 text-xl font-bold leading-tight text-gray-800">
                <Svg name="check-round" class="size-6"></Svg>
                Payment Summary
            </h2>
            <div class="w-full space-y-6 lg:max-w-xs xl:max-w-md">
                <div class="mt-4">
                    <div class="divide-y divide-gray-200">
                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Price</dt>
                            <dd class="text-base font-medium text-gray-900">$8,094.00</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Discount</dt>
                            <dd class="text-base font-medium text-green-500">0</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-normal text-gray-500">Tax</dt>
                            <dd class="text-base font-medium text-gray-900">$199</dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900">Total</dt>
                            <dd class="text-base font-bold text-gray-900">$8,392.00</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </template>

        <section class="bg-white antialiased">
            {{ rental }}
            <form action="#" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                    <div class="min-w-0 flex-1 space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-900">Billing Details</h2>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <InputLabel for="name" value="Name" />

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        autocomplete="username"
                                    />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                        autocomplete="email"
                                    />

                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>

                                <div>
                                    <InputLabel for="phone" value="Phone" />

                                    <TextInput
                                        id="phone"
                                        type="tel"
                                        class="mt-1 block w-full"
                                        v-model="form.phone"
                                        required
                                        autocomplete="phone"
                                    />

                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>

                                <div>
                                    <InputLabel for="totalGuests" value="Total Guests" />

                                    <TextInput
                                        id="totalGuests"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.totalGuests"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.totalGuests" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button
                                type="submit"
                                class="flex w-full items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                            >
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </AuthenticatedLayout>
</template>
