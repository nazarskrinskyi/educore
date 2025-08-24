<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Carousel from "@/Components/Carousel.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EducoreWorkflow from "@/Components/EducoreWorkflow.vue";
import AnimatedImage from "@/Components/AnimatedImage.vue";
import ExploreMore from "@/Components/ExploreMore.vue";
import CertificateCard from "@/Components/CertificateCard.vue";

const itemsToScroll = [];
for (let i = 1; i < 4; i++) {
    itemsToScroll.push(`/images/download${i}.png`);
}

const cardsItems = [];
for (let i = 1; i < 4; i++) {
    cardsItems.push(
        {'text': `Card ${i}`, 'image': `/images/download${i}.png`}
    );
}

const certificateItems = [];
for (let i = 1; i <= 5; i++) {
    certificateItems.push(
        {'text': `Certificate Text ${i}`, 'title': `Certificate ${i}`, 'image': `/images/download${i}.png`, 'tags': ['ISO 9001:2015', 'ISO 9001:2015'] }
    );
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-10 block">
                    <Carousel :items-to-scroll="itemsToScroll"/>
                </div>

                <div class="flex justify-center border-t border-gray-500 mb-10">
                    <div class="justify-left w-1/3 mt-5">
                        <div class="flex flex-col justify-center gap-4 flex-wrap w-full">
                            <div class="text-2xl bold">Platforms</div>
                            <div class="text-5xl bold text-blue-400 mb-3">We Serve In Extensive Traits</div>
                            <div class="text-lg">Educore is a holistic system that serves the entire education system with a digitally empowered.</div>
                            <div>
                                <PrimaryButton class="w-full flex justify-between items-center">
                                    Get A Quote
                                    <span class="text-xl">→</span>
                                </PrimaryButton>
                            </div>
                            <div>
                                <PrimaryButton class="w-full flex justify-between items-center">
                                    Get A Quote
                                    <span class="text-xl">→</span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                    <div class="justify-right w-2/3 mt-5 self-end">
                        <div class="flex flex-row justify-center gap-7 flex-wrap">
                            <Card
                                v-for="(item, index) in cardsItems"
                                :key="index"
                                :image="item.image"
                                :text="item.text"
                                :height="'250px'"
                                :max-width="'180px'"
                            />
                        </div>
                    </div>
                </div>

                <div class="mb-5 block border-t border-gray-500">
                    <EducoreWorkflow />
                </div>

                <div class="mb-5 block border-t border-gray-500">
                    <div class="flex justify-center border-t border-gray-500 mb-10">
                        <div class="flex flex-col justify-left w-1/2 mt-5">
                            <ExploreMore :title="'About Educore System:'"
                                         :text="'Discover the leading all-in-one solution for educational institutions with core features and innovative solutions designed to cover all school operations.'"
                                         :usp="['Home', 'Services', 'Products', 'Blog', 'About Us', 'Contact Us']"
                                         :list-name="'Our Features:'"
                                         :button-name="'EXPLORE MORE'"
                            />
                        </div>
                        <div class="justify-right w-1/2 mt-5 self-end">
                            <AnimatedImage
                                :background="'/images/AboutBgEllipse.png'"
                                :background-image="'/images/aboutDB.png'"
                                :gif-image="'/images/animation.gif'"
                            />
                        </div>
                    </div>
                </div>

                <div class="mb-5 block border-t border-gray-500">
                    <div class="flex justify-center border-t border-gray-500 mb-10 gap-8">
                        <div class="flex flex-col justify-left w-1/2 mt-5">
                            <AnimatedImage
                                :background="'/images/AboutBgEllipse.png'"
                                :background-image="'/images/core-features.png'"
                                :gif-image="'/images/core-features.gif'"
                            />
                        </div>
                        <div class="justify-right w-1/2 mt-5 self-end ml-5">
                            <ExploreMore :title="'Educore Core Features:'"
                                         :text="'Educore is a holistic system that serves the entire education system with a digitally empowered.'"
                                         :usp="['Home', 'Services', 'Products', 'Blog', 'About Us', 'Contact Us']"
                                         :list-name="'USP’s'"
                                         :button-name="'EXPLORE MORE'"
                            />
                        </div>
                    </div>
                </div>

                <div class="mb-5 block border-t border-gray-500">
                    <p class="font-bold text-2xl text-center mt-8">Certifications</p>
                    <h3 class="font-bold text-3xl text-center text-blue-500 mb-5">Trusted Certifications & partnerships</h3>
                    <p class="text-center text-2xl">Educore is certified and partnered with industry leaders to provide the highest standards of data security, quality
                        management, and technological excellence.</p>
                    <div class="flex flex-row justify-center gap-5 flex-wrap">
                        <CertificateCard v-for="item in certificateItems" :title="item.title" :text="item.text" :image="item.image" :tags="item.tags"/>
                    </div>
                    <div class="flex justify-center mt-5">
                        <PrimaryButton class="gap-2">
                            View All CERTIFICATIONS
                            <span class="text-xl">→</span>
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
