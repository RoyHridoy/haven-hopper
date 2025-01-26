<script setup>
import DateRangePicker from '@/Components/DateRangePicker.vue'
import HomeNavigation from '@/Components/HomeNavigation.vue'
import { useForm } from '@inertiajs/vue3'
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    rentals: Array,
})

const form = useForm({
    checkInDate: '',
    checkOutDate: '',
})

const submitForm = () => {
    console.log('Form Data:', form)
}
</script>

<template>
    <HomeNavigation :can-login :can-register />
    {{ form }}
    <div>
        <DateRangePicker v-model:checkInDate="form.checkInDate" v-model:checkOutDate="form.checkOutDate" />
    </div>
    <button @click="submitForm">Submit</button>
</template>
