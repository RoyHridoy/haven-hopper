<script setup>
import HomeNavigation from '@/Components/HomeNavigation.vue'
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    rentals: {
        type: Array,
    },
})
</script>

<template>
    <HomeNavigation :can-login :can-register />
</template>

<style scoped></style>
