<script setup>
import 'vue3-carousel/carousel.css'
import {Carousel, Slide, Navigation, Pagination} from 'vue3-carousel'
import PrimaryButton from "@/Components/PrimaryButton.vue"

let props = defineProps({
    height: {
        type: Number,
        default: 300,
    },
    itemsToShow: {
        type: Number,
        default: 1,
    },
    wrapAround: {
        type: Boolean,
        default: true,
    },
    snapAlign: {
        type: String,
        default: 'center',
    },
    itemsToScroll: {
        type: Array,
    },
})
const config = {
    height: 300,
    itemsToShow: 1,
    wrapAround: true,
    snapAlign: 'center',
}
</script>

<template>
    <div class="carousel-container">
        <Carousel v-bind="config">
            <Slide v-for="path in itemsToScroll" :key="path">
                <div class="slide-content">
                    <img :src="path" alt="image" />
                    <div class="button-overlay">
                        <PrimaryButton>READ MORE</PrimaryButton>
                    </div>
                </div>
            </Slide>

            <template #addons>
                <Navigation />
                <Pagination />
            </template>
        </Carousel>
    </div>
</template>

<style scoped>
img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
}

.button-overlay {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    padding: 0.5rem 1rem;
    border-radius: 8px;
}

/* Style navigation buttons */
::v-deep(.carousel__prev),
::v-deep(.carousel__next) {
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    font-size: 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

::v-deep(.carousel__prev:hover),
::v-deep(.carousel__next:hover) {
    background-color: rgba(255, 255, 255, 0.8);
    color: #333;
}
</style>
