<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    pagination: Object,
})
</script>

<template>
    <div class="relative flex justify-center">
        <span v-for="link in pagination" :key="`pagination-${link.label}`">
            <Link
                preserve-scroll
                :href="link.url ?? ''"
                v-html="link.label"
                class="flex items-center justify-center rounded-lg px-3 py-2 text-sm text-gray-800"
                :class="{ 'bg-gray-300': link.active, '!text-gray-400': !link.url }"
            />
        </span>
    </div>
</template>
