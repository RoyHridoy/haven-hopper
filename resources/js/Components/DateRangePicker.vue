<script setup>
import { ref, watch, defineEmits } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

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
        placeholder="Choose Booking Date"
    />
</template>
