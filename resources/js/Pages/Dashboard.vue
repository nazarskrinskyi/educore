<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Carousel from "@/Components/Carousel.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EducoreWorkflow from "@/Components/EducoreWorkflow.vue";
import AnimatedImage from "@/Components/AnimatedImage.vue";
import ExploreMore from "@/Components/ExploreMore.vue";
import CertificateCard from "@/Components/CertificateCard.vue";

const itemsToScroll = Array.from({ length: 3 }, (_, i) => `/images/download${i + 1}.png`);

const cardsItems = Array.from({ length: 3 }, (_, i) => ({
    text: `Platform ${i + 1}`,
    image: `/images/download${i + 1}.png`,
}));

const certificateItems = Array.from({ length: 5 }, (_, i) => ({
    title: `Certificate ${i + 1}`,
    text: `Certified excellence in education innovation and management process #${i + 1}.`,
    image: `/images/download${i + 1}.png`,
    tags: ['ISO 9001:2015', 'Quality Assurance']
}));
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 px-6 py-16">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-20">

                <!-- Carousel -->
                <div>
                    <Carousel :items-to-scroll="itemsToScroll" />
                </div>

                <!-- Platforms Section -->
                <section class="flex flex-col lg:flex-row items-center gap-10 border-t border-gray-300 pt-16">
                    <div class="flex-1 space-y-6">
                        <h2 class="text-3xl font-bold text-gray-800">Platforms</h2>
                        <h3 class="text-5xl font-extrabold text-blue-500 leading-tight">We Serve In Extensive Traits</h3>
                        <p class="text-lg text-gray-600">
                            Educore is a holistic system empowering the entire education ecosystem through innovative digital transformation.
                            It enhances learning, management, and collaboration for schools and universities worldwide.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <PrimaryButton class="w-full sm:w-auto flex items-center justify-center gap-2">
                                Get A Quote <span class="text-xl">→</span>
                            </PrimaryButton>
                            <PrimaryButton class="w-full sm:w-auto flex items-center justify-center gap-2 hover:text-white transition-all">
                                Learn More <span class="text-xl">→</span>
                            </PrimaryButton>
                        </div>
                    </div>

                    <div class="flex-1 flex justify-center flex-wrap gap-6">
                        <Card
                            v-for="(item, index) in cardsItems"
                            :key="index"
                            :image="item.image"
                            :text="item.text"
                            :height="'260px'"
                            :max-width="'200px'"
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
                            :title="'About Educore System'"
                            :text="'Educore is an innovative all-in-one educational management system built to streamline operations, enhance communication, and support smart learning environments for schools, colleges, and universities.'"
                            :usp="['Unified Dashboard', 'Smart Attendance', 'AI-based Analytics', 'Cloud Security', 'Parent Portal', '24/7 Support']"
                            :list-name="'Key Highlights:'"
                            :button-name="'EXPLORE MORE'"
                        />
                    </div>
                    <div class="flex-1 flex justify-center">
                        <AnimatedImage
                            :background="'/images/AboutBgEllipse.png'"
                            :background-image="'/images/aboutDB.png'"
                            :gif-image="'/images/animation.gif'"
                        />
                    </div>
                </section>

                <!-- Core Features -->
                <section class="flex flex-col lg:flex-row-reverse items-center gap-12 border-t border-gray-300 pt-16">
                    <div class="flex-1 space-y-6">
                        <ExploreMore
                            :title="'Educore Core Features'"
                            :text="'Our system covers all critical aspects of educational management — from admissions to performance tracking — designed with flexibility and scalability at its heart.'"
                            :usp="['Automated Workflows', 'Digital Classrooms', 'Financial Management', 'Secure Data Storage', 'Custom Reporting']"
                            :list-name="'Features:'"
                            :button-name="'EXPLORE MORE'"
                        />
                    </div>
                    <div class="flex-1 flex justify-center">
                        <AnimatedImage
                            :background="'/images/AboutBgEllipse.png'"
                            :background-image="'/images/core-features.png'"
                            :gif-image="'/images/core-features.gif'"
                        />
                    </div>
                </section>

                <!-- Certifications -->
                <section class="border-t border-gray-300 pt-16 text-center space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Certifications</h2>
                        <h3 class="text-4xl font-extrabold text-blue-500">Trusted Certifications & Partnerships</h3>
                        <p class="max-w-3xl mx-auto text-lg text-gray-600">
                            Educore holds industry-recognized certifications and partnerships that demonstrate our commitment
                            to quality, compliance, and excellence in educational technology.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10 justify-items-center">
                        <CertificateCard
                            v-for="item in certificateItems"
                            :key="item.title"
                            :title="item.title"
                            :text="item.text"
                            :image="item.image"
                            :tags="item.tags"
                        />
                    </div>

                    <div class="flex justify-center">
                        <PrimaryButton class="gap-2">
                            View All CERTIFICATIONS <span class="text-xl">→</span>
                        </PrimaryButton>
                    </div>
                </section>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
