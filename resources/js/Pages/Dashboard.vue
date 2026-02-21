<script setup>
import { computed, ref, onMounted } from 'vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
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

const page = usePage();

// Get translations
const t = computed(() => {
    return page.props.translations?.dashboard || {};
});

// Animation state
const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});

// Computed properties with fallback data
const hero = computed(() => props.pageConfig.hero || {
    title: t.value.title || 'Welcome Back!',
    subtitle: t.value.subtitle || 'Your Learning Journey Continues',
    show_carousel: true,
    carousel_images: ['/images/carousel-1.jpg', '/images/carousel-2.jpg', '/images/carousel-3.jpg'],
});

const platforms = computed(() => props.pageConfig.platforms || {
    title: t.value.platforms_title || 'Platforms',
    heading: t.value.platforms_heading || 'We Serve In Extensive Traits',
    description: t.value.platforms_description || 'Educore is a holistic system empowering the entire education ecosystem through innovative digital transformation.',
    cta_primary: t.value.platforms_cta_primary || 'Get A Quote',
    cta_secondary: t.value.platforms_cta_secondary || 'Learn More',
    platforms: [
        { name: 'School Management', image: '/images/platform-school.jpg', description: 'Complete K-12 school management solution' },
        { name: 'University System', image: '/images/platform-university.jpg', description: 'Advanced higher education management' },
        { name: 'Learning Center', image: '/images/platform-learning.jpg', description: 'Training and development platform' },
    ],
});

const about = computed(() => props.pageConfig.about || {
    title: t.value.about_title || 'About Educore System',
    description: t.value.about_description || 'Educore is an innovative all-in-one educational management system built to streamline operations.',
    highlights: ['Unified Dashboard', 'Smart Attendance', 'AI-based Analytics', 'Cloud Security', 'Parent Portal', '24/7 Support'],
    image: '/images/about-educore.png',
    animation: '/images/about-animation.gif',
    button_text: t.value.about_button || 'EXPLORE MORE',
});

const features = computed(() => props.pageConfig.features || {
    title: t.value.features_title || 'Educore Core Features',
    description: t.value.features_description || 'Our system covers all critical aspects of educational management.',
    features: ['Automated Workflows', 'Digital Classrooms', 'Financial Management', 'Secure Data Storage', 'Custom Reporting'],
    image: '/images/core-features.png',
    animation: '/images/features-animation.gif',
    button_text: t.value.features_button || 'EXPLORE MORE',
});

const certifications = computed(() => props.pageConfig.certifications || {
    title: t.value.certifications_title || 'Certifications',
    heading: t.value.certifications_heading || 'Trusted Certifications & Partnerships',
    description: t.value.certifications_description || 'Educore holds industry-recognized certifications and partnerships.',
    certificates: [],
    button_text: t.value.certifications_button || 'View All CERTIFICATIONS',
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
                {{ t.edit_page || 'Edit Page' }}
            </Link>
        </div>

        <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 space-y-20">

                <!-- Hero Section -->
                <section class="relative overflow-hidden py-12 sm:py-16">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 -z-10 overflow-hidden">
                        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
                    </div>

                    <div class="text-center">
                        <h1
                            class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl transition-all duration-1000"
                            :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                        >
                            <span class="block">{{ hero.title }}</span>
                        </h1>
                        <p
                            class="mt-4 text-xl sm:text-2xl font-semibold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent transition-all duration-1000 delay-150"
                            :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                        >
                            {{ hero.subtitle }}
                        </p>
                    </div>

                    <!-- Carousel Section -->
                    <div
                        v-if="hero.show_carousel && hero.carousel_images?.length > 0"
                        class="mt-12 transition-all duration-1000 delay-300"
                        :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                    >
                        <Carousel :items-to-scroll="hero.carousel_images" />
                    </div>
                </section>

                <!-- Platforms Section -->
                <section class="relative overflow-hidden py-16 bg-white rounded-3xl shadow-xl">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgb(99 102 241) 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>

                    <div class="relative px-6 sm:px-12">
                        <div class="flex flex-col lg:flex-row items-center gap-12">
                            <div class="flex-1 space-y-6">
                                <div class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                    {{ platforms.title }}
                                </div>
                                <h2 class="text-4xl lg:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 leading-tight">
                                    {{ platforms.heading }}
                                </h2>
                                <p class="text-lg text-gray-600 leading-relaxed">
                                    {{ platforms.description }}
                                </p>
                                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                    <Link :href="route('contact')">
                                        <PrimaryButton class="w-full sm:w-auto group flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300">
                                            {{ platforms.cta_primary }}
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </PrimaryButton>
                                    </Link>
                                    <Link :href="route('about')">
                                        <PrimaryButton class="w-full sm:w-auto group flex items-center justify-center gap-2 bg-white text-purple-600 border-2 border-purple-600 hover:bg-purple-50 hover:text-purple-700 shadow-md hover:shadow-lg transition-all duration-300">
                                            {{ platforms.cta_secondary }}
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
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
                                    class="transform transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:-translate-y-2"
                                />
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Workflow -->
                <section class="relative">
                    <EducoreWorkflow />
                </section>

                <!-- About Section -->
                <section class="relative overflow-hidden py-16 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl shadow-xl">
                    <div class="relative px-6 sm:px-12">
                        <div class="flex flex-col lg:flex-row items-center gap-12">
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
                                <div class="transform transition-all duration-500 hover:scale-105">
                                    <AnimatedImage
                                        :background="'/images/AboutBgEllipse.png'"
                                        :background-image="about.image"
                                        :gif-image="about.animation"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Core Features -->
                <section class="relative overflow-hidden py-16 bg-white rounded-3xl shadow-xl">
                    <div class="relative px-6 sm:px-12">
                        <div class="flex flex-col lg:flex-row-reverse items-center gap-12">
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
                                <div class="transform transition-all duration-500 hover:scale-105">
                                    <AnimatedImage
                                        :background="'/images/AboutBgEllipse.png'"
                                        :background-image="features.image"
                                        :gif-image="features.animation"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Certifications -->
                <section v-if="certifications.certificates?.length > 0" class="relative overflow-hidden py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl text-white">
                    <!-- Animated background elements -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
                        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse animation-delay-2000"></div>
                    </div>

                    <div class="relative px-6 sm:px-12 text-center space-y-8">
                        <div>
                            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-4">
                                {{ certifications.title }}
                            </div>
                            <h2 class="text-4xl font-extrabold mb-2">
                                {{ certifications.heading }}
                            </h2>
                            <div class="w-24 h-1 bg-white/50 mx-auto mb-6 rounded-full"></div>
                            <p class="max-w-3xl mx-auto text-lg text-purple-100">
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
                                class="transform transition-all duration-500 hover:scale-105 hover:-translate-y-2"
                            />
                        </div>

                        <div class="flex justify-center mt-8">
                            <PrimaryButton class="group gap-2 bg-white text-purple-600 hover:bg-purple-50 shadow-lg hover:shadow-xl transition-all duration-300">
                                {{ certifications.button_text }}
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </PrimaryButton>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
