<script setup>
import DateRangePicker from '@/Components/DateRangePicker.vue'
import Footer from '@/Components/Footer.vue'
import HomeNavigation from '@/Components/HomeNavigation.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import RentalItem from '@/Components/RentalItem.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import SelectInput from '@/Components/SelectInput.vue'
import Svg from '@/Components/Svg.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    rentals: Array,
    cities: Array,
})

const form = useForm({
    city: '',
    checkInDate: '',
    checkOutDate: '',
    total_guests: '',
})

const submitSearch = () => {
    form.get(route('search'), {
        preserveState: true,
    })
}
</script>

<template>
    <Head title="Home" />

    <HomeNavigation :can-login :can-register />

    <main>
        <section
            class="relative z-10 w-full bg-hero-bg bg-cover bg-left-bottom before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:bg-slate-700/95"
        >
            <div class="mx-auto grid max-w-6xl grid-cols-8 items-center justify-between gap-6 py-24">
                <div class="col-span-4">
                    <h2 class="text-5xl font-bold leading-snug text-slate-100">
                        Book & Experience <br />
                        Amazing Places
                    </h2>
                    <h3 class="mb-10 mt-4 text-lg text-slate-100">
                        A Laravel Application for Booking management for Rental according to locations
                    </h3>
                    <div>
                        <Link :href="route('search')">
                            <SecondaryButton class="font-bold">Book Your next trip</SecondaryButton>
                        </Link>
                    </div>
                </div>
                <div class="col-span-3 col-start-6 rounded-xl bg-white p-8 shadow-md">
                    <h2 class="mb-3 text-2xl font-bold capitalize text-slate-700">Find your perfect place</h2>
                    <div class="flex flex-col gap-4">
                        <div>
                            <SelectInput
                                v-model="form.city"
                                :options="cities"
                                label="Choose Destination"
                                icon="location"
                            />
                        </div>
                        <div class="flex gap-5">
                            <div class="w-full">
                                <InputLabel class="mb-2.5 block text-sm/6 font-medium text-gray-900"
                                    >Choose Dates</InputLabel
                                >
                                <DateRangePicker
                                    v-model:checkInDate="form.checkInDate"
                                    v-model:checkOutDate="form.checkOutDate"
                                />
                            </div>
                        </div>
                        <div>
                            <InputLabel class="mb-2.5 block text-sm/6 font-medium text-gray-900">Who</InputLabel>
                            <input
                                v-model="form.total_guests"
                                id="guest"
                                type="number"
                                class="h-[38px] w-full rounded border border-slate-300 transition placeholder:text-sm placeholder:text-slate-400 hover:border-slate-400"
                                placeholder="Add Guests"
                            />
                        </div>
                        <div>
                            <PrimaryButton @click="submitSearch">Search</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-center text-3xl font-bold text-slate-600">Find a Place That Fits Your Comfort</h2>
                <div class="mt-10 grid grid-cols-3 gap-8">
                    <Link
                        :href="route('search', { category: 'apartment' })"
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="apartment" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Apartment</h4>
                    </Link>
                    <Link
                        :href="route('search', { category: 'hotel' })"
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="hotel" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Hotel</h4>
                    </Link>
                    <Link
                        :href="route('search', { category: 'guest_house' })"
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="home" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Guesthouse</h4>
                    </Link>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-24">
            <div class="mx-auto max-w-6xl">
                <div class="mb-16 text-center">
                    <h2 class="text-center text-3xl font-bold text-slate-600">Featured Places</h2>
                    <p class="mt-2 text-lg">Hand-picked selection of quality places</p>
                </div>
                <div class="grid grid-cols-3 gap-10">
                    <RentalItem v-for="rental in rentals" :key="`rental-${rental.id}`" :rental />
                </div>
            </div>
            <div class="pt-28 text-center">
                <h3 class="mb-5 text-3xl font-semibold text-slate-700">Want to see more available options?</h3>
                <Link :href="route('search')">
                    <PrimaryButton>Continue Exploring</PrimaryButton>
                </Link>
            </div>
        </section>
    </main>
    <Footer />
</template>
