<script setup>
import { Link } from '@inertiajs/vue3'
import PrimaryButton from './PrimaryButton.vue'
import Svg from './Svg.vue'

const props = defineProps({
    rental: {
        Type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="group gap-8 overflow-hidden rounded shadow-lg transition-all hover:shadow-xl">
        <div class="relative z-20 h-64 overflow-hidden">
            <span class="absolute z-10 h-full w-full bg-black/20 transition-all group-hover:bg-black/15"></span>
            <img
                src="https://royhridoy.me/html/royme-preview/assets/img/portfolio/6.jpg"
                alt=""
                class="h-full w-full object-cover transition-all group-hover:scale-105"
            />
            <div class="absolute bottom-0 left-0 z-20 flex rounded-tr-sm bg-slate-800 px-5 text-white">
                <span class="text-sm">$</span>
                <span class="text-2xl font-semibold">350.00</span>
                <span class="self-end text-sm">/night</span>
            </div>
            <div class="absolute right-3 top-2 z-20 rounded bg-white px-1.5 font-semibold text-slate-800">
                <div class="flex items-center gap-1">
                    <Svg name="star" class="size-4"></Svg>
                    <span>4.89</span>
                </div>
            </div>
        </div>
        <div class="rounded-b border border-t-0 border-slate-300 p-5">
            <h3 class="text-xl font-semibold">
                <a href="" class="hover:text-slate-600"> Test ste do do daf Lorem ipsum dolor sit amet dfaso sofdi. </a>
            </h3>
            <p class="mt-0.5 text-sm text-slate-500">Address info line 1</p>
            <ul class="mt-5 grid grid-cols-2 gap-1">
                <li class="flex items-center gap-1">
                    <Svg name="users" class="size-4"></Svg>
                    <span>3 Guests</span>
                </li>
                <li class="flex items-center justify-end gap-1">
                    <Svg name="users" class="size-4"></Svg>
                    <span>Wifi available</span>
                </li>
                <li class="flex items-center gap-1">
                    <Svg name="users" class="size-4"></Svg>
                    <span>Swimming poll</span>
                </li>
            </ul>
            <div class="mt-4">
                <Link :href="route('bookings.checkout', rental.id)">
                    <PrimaryButton>Book Now</PrimaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
