<script setup>
import { ref, watch, defineEmits } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

defineProps({
    maxDate: {
        type: Date,
        default: () => {
            const date = new Date()
            date.setDate(date.getDate() + 30)
            return date
        },
    },
})

const emit = defineEmits(['update:checkInDate', 'update:checkOutDate'])

const selectedDate = ref([])

watch(selectedDate, (newValue) => {
    emit('update:checkInDate', newValue === null ? '' : newValue[0])
    emit('update:checkOutDate', newValue === null ? '' : newValue[1])
})
</script>
<template>
    <VueDatePicker
        v-model="selectedDate"
        range
        :multi-calendars="{ solo: true }"
        :min-date="new Date()"
        :max-date="maxDate"
        :enable-time-picker="false"
        placeholder="Choose Booking Date"
    />
</template>
