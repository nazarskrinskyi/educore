<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-semibold uppercase tracking-wide text-white transition-all duration-200 ease-in-out hover:bg-purple-700 focus:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 active:bg-purple-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-purple-600"
    >
        <slot />
    </button>
</template>
