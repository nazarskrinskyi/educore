<script setup>
defineProps({
    title: {
        type: String,
    },
    text: {
        type: String,
    },
    image: {
        type: String,
    },
    tags: {
        type: Array,
        default: () => []
    },
    height: {
        type: String,
        default: '100%'
    },
    maxWidth: {
        type: String,
        default: '100%'
    }
})
</script>

<template>
    <div
        class="certificate bg-white rounded-xl p-4 sm:p-6 lg:p-8 shadow-xl mx-auto"
        :style="{ height, maxWidth }"
    >
        <img class="mx-auto w-32 sm:w-40 lg:w-48 mb-4 sm:mb-6 lg:mb-8" :src="image" alt="Certificate Image">
        <div class="text-center">
            <h3 class="text-secondary font-bold text-2xl sm:text-3xl lg:text-4xl">{{ title }}</h3>
            <p class="text-primary text-sm sm:text-base lg:text-lg font-normal my-4 sm:my-6 lg:my-8">{{ text }}</p>
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 lg:gap-4">
                <span
                    class="text-primary text-xs sm:text-sm lg:text-base font-normal px-3 sm:px-4 py-1 sm:py-2 bg-[#00C0FE3D] rounded-full"
                    v-for="tag in tags" :key="tag"
                >
                    {{ tag }}
                </span>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Optional: Add subtle hover or transition effects */
.certificate:hover {
    transform: translateY(-2px);
    transition: transform 0.3s ease;
}
</style>
