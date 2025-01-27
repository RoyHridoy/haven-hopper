<script setup>
import DateRangePicker from '@/Components/DateRangePicker.vue'
import HomeNavigation from '@/Components/HomeNavigation.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Pagination from '@/Components/Pagination.vue'
import RentalItem from '@/Components/RentalItem.vue'
import SearchNotFound from '@/Components/SearchNotFound.vue'
import SelectInput from '@/Components/SelectInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    rentals: Object,
    cities: Array,
    filters: Object,
})

const form = useForm({
    city: props.filters.city || '',
    checkInDate: props.filters.checkInDate || '',
    checkOutDate: props.filters.checkOutDate || '',
    total_guests: props.filters.total_guests || '',
})

const submitForm = () => {
    form.get(route('search'), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    })
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
    <!-- {{ rentals.data[0] }} -->
    <section class="py-16">
        <div class="mx-auto grid max-w-6xl grid-cols-8 items-end gap-5 rounded-lg bg-gray-200/90 p-5 shadow-md">
            <div class="col-span-2">
                <SelectInput v-model="form.city" :options="cities" :default="props.filters.city" />
            </div>
            <div class="col-span-3 w-full">
                <InputLabel class="mb-2.5 block text-sm/6 font-medium text-gray-900">Choose Dates</InputLabel>
                <DateRangePicker v-model:checkInDate="form.checkInDate" v-model:checkOutDate="form.checkOutDate" />
            </div>
            <div class="col-span-2">
                <InputLabel class="mb-2.5 block text-sm/6 font-medium text-gray-900">Who</InputLabel>
                <input
                    v-model="form.total_guests"
                    id="guest"
                    type="number"
                    class="h-[38px] w-full rounded border border-slate-300 transition placeholder:text-sm placeholder:text-slate-400 hover:border-slate-400"
                    placeholder="Add Guests"
                />
            </div>
            <div class="col-span-1">
                <button
                    @click="submitForm"
                    class="w-full justify-center rounded bg-slate-500 py-2 text-sm font-semibold uppercase tracking-wider text-white transition hover:bg-slate-600"
                >
                    Search
                </button>
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
