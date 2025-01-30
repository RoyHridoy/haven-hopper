<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/vue3'
import SidebarLink from '@/Components/SidebarLink.vue'

const showingNavigationDropdown = ref(false)
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white shadow">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-20 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="flex items-center justify-between gap-4">
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="px-4 py-2 font-bold text-slate-500 transition hover:text-slate-700"
                                >
                                    Log Out
                                </Link>

                                <Link
                                    v-if="
                                        !(
                                            $page.props.auth.user.want_to_host ||
                                            $page.props.auth.user.role === 'rental_owner'
                                        )
                                    "
                                    :href="route('host.form')"
                                    class="rounded-sm border border-slate-300 px-4 py-2 font-bold text-slate-500 transition hover:border-slate-400 hover:text-slate-700"
                                >
                                    Become a Host</Link
                                >
                                <div
                                    v-if="$page.props.auth.user.want_to_host"
                                    class="rounded-sm border border-slate-300 px-4 py-2 font-bold text-slate-500 transition hover:border-slate-400 hover:text-slate-700"
                                >
                                    Host: Pending
                                </div>
                                <a
                                    href="/host"
                                    v-if="$page.props.auth.user.role === 'rental_owner'"
                                    class="rounded-sm border border-slate-300 px-4 py-2 font-bold text-slate-500 transition hover:border-slate-400 hover:text-slate-700"
                                    >Host Panel</a
                                >
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="grid grid-cols-4 gap-8">
                            <div class="col-span-1">
                                <div class="sticky top-8 bg-white p-6 shadow-sm sm:rounded-lg">
                                    <ul class="flex flex-col space-y-2" v-if="!$slots.sidebar">
                                        <SidebarLink :href="route('dashboard')" :active="route().current('dashboard')"
                                            >Dashboard</SidebarLink
                                        >
                                        <SidebarLink
                                            :href="route('profile.edit')"
                                            :active="route().current('profile.edit')"
                                            >Profile</SidebarLink
                                        >
                                        <SidebarLink
                                            :href="route('bookings.index')"
                                            :active="route().current('bookings.index')"
                                            >Bookings</SidebarLink
                                        >
                                    </ul>
                                    <ul class="flex flex-col space-y-2" v-if="$slots.sidebar">
                                        <slot name="sidebar" />
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-3 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <!-- Page Heading -->
                                <header class="" v-if="$slots.header">
                                    <div class="border-b px-4 py-6 sm:px-6">
                                        <slot name="header" />
                                    </div>
                                </header>
                                <!-- Page content -->
                                <section class="px-4 py-6 sm:px-6">
                                    <slot />
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
