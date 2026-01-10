<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    configurations: Object,
});
</script>

<template>
    <Head title="Page Configurations" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Page Configuration Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                Manage Your Website Pages
                            </h3>
                            <p class="text-sm text-gray-600">
                                Configure the content and appearance of your website pages. Click on a page to edit its sections.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="(sections, pageName) in configurations"
                                :key="pageName"
                                class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow bg-gradient-to-br from-white to-gray-50"
                            >
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xl font-bold text-gray-800 capitalize">
                                        {{ pageName }} Page
                                    </h4>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ sections.length }} sections
                                    </span>
                                </div>

                                <div class="mb-4 space-y-2">
                                    <p class="text-sm text-gray-600">
                                        <strong>Sections:</strong>
                                    </p>
                                    <ul class="text-xs text-gray-500 space-y-1">
                                        <li
                                            v-for="section in sections.slice(0, 5)"
                                            :key="section.id"
                                            class="flex items-center gap-2"
                                        >
                                            <span
                                                :class="section.is_active ? 'bg-green-500' : 'bg-gray-400'"
                                                class="w-2 h-2 rounded-full"
                                            ></span>
                                            {{ section.section_key }}
                                        </li>
                                        <li v-if="sections.length > 5" class="text-gray-400">
                                            ... and {{ sections.length - 5 }} more
                                        </li>
                                    </ul>
                                </div>

                                <Link
                                    :href="route('admin.page-configurations.edit', pageName)"
                                    class="block w-full text-center rounded-lg px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all"
                                >
                                    Edit Page
                                </Link>
                            </div>

                            <!-- Add New Page Card -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-purple-400 transition-colors">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">
                                    Add New Page
                                </h4>
                                <p class="text-sm text-gray-500 mb-4">
                                    Create a new configurable page
                                </p>
                                <button
                                    class="px-4 py-2 text-sm font-semibold text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50 transition-colors"
                                >
                                    Coming Soon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="mt-8 overflow-hidden bg-purple-50 border border-purple-200 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-purple-900 mb-4">💡 Quick Tips</h3>
                        <ul class="text-sm text-purple-800 space-y-2 list-disc list-inside">
                            <li>Changes to page configurations take effect immediately</li>
                            <li>Use the "Active" toggle to hide sections without deleting them</li>
                            <li>The "Order" field controls the display sequence of sections</li>
                            <li>Always validate your JSON before saving to avoid errors</li>
                            <li>You can preview changes by visiting the actual page</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
