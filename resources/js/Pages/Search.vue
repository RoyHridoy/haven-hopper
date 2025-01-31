<script setup>
import DateRangePicker from '@/Components/DateRangePicker.vue'
import HomeNavigation from '@/Components/HomeNavigation.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Pagination from '@/Components/Pagination.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import RentalItem from '@/Components/RentalItem.vue'
import SearchNotFound from '@/Components/SearchNotFound.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import SelectInput from '@/Components/SelectInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    rentals: Object,
    cities: Array,
    categories: Array,
    filters: Object,
})

const form = useForm({
    city: props.filters.city || '',
    checkInDate: props.filters.checkInDate || '',
    checkOutDate: props.filters.checkOutDate || '',
    total_guests: props.filters.total_guests || '',
    category: props.filters.category || '',
})

const submitForm = () => {
    form.get(route('search'), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    })
}

const clearForm = () => {
    useForm().get(route('search'))
}

const mergePaginationLinks = (links) => {
    const queryParams = new URLSearchParams(window.location.search)

    return links.map((link) => {
        if (!link.url) return link
        const url = new URL(link.url, window.location.origin)

        // Append current query parameters to pagination URLs
        queryParams.forEach((value, key) => {
            if (key !== 'page') {
                url.searchParams.set(key, value)
            }
        })

        return {
            ...link,
            url: url.toString(),
        }
    })
}
</script>

<template>
    <Head title="Search" />

    <HomeNavigation :can-login :can-register />

    <section class="py-16">
        <div class="mx-auto flex max-w-4xl flex-col gap-5 rounded-lg bg-gray-200/90 p-5 shadow-md">
            <div class="grid grid-cols-2 gap-5">
                <SelectInput
                    v-model="form.city"
                    :options="cities"
                    :default="props.filters.city"
                    label="Choose Destination"
                    icon="location"
                />
                <SelectInput
                    v-model="form.category"
                    :options="categories"
                    :default="props.filters.category"
                    label="Choose Category"
                    icon="home"
                />
            </div>
            <div class="grid grid-cols-4 gap-5">
                <div class="col-span-2 w-full">
                    <DateRangePicker v-model:checkInDate="form.checkInDate" v-model:checkOutDate="form.checkOutDate" />
                </div>
                <div class="col-span-1">
                    <input
                        v-model="form.total_guests"
                        id="guest"
                        type="number"
                        class="h-[38px] w-full rounded border border-slate-300 transition placeholder:text-sm placeholder:text-slate-400 hover:border-slate-400"
                        placeholder="Add Guests"
                    />
                </div>
                <div class="col-span-1 grid grid-cols-2 gap-5">
                    <PrimaryButton @click="submitForm" class="rounded">Search</PrimaryButton>
                    <SecondaryButton @click="clearForm">Clear</SecondaryButton>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="mx-auto grid max-w-6xl grid-cols-3 gap-10" v-if="rentals.data.length > 0">
            <RentalItem v-for="rental in rentals.data" :key="`rental-${rental.id}`" :rental />
        </div>
        <div v-if="rentals.data.length === 0">
            <SearchNotFound />
        </div>
        <div class="mx-auto my-20 flex items-center justify-center" v-if="rentals.links.length > 3">
            <Pagination
                class="rounded bg-gray-100 px-10 py-3 shadow-md"
                :pagination="mergePaginationLinks(rentals.links)"
            />
        </div>
    </section>
</template>
