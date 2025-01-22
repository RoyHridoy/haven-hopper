<script setup>
import NavLink from '@/Components/NavLink.vue'
import SidebarLink from '@/Components/SidebarLink.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">Your Bookings</h2>
        </template>

        <div class="grid grid-cols-2 gap-5">
            <div class="relative rounded border px-3 py-2 shadow-sm transition-all hover:shadow-lg">
                <h3 class="me-20 text-xl font-medium">Rental Title Goes here Title Goes here Title Goes here</h3>
                <!-- pending: bg-yellow-300 text-yellow-900 -->
                <!-- approved: bg-green-300 text-green-900 -->
                <!-- completed: bg-blue-300 text-blue-900 -->
                <!-- rejected: bg-red-300 text-red-900 -->
                <!-- canceled: bg-orange-300 text-orange-900 -->
                <p
                    class="absolute right-3 top-2 rounded bg-yellow-300 px-2 text-xs font-bold uppercase text-yellow-900"
                >
                    pending
                </p>
                <div class="mt-2 grid grid-cols-2 items-center gap-x-1 gap-y-1.5 border-b pb-2.5 text-sm">
                    <p class="">Check In: <span class="rounded-sm bg-slate-300 px-1">20-Jan-2025</span></p>
                    <p class="text-right">Check Out: <span class="rounded-sm bg-slate-300 px-1">25-Jan-2025</span></p>
                    <p class="">Rental type: <span>hotel</span></p>
                    <p class="text-right">
                        Payment Status:
                        <!-- paid: bg-green-600 -->
                        <!-- pending: bg-yellow-600 -->
                        <!-- failed: bg-red-600 -->
                        <span class="rounded bg-green-600 px-1 text-xs font-semibold text-white">Paid</span>
                    </p>
                </div>
                <div class="mt-3 space-y-1 text-sm">
                    <p class="flex items-center justify-between">
                        Price:
                        <span><span class="relative -top-0.5 text-xs">$</span>1049.00</span>
                    </p>
                    <p class="flex items-center justify-between">
                        Tax:
                        <span><span class="relative -top-0.5 text-xs">$</span>0.00</span>
                    </p>
                    <p class="flex items-center justify-between">
                        Discount:
                        <span><span class="relative -top-0.5 text-xs">$</span>50.00</span>
                    </p>
                    <p class="flex items-center justify-between">
                        Total price:
                        <span><span class="relative -top-0.5 text-xs">$</span>999.00</span>
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
