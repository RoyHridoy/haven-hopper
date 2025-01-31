<script setup>
import { ref } from 'vue'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/16/solid'
import { CheckIcon } from '@heroicons/vue/20/solid'
import Svg from './Svg.vue'

const props = defineProps({
    options: Array,
    default: String,
    label: String,
    icon: {
        type: String,
        required: true,
    },
})

const selected = ref(props.default || 'Select an option')
</script>

<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="block text-sm/6 font-medium text-gray-900">{{ label }}</ListboxLabel>
        <div class="relative mt-2">
            <ListboxButton
                class="grid w-full cursor-default grid-cols-1 rounded border border-slate-300 bg-white py-1.5 pl-3 pr-2 text-left text-gray-900 outline-1 -outline-offset-1 outline-gray-300 transition hover:border-slate-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            >
                <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
                    <Svg :name="icon" class="size-4 text-slate-500"></Svg>
                    <span class="block truncate">{{ selected }}</span>
                </span>
                <ChevronUpDownIcon
                    class="col-start-1 row-start-1 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                    aria-hidden="true"
                />
            </ListboxButton>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="focus:outline-hidden absolute z-50 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 sm:text-sm"
                >
                    <ListboxOption
                        as="template"
                        v-for="option in options"
                        :key="`${option}-${option.id}`"
                        :value="option?.name"
                        v-slot="{ active, selected }"
                    >
                        <li
                            :class="[
                                active ? 'outline-hidden bg-indigo-600 text-white' : 'text-gray-900',
                                'relative cursor-default select-none py-2 pl-3 pr-9',
                            ]"
                        >
                            <div class="flex items-center">
                                <Svg :name="icon" class="size-4 text-slate-500"></Svg>
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">{{
                                    option.name
                                }}</span>
                            </div>

                            <span
                                v-if="selected"
                                :class="[
                                    active ? 'text-white' : 'text-indigo-600',
                                    'absolute inset-y-0 right-0 flex items-center pr-4',
                                ]"
                            >
                                <CheckIcon class="size-5" aria-hidden="true" />
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
