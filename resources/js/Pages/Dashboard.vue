<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Carousel from "@/Components/Carousel.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EducoreWorkflow from "@/Components/EducoreWorkflow.vue";
import AnimatedImage from "@/Components/AnimatedImage.vue";
import ExploreMore from "@/Components/ExploreMore.vue";
import CertificateCard from "@/Components/CertificateCard.vue";

const props = defineProps({
    pageConfig: {
        type: Object,
        default: () => ({}),
    },
});

// Computed properties with fallback data
const hero = computed(() => props.pageConfig.hero || {
    title: 'Welcome Back!',
    subtitle: 'Your Learning Journey Continues',
    show_carousel: true,
    carousel_images: ['/images/carousel-1.jpg', '/images/carousel-2.jpg', '/images/carousel-3.jpg'],
});

const platforms = computed(() => props.pageConfig.platforms || {
    title: 'Platforms',
    heading: 'We Serve In Extensive Traits',
    description: 'Educore is a holistic system empowering the entire education ecosystem through innovative digital transformation.',
    cta_primary: 'Get A Quote',
    cta_secondary: 'Learn More',
    platforms: [
        { name: 'School Management', image: '/images/platform-school.jpg', description: 'Complete K-12 school management solution' },
        { name: 'University System', image: '/images/platform-university.jpg', description: 'Advanced higher education management' },
        { name: 'Learning Center', image: '/images/platform-learning.jpg', description: 'Training and development platform' },
    ],
});

const about = computed(() => props.pageConfig.about || {
    title: 'About Educore System',
    description: 'Educore is an innovative all-in-one educational management system built to streamline operations.',
    highlights: ['Unified Dashboard', 'Smart Attendance', 'AI-based Analytics', 'Cloud Security', 'Parent Portal', '24/7 Support'],
    image: '/images/about-educore.png',
    animation: '/images/about-animation.gif',
    button_text: 'EXPLORE MORE',
});

const features = computed(() => props.pageConfig.features || {
    title: 'Educore Core Features',
    description: 'Our system covers all critical aspects of educational management.',
    features: ['Automated Workflows', 'Digital Classrooms', 'Financial Management', 'Secure Data Storage', 'Custom Reporting'],
    image: '/images/core-features.png',
    animation: '/images/features-animation.gif',
    button_text: 'EXPLORE MORE',
});

const certifications = computed(() => props.pageConfig.certifications || {
    title: 'Certifications',
    heading: 'Trusted Certifications & Partnerships',
    description: 'Educore holds industry-recognized certifications and partnerships.',
    certificates: [],
    button_text: 'View All CERTIFICATIONS',
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- Admin Edit Button -->
        <div v-if="$page.props.auth.is_admin" class="fixed bottom-6 right-6 z-50">
            <Link
                :href="route('admin.page-configurations.edit', 'dashboard')"
                class="flex items-center gap-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-3 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Page
            </Link>
        </div>

        <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 px-6 py-16">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-20">

                <!-- Hero/Carousel Section -->
                <div v-if="hero.show_carousel && hero.carousel_images?.length > 0" class="relative">
                    <Carousel :items-to-scroll="hero.carousel_images" />
                </div>

                <!-- Platforms Section -->
                <section class="flex flex-col lg:flex-row items-center gap-10 border-t border-gray-300 pt-16">
                    <div class="flex-1 space-y-6">
                        <h2 class="text-3xl font-bold text-gray-800">{{ platforms.title }}</h2>
                        <h3 class="text-4xl lg:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 leading-tight">
                            {{ platforms.heading }}
                        </h3>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ platforms.description }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <Link :href="route('contact')">
                                <PrimaryButton class="w-full sm:w-auto flex items-center justify-center gap-2">
                                    {{ platforms.cta_primary }} <span class="text-xl">→</span>
                                </PrimaryButton>
                            </Link>
                            <Link :href="route('about')">
                                <PrimaryButton class="w-full sm:w-auto flex items-center justify-center gap-2 bg-white text-purple-600 border-2 border-purple-600 hover:bg-purple-50 hover:text-purple-700">
                                    {{ platforms.cta_secondary }} <span class="text-xl">→</span>
                                </PrimaryButton>
                            </Link>
                        </div>
                    </div>

                    <div class="flex-1 flex justify-center flex-wrap gap-6">
                        <Card
                            v-for="(platform, index) in platforms.platforms"
                            :key="index"
                            :image="platform.image"
                            :text="platform.name"
                            :height="'260px'"
                            :max-width="'200px'"
                            class="transform transition-all duration-300 hover:scale-105 hover:shadow-xl"
                        />
                    </div>
                </section>

                <!-- Workflow -->
                <section class="border-t border-gray-300 pt-16">
                    <EducoreWorkflow />
                </section>

                <!-- About Section -->
                <section class="flex flex-col lg:flex-row items-center gap-12 border-t border-gray-300 pt-16">
                    <div class="flex-1 space-y-6">
                        <ExploreMore
                            :title="about.title"
                            :text="about.description"
                            :usp="about.highlights"
                            :list-name="'Key Highlights:'"
                            :button-name="about.button_text"
                        />
                    </div>
                    <div class="flex-1 flex justify-center">
                        <AnimatedImage
                            :background="'/images/AboutBgEllipse.png'"
                            :background-image="about.image"
                            :gif-image="about.animation"
                        />
                    </div>
                </section>

                <!-- Core Features -->
                <section class="flex flex-col lg:flex-row-reverse items-center gap-12 border-t border-gray-300 pt-16">
                    <div class="flex-1 space-y-6">
                        <ExploreMore
                            :title="features.title"
                            :text="features.description"
                            :usp="features.features"
                            :list-name="'Features:'"
                            :button-name="features.button_text"
                        />
                    </div>
                    <div class="flex-1 flex justify-center">
                        <AnimatedImage
                            :background="'/images/AboutBgEllipse.png'"
                            :background-image="features.image"
                            :gif-image="features.animation"
                        />
                    </div>
                </section>

                <!-- Certifications -->
                <section v-if="certifications.certificates?.length > 0" class="border-t border-gray-300 pt-16 text-center space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">{{ certifications.title }}</h2>
                        <h3 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">
                            {{ certifications.heading }}
                        </h3>
                        <p class="max-w-3xl mx-auto text-lg text-gray-600 mt-4">
                            {{ certifications.description }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10 justify-items-center">
                        <CertificateCard
                            v-for="cert in certifications.certificates"
                            :key="cert.title"
                            :title="cert.title"
                            :text="cert.description"
                            :image="cert.image"
                            :tags="cert.tags"
                            class="transform transition-all duration-300 hover:scale-105"
                        />
                    </div>

                    <div class="flex justify-center mt-8">
                        <PrimaryButton class="gap-2">
                            {{ certifications.button_text }} <span class="text-xl">→</span>
                        </PrimaryButton>
                    </div>
                </section>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Add any custom styles here if needed */
</style>
