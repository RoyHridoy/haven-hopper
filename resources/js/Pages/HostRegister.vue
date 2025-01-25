<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    phone: '',
    agreeTermsCondition: false,
})

const submit = () => {
    form.post(route('host.register'), {
        // onFinish: () => form.reset('password'),
        onSuccess: () => {
            form.errors = {}
        },
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Register as a Host" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-start">
                    <Checkbox class="mt-0.5" name="agreeTermsCondition" v-model:checked="form.agreeTermsCondition" />
                    <span class="ms-2 text-sm text-gray-600"
                        >By Clicking here, You are accepting our terms and conditions</span
                    >
                </label>
                <InputError class="mt-2" :message="form.errors.agreeTermsCondition" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('dashboard')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Cancel
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Become a host
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
