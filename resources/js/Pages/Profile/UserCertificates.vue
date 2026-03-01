<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Navigation from "@/Pages/Profile/Partials/Navigation.vue";
import CertificateCard from "@/Components/CertificateCard.vue";

defineProps({
    certificates: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="My Certificates" />

    <AuthenticatedLayout>
        <template #header>
            <Navigation />
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">My Certificates</h2>
                            <p class="mt-2 text-sm text-gray-600">
                                View and download your earned certificates
                            </p>
                        </div>

                        <!-- Certificates Grid -->
                        <div v-if="certificates && certificates.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <CertificateCard
                                v-for="certificate in certificates"
                                :key="certificate.id"
                                :title="certificate.course_title"
                                :text="certificate.course_description"
                                :certificate-number="certificate.certificate_number"
                                :issued-date="certificate.issued_at"
                                :course-name="certificate.course_title"
                                :recipient-name="certificate.user_name"
                                :view-url="certificate.view_url"
                                :download-url="certificate.download_url"
                                max-width="100%"
                                height="auto"
                            />
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No certificates yet</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Complete courses with at least 90% progress to earn certificates.
                            </p>
                            <div class="mt-6">
                                <a
                                    :href="route('courses.index')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Browse Courses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
