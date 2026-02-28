<script setup>
defineProps({
    title: {
        type: String,
        required: true,
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
    },
    certificateNumber: {
        type: String,
    },
    issuedDate: {
        type: String,
    },
    courseName: {
        type: String,
    },
    recipientName: {
        type: String,
    },
    downloadUrl: {
        type: String,
    },
    viewUrl: {
        type: String,
    }
})
</script>

<template>
    <div
        class="certificate-card bg-white rounded-xl shadow-2xl mx-auto overflow-hidden border-2 border-gray-100 hover:border-blue-300 transition-all duration-300"
        :style="{ height, maxWidth }"
    >
        <!-- Certificate Header with Badge -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 sm:p-6 relative">
            <div class="absolute top-2 right-2 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                <span class="text-white text-xs font-semibold">OFFICIAL</span>
            </div>
            <div class="text-center">
                <div class="inline-block bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2 mb-2">
                    <h4 class="text-white font-bold text-lg sm:text-xl tracking-wider">EDUCORE</h4>
                </div>
                <p class="text-blue-100 text-xs sm:text-sm tracking-widest">CERTIFICATE OF COMPLETION</p>
            </div>
        </div>

        <!-- Certificate Body -->
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Certificate Icon/Image -->
            <div v-if="image" class="flex justify-center mb-4 sm:mb-6">
                <img class="w-20 sm:w-24 lg:w-32 h-20 sm:h-24 lg:h-32 object-contain" :src="image" alt="Certificate Badge">
            </div>
            <div v-else class="flex justify-center mb-4 sm:mb-6">
                <div class="w-20 sm:w-24 lg:w-32 h-20 sm:h-24 lg:h-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg">
                    <svg class="w-12 sm:w-16 lg:w-20 h-12 sm:h-16 lg:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>

            <!-- Certificate Content -->
            <div class="text-center space-y-3 sm:space-y-4">
                <!-- Recipient Name -->
                <div v-if="recipientName" class="border-b-2 border-blue-500 pb-2 inline-block">
                    <p class="text-xs sm:text-sm text-gray-500 uppercase tracking-wide mb-1">Awarded to</p>
                    <h3 class="text-blue-600 font-bold text-xl sm:text-2xl lg:text-3xl">{{ recipientName }}</h3>
                </div>

                <!-- Course Title -->
                <div v-if="courseName || title">
                    <p class="text-xs sm:text-sm text-gray-500 mb-1">For successfully completing</p>
                    <h4 class="text-gray-800 font-bold text-lg sm:text-xl lg:text-2xl px-2">{{ courseName || title }}</h4>
                </div>

                <!-- Description Text -->
                <p v-if="text" class="text-gray-600 text-sm sm:text-base lg:text-lg font-normal px-4">{{ text }}</p>

                <!-- Certificate Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mt-4 sm:mt-6 pt-4 border-t border-gray-200">
                    <!-- Certificate Number -->
                    <div v-if="certificateNumber" class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Certificate No.</p>
                        <p class="text-sm sm:text-base font-mono font-semibold text-gray-800">{{ certificateNumber }}</p>
                    </div>

                    <!-- Issue Date -->
                    <div v-if="issuedDate" class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Issued Date</p>
                        <p class="text-sm sm:text-base font-semibold text-gray-800">{{ issuedDate }}</p>
                    </div>
                </div>

                <!-- Tags -->
                <div v-if="tags && tags.length > 0" class="flex flex-wrap justify-center gap-2 sm:gap-3 pt-4">
                    <span
                        class="text-blue-700 text-xs sm:text-sm font-medium px-3 sm:px-4 py-1 sm:py-2 bg-blue-50 border border-blue-200 rounded-full"
                        v-for="tag in tags" :key="tag"
                    >
                        {{ tag }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div v-if="downloadUrl || viewUrl" class="flex flex-wrap justify-center gap-3 pt-4 sm:pt-6">
                    <a
                        v-if="viewUrl"
                        :href="viewUrl"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                    >
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="text-sm sm:text-base">View Certificate</span>
                    </a>
                    <a
                        v-if="downloadUrl"
                        :href="downloadUrl"
                        download
                        class="inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                    >
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="text-sm sm:text-base">Download PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Certificate Footer -->
        <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
            <p class="text-center text-xs sm:text-sm text-gray-500 italic">
                This certificate verifies successful course completion on EduCore platform
            </p>
        </div>
    </div>
</template>

<style scoped>
.certificate-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.certificate-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
