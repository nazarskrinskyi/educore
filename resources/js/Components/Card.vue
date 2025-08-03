<script setup>

defineProps({
    text: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
    },
    height: {
        type: String,
        required: true,
        default: '100%'
    },
    maxWidth: {
        type: String,
        required: true,
        default: '100%'
    }
})
</script>

<template>
    <a href="#" class="relative rounded-lg shadow-lg rounded-lg overflow-hidden" :style="{ maxWidth }">
        <img :src="image" alt="Card Image" :style="{ height }" class="w-full object-cover" />

        <!-- Overlay text -->
        <div class="absolute bottom-0 right-0 text-right p-4 bg-gradient-to-t from-black/60 to-transparent text-white w-full">
            <h4 class="text-lg font-bold">{{ text }}</h4>
            <h5 class="text-sm text-gray-300">Read More →</h5>
        </div>
    </a>
</template>


<style scoped>

</style>
