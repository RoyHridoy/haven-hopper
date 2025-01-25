<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import RentalItem from '@/Components/RentalItem.vue'
import Svg from '@/Components/Svg.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    rentals: {
        type: Array,
    },
})
</script>

<template>
    <Head title="Home" />
    <header class="border-b shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between">
            <div>
                <h2 class="my-5 text-3xl font-bold text-slate-800">
                    <Link :href="route('home')">
                        <ApplicationLogo />
                    </Link>
                </h2>
            </div>
            <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class=""> Dashboard </Link>

                <template v-else>
                    <div class="flex items-center justify-between gap-4">
                        <Link
                            :href="route('login')"
                            class="px-4 py-2 font-bold text-slate-500 transition hover:text-slate-700"
                        >
                            Log in
                        </Link>

                        <span class="mt-1 size-2.5 rounded-full bg-slate-500"></span>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-4 py-2 font-bold text-slate-500 transition hover:text-slate-700"
                        >
                            Register
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('host.index')"
                            class="rounded-sm border border-slate-300 px-4 py-2 font-bold text-slate-500 transition hover:border-slate-400 hover:text-slate-700"
                        >
                            Become a Host</Link
                        >
                    </div>
                </template>
            </nav>
        </div>
    </header>
    <main>
        <section
            class="relative z-10 w-full bg-hero-bg bg-cover bg-left-bottom before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:bg-slate-950/50"
        >
            <div class="mx-auto grid max-w-6xl grid-cols-8 items-center justify-between gap-6 py-24">
                <div class="col-span-4 col-start-2 rounded-xl bg-white p-10 shadow-md">
                    <h2 class="text-3xl font-bold text-slate-700">
                        Book & Experience <br />
                        Amazing Places
                    </h2>
                    <h3 class="my-6 text-lg">A Laravel Application for Booking and Rental</h3>
                    <div class="flex flex-col gap-4">
                        <div>
                            <select class="w-full rounded-sm border-slate-300 text-slate-600">
                                <option value="location-1" disabled selected>Select Location</option>
                                <option value="location-2">Location 2</option>
                                <option value="location-3">Location 3</option>
                                <option value="location-4">Location 4</option>
                            </select>
                        </div>
                        <div class="flex gap-5">
                            <div class="flex w-full flex-col">
                                <label for="startDate" class="mb-1">Arrive:</label>
                                <input type="date" id="startDate" class="rounded-sm border-slate-300 text-slate-600" />
                            </div>
                            <div class="flex w-full flex-col">
                                <label for="endDate" class="mb-1">Depart:</label>
                                <input type="date" id="endDate" class="rounded-sm border-slate-300 text-slate-600" />
                            </div>
                        </div>
                        <div>
                            <input
                                type="number"
                                class="w-full rounded-sm border border-slate-300"
                                placeholder="Number of guests"
                            />
                        </div>
                        <div>
                            <PrimaryButton>Search</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-center text-3xl font-bold text-slate-600">Find a Place That Fits Your Comfort</h2>
                <div class="mt-10 grid grid-cols-3 gap-8">
                    <a
                        href=""
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="apartment" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Apartment</h4>
                    </a>
                    <a
                        href=""
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="hotel" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Hotel</h4>
                    </a>
                    <a
                        href=""
                        class="group flex flex-col items-center justify-center bg-slate-200 py-8 text-center shadow-2xl shadow-transparent transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-xl"
                    >
                        <div
                            class="border-t-1 flex size-20 items-center justify-center rounded-full border-b-4 border-l-2 border-r-2 border-slate-600 transition-all duration-200 group-hover:shadow-lg"
                        >
                            <Svg name="home" class="size-10"></Svg>
                        </div>
                        <h4 class="px-5 pt-3 text-xl font-semibold text-slate-800">Guesthouse</h4>
                    </a>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-24">
            <div class="mx-auto max-w-6xl">
                <div class="mb-16 text-center">
                    <h2 class="text-center text-3xl font-bold text-slate-600">Featured Homes</h2>
                    <p class="mt-2 text-lg">Hand-picked selection of quality places</p>
                </div>
                <div class="grid grid-cols-3 gap-10">
                    <RentalItem v-for="rental in rentals" :key="`rental-${rental.id}`" :rental />
                </div>
            </div>
        </section>
    </main>
</template>
