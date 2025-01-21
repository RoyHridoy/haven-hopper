<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import { Head } from '@inertiajs/vue3'
import NavLink from '@/Components/NavLink.vue'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
})
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Profile</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-8">
                    <div class="relative col-span-1">
                        <div class="sticky top-7 bg-white p-6 shadow-sm sm:rounded-lg">
                            <ul class="flex flex-col space-y-2">
                                <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')"
                                    >Profile</NavLink
                                >
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
                                    >Bookings</NavLink
                                >
                            </ul>
                        </div>
                    </div>
                    <div class="col-span-3 col-start-2 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-6">
                            <UpdateProfileInformationForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                                class="max-w-xl"
                            />
                        </div>

                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <UpdateProfileInformationForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                                class="max-w-xl"
                            />
                        </div>

                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <UpdatePasswordForm class="max-w-xl" />
                        </div>

                        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                            <DeleteUserForm class="max-w-xl" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
