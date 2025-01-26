<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from './ApplicationLogo.vue'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
})
</script>

<template>
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
</template>

<style scoped></style>
