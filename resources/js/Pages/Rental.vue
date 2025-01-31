<script setup>
import HomeNavigation from '@/Components/HomeNavigation.vue'
import { Head, Link } from '@inertiajs/vue3'
import Svg from '@/Components/Svg.vue'
import placeholderImage from '../../../public/images/placeholder.webp'
import Footer from '@/Components/Footer.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    rental: Object,
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head :title="rental?.title" />

    <HomeNavigation :can-login :can-register />

    <section
        class="relative z-10 w-full bg-hero-bg bg-cover bg-left-bottom before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:bg-slate-700/95"
    >
        <div class="mx-auto max-w-6xl py-20 text-center text-white">
            <h2 class="mx-auto w-3/4 text-3xl font-bold leading-normal">{{ rental?.title }}</h2>
            <p class="mt-3 text-xl font-semibold">{{ rental?.location?.city }}, {{ rental?.location?.country }}</p>
        </div>
    </section>
    <div class="mx-auto mt-14 max-w-6xl">
        <div class="flex justify-center">
            <template v-if="!rental.images">
                <img
                    :src="placeholderImage"
                    alt=""
                    class="h-[460px] w-full bg-slate-100 object-cover transition-all group-hover:scale-105"
                />
            </template>
            <template v-if="rental?.images && rental?.images.length === 1">
                <img
                    :src="rental.images[0]"
                    alt=""
                    class="h-[560px] w-full bg-slate-100 object-cover transition-all group-hover:scale-105"
                />
            </template>
            <template v-if="rental?.images?.length === 2">
                <div class="mt-4 flex h-96 gap-10 overflow-hidden">
                    <div v-for="image in rental.images" :key="`rental-img-${rental - id}`" class="bg-slate-100">
                        <img :src="image" alt="" class="w-full object-cover" />
                    </div>
                </div>
            </template>
        </div>
        <template v-if="rental?.images?.length > 2">
            <div class="mt-4 flex flex-wrap">
                <div
                    v-for="(image, key) in rental.images"
                    :key="`rental-img-${rental - id}`"
                    class="bg-slate-100 p-4"
                    :class="{ 'h-[460px] w-full': key == 0, 'w-1/3': key !== 0 }"
                >
                    <img :src="image" alt="" class="h-full w-full object-cover" />
                </div>
            </div>
        </template>
    </div>

    <div class="mx-auto mb-16 mt-10 grid max-w-6xl grid-cols-3 gap-10">
        <div class="col-span-1 border p-5 shadow-md">
            <h4 class="text-xl font-medium">Facilities We Provide</h4>
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
        </div>
        <div class="col-span-2 border border-slate-200 p-5 shadow-md">
            <div class="mt-3 space-y-5">
                <div class="flex border border-b p-2">
                    <span class="mr-auto text-lg font-semibold">Price: </span>
                    <span class="text-sm">$</span>
                    <span class="text-lg font-semibold">{{ rental.price.toFixed(2) }}</span>
                    <span class="self-end text-sm">/night</span>
                </div>
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
                <div>
                    <Link :href="route('bookings.availability', rental.id)">
                        <PrimaryButton>Book Now</PrimaryButton>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped></style>
