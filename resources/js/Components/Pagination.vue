<script setup lang="ts">
import { router } from '@inertiajs/vue3'

defineProps({
    elems: {type: Object, validator(value: unknown): boolean {
            return typeof value === 'object' && 'links' in value && Array.isArray(value.links)
        }}
})
</script>

<template>
    <!-- Pagination -->
    <div class="mt-6 flex justify-center space-x-2">
        <button
            v-for="link in elems.links"
            :key="link.label"
            v-html="link.label"
            :disabled="!link.url"
            @click="router.get(link.url, {}, { preserveState: true, replace: true })"
            class="px-3 py-1 border rounded"
            :class="{'bg-gray-200': link.active}"
        />
    </div>
</template>

<style scoped>

</style>
