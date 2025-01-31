<script setup>
import { Link } from '@inertiajs/vue3'
import PrimaryButton from './PrimaryButton.vue'
import Svg from './Svg.vue'
import placeholderImage from '../../../public/images/placeholder.webp'

const props = defineProps({
    rental: {
        Type: Object,
    },
})
</script>

<template>
    <div class="group gap-8 overflow-hidden rounded shadow-lg transition-all hover:shadow-xl">
        <div class="relative z-20 h-64 overflow-hidden">
            <span class="absolute z-10 h-full w-full bg-black/20 transition-all group-hover:bg-black/15"></span>
            <template v-if="rental.images">
                <img
                    :src="rental.images[0]"
                    alt=""
                    class="h-full w-full object-cover transition-all group-hover:scale-105"
                />
            </template>
            <template v-if="!rental.images">
                <img
                    :src="placeholderImage"
                    alt=""
                    class="h-full w-full object-cover transition-all group-hover:scale-105"
                />
            </template>
            <div class="absolute bottom-0 left-0 z-20 flex rounded-tr-sm bg-slate-600 px-5 py-1 text-white">
                <span class="text-sm">$</span>
                <span class="text-2xl font-semibold">{{ rental.price.toFixed(2) }}</span>
                <span class="self-end text-sm">/night</span>
            </div>
            <div class="absolute right-3 top-2 z-20 rounded bg-white px-1.5 font-semibold text-slate-800">
                <div class="flex items-center gap-1">
                    <Svg name="star" class="size-4"></Svg>
                    <span>{{ rental.rating }}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col border-slate-300 p-5">
            <h3 class="text-xl font-semibold">
                <a href="" class="line-clamp-2 text-slate-700 hover:text-slate-500" :title="rental.title">
                    {{ rental.title }}
                </a>
            </h3>
            <div class="flex items-center gap-3.5">
                <p class="mt-0.5 text-sm text-slate-600">{{ rental.location.city }}, {{ rental.location.country }}</p>
                <span class="mt-0.5 h-3 w-0.5 rounded bg-slate-400"></span>
                <p class="mt-0.5 text-sm capitalize text-slate-600">
                    {{ rental.rentalType?.split('_').join(' ') || rental.rental_type?.split('_').join(' ') }}
                </p>
            </div>
            <ul class="mt-5 grid grid-cols-2 gap-1 text-slate-700">
                <li class="flex items-center gap-1.5 capitalize">
                    <Svg name="users" class="size-4"></Svg>
                    <span>{{ rental?.totalGuests || rental?.total_guests }} guests</span>
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
            <div class="mt-4">
                <Link :href="route('bookings.availability', rental.id)">
                    <PrimaryButton>Book Now</PrimaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
