<script setup lang="ts">
import { router } from '@inertiajs/vue3'

defineProps({
    elems: {
        type: Object,
        validator(value: unknown): boolean {
            return typeof value === 'object' && 'links' in value && Array.isArray(value.links)
        }
    }
})
</script>

<template>
    <div class="mt-10 flex justify-center items-center flex-wrap gap-2">
        <button
            v-for="link in elems.links"
            :key="link.label"
            :disabled="!link.url"
            v-html="formatLabel(link.label)"
            @click="router.get(link.url, {}, { preserveState: true, replace: true })"
            class="min-w-[40px] px-4 py-2 text-sm font-medium border rounded-xl transition-all duration-200 shadow-sm
                   hover:-translate-y-[1px] hover:shadow-md"
            :class="{
                'bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700': link.active,
                'bg-white text-gray-700 border-gray-300 hover:bg-blue-50 hover:border-blue-400': !link.active && link.url,
                'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed opacity-70': !link.url
            }"
        />
    </div>
</template>

<script lang="ts">
function formatLabel(label: string) {
    if (label.includes('Previous')) return '←';
    if (label.includes('Next')) return '→';
    return label;
}
</script>

<style scoped>
/* Smooth hover scale */
button:not(:disabled):hover {
    transform: scale(1.05);
}
</style>
