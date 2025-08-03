<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Carousel from "@/Components/Carousel.vue";
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

</script>

<template>
    <Head><title>Dashboard</title></Head>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-5 block">
                    <Carousel :items-to-scroll="itemsToScroll"/>
                </div>

                <div class="flex justify-center border-t border-gray-500">
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
            </div>
        </div>
    </AuthenticatedLayout>

</template>
