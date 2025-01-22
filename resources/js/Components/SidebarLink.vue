<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Svg from './Svg.vue'

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
})

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 gap-1.5 py-2 text-base font-semibold items-center leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 gap-1.5 py-2 text-base font-semibold items-center leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
)
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
        <Svg name="check" class="size-4 pt-0.5 transition-all" :class="active ? 'opacity-100' : 'opacity-0'"></Svg>
    </Link>
</template>
