<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from './ApplicationLogo.vue'
const currentYear = new Date().getFullYear()
</script>

<template>
    <footer class="bg-white shadow-2xl">
        <div class="mx-auto w-full max-w-screen-xl p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <Link :href="route('home')">
                    <ApplicationLogo />
                </Link>
                <ul class="mb-6 flex flex-wrap items-center text-sm font-medium text-gray-600 sm:mb-0">
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm text-gray-700 sm:text-center"
                >© {{ currentYear }} <Link :href="route('home')" class="hover:underline">Haven Hopper</Link>. All
                Rights Reserved.</span
            >
        </div>
    </footer>
</template>

<style scoped></style>
