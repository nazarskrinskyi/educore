<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    pageName: String,
    configurations: Array,
});

const form = useForm({
    configurations: props.configurations.map(config => ({
        id: config.id,
        section_key: config.section_key,
        content: JSON.stringify(config.content, null, 2),
        order: config.order,
        is_active: config.is_active,
    })),
});

const submit = () => {
    const processedConfigurations = form.configurations.map(config => ({
        id: config.id,
        content: JSON.parse(config.content),
        order: config.order,
        is_active: config.is_active,
    }));

    form.transform(() => ({
        configurations: processedConfigurations,
    })).post(route('admin.page-configurations.bulk-update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Success handled by flash message
        },
    });
};

const addSection = () => {
    form.configurations.push({
        id: null,
        section_key: 'new_section',
        content: JSON.stringify({}, null, 2),
        order: form.configurations.length,
        is_active: true,
    });
};
</script>

<template>
    <Head :title="`Edit ${pageName} Page`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit {{ pageName.charAt(0).toUpperCase() + pageName.slice(1) }} Page Configuration
                </h2>
                <Link
                    :href="route('admin.page-configurations.index')"
                    class="text-sm text-purple-600 hover:text-purple-800"
                >
                    ← Back to All Pages
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-8">
                            <div
                                v-for="(config, index) in form.configurations"
                                :key="index"
                                class="border border-gray-200 rounded-lg p-6 space-y-4 bg-gray-50"
                            >
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        Section: {{ config.section_key }}
                                    </h3>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2">
                                            <input
                                                type="checkbox"
                                                v-model="form.configurations[index].is_active"
                                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                            />
                                            <span class="text-sm text-gray-700">Active</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <InputLabel :for="`order-${index}`" value="Display Order" />
                                    <TextInput
                                        :id="`order-${index}`"
                                        type="number"
                                        v-model.number="form.configurations[index].order"
                                        class="mt-1 block w-32"
                                    />
                                </div>

                                <div>
                                    <InputLabel :for="`content-${index}`" value="Content (JSON)" />
                                    <textarea
                                        :id="`content-${index}`"
                                        v-model="form.configurations[index].content"
                                        rows="15"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 font-mono text-sm"
                                    ></textarea>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Edit the JSON content carefully. Invalid JSON will cause errors.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <PrimaryButton
                                    type="button"
                                    @click="addSection"
                                    class="bg-gray-600 hover:bg-gray-700"
                                >
                                    + Add New Section
                                </PrimaryButton>

                                <PrimaryButton
                                    type="submit"
                                    :disabled="form.processing"
                                    class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700"
                                >
                                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                </PrimaryButton>
                            </div>

                            <div v-if="form.recentlySuccessful" class="text-sm text-green-600">
                                ✓ Changes saved successfully!
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Documentation -->
                <div class="mt-8 overflow-hidden bg-blue-50 border border-blue-200 shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Configuration Guide</h3>
                        <div class="text-sm text-blue-800 space-y-2">
                            <p><strong>Section Keys:</strong> Unique identifiers for each section (e.g., 'hero', 'features', 'about')</p>
                            <p><strong>Content:</strong> JSON object containing all the data for that section</p>
                            <p><strong>Order:</strong> Controls the display order of sections (lower numbers appear first)</p>
                            <p><strong>Active:</strong> Toggle to show/hide sections without deleting them</p>
                            <p class="mt-4"><strong>Note:</strong> Changes take effect immediately after saving. Make sure to test your changes!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
