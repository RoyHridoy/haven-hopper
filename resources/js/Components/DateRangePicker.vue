<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { defineEmits, ref, watch } from 'vue'

const props = defineProps({
    maxDate: {
        type: Date,
        default: () => {
            const date = new Date()
            date.setDate(date.getDate() + 30)
            return date
        },
    },
    checkInDate: String,
    checkOutDate: String,
    bookedDates: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['update:checkInDate', 'update:checkOutDate'])

const selectedDate = ref([props.checkInDate, props.checkOutDate])

const formatDate = (date) => {
    if (!date) return ''
    const passedDate = new Date(date)
    const year = passedDate.getFullYear()
    const month = String(passedDate.getMonth() + 1).padStart(2, '0')
    const day = String(passedDate.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
}

// Disable booked dates
const disabledDates = props.bookedDates.flatMap(({ check_in_date, check_out_date }) => {
    const start = new Date(check_in_date)
    const end = new Date(check_out_date)
    const dates = []
    let current = new Date(start)
    while (current <= end) {
        dates.push(new Date(current))
        current.setDate(current.getDate() + 1)
    }
    return dates
})

// Helper to check if a date is disabled
const isBooked = (date) => {
    return disabledDates.some(
        d => d.getFullYear() === date.getFullYear() &&
             d.getMonth() === date.getMonth() &&
             d.getDate() === date.getDate()
    )
}

watch(selectedDate, (newValue) => {
    emit('update:checkInDate', newValue === null ? '' : formatDate(newValue[0]))
    emit('update:checkOutDate', newValue === null ? '' : formatDate(newValue[1]))
})
</script>
<template>
    <VueDatePicker
        v-model="selectedDate"
        range
        :multi-calendars="{ solo: true }"
        :min-date="new Date()"
        :time-picker="false"
        :format="'yyyy-MM-dd'"
        :max-date="maxDate"
        :enable-time-picker="false"
        :disabled-dates="disabledDates"
        placeholder="Choose Booking Date"
    >
        <template #day="{ day, date }">
            <div v-if="isBooked(date)" class="relative group">
                <span
                    class="flex items-center justify-center w-8 h-8 text-red-600 cursor-not-allowed"
                    style="pointer-events: none;"
                >
                    &#10060;
                </span>
                <div
                    class="absolute z-10 hidden group-hover:block left-1/2 -translate-x-1/2 mt-1 px-2 py-1 text-xs text-white bg-red-600 rounded shadow"
                >
                    already booked
                </div>
            </div>
            <span v-else>
                {{ day }}
            </span>
        </template>
    </VueDatePicker>
</template>
