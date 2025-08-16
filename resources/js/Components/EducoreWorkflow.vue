<script setup>
defineProps({
    steps: {
        type: Array,
        default: () => [
            { icon: '🔍', label: 'Inquiry', bg: 'bg-cyan-400' },
            { icon: '📩', label: 'Admission', bg: 'bg-cyan-500' },
            { icon: '💳', label: 'Invoicing', bg: 'bg-violet-600' },
            { icon: '🧑‍💼', label: 'Employee Affairs', bg: 'bg-purple-700' },
            { icon: '📄', label: 'Payroll', bg: 'bg-purple-600' },
            { icon: '📡', label: 'Communication', bg: 'bg-pink-500' },
        ],
        validator: (value) => {
            return value.every(
                (step) =>
                    typeof step.icon === 'string' &&
                    typeof step.label === 'string' &&
                    typeof step.bg === 'string'
            );
        },
    },
});
</script>

<template>
    <div class="py-12 px-4">
        <h2 class="text-center text-3xl font-bold text-cyan-500 mb-12">Educore Workflow</h2>

        <div class="relative flex flex-wrap justify-center items-center">
            <!-- Timeline Line -->
            <div class="absolute bottom-0 left-0 w-full border-t-4 border-dashed border-indigo-400 z-0"></div>

            <div
                v-for="(step, index) in steps"
                :key="index"
                class="relative z-10 flex flex-col items-center text-center w-40 mx-4 mb-10 transition-transform duration-300 hover:scale-105"
            >
                <!-- Circle with icon -->
                <div
                    :class="[
            'w-24 h-24 rounded-full flex items-center justify-center shadow-xl mb-3 text-4xl text-white transition-all duration-300',
            step.bg
          ]"
                >
                    {{ step.icon }}
                </div>

                <!-- Label -->
                <div class="text-base font-medium text-gray-700">{{ step.label }}</div>

                <!-- Connector arrow (optional, if you want to keep curved SVGs) -->
                <svg
                    v-if="index < steps.length - 1"
                    class="absolute right-[-64px] top-1/2 -translate-y-1/2 hidden md:block"
                    width="80"
                    height="30"
                    viewBox="0 0 80 30"
                    fill="none"
                >
                    <path
                        d="M0 15 Q 20 0, 40 15 T 80 15"
                        stroke="#4f46e5"
                        stroke-width="2"
                        stroke-dasharray="5 5"
                        fill="none"
                        marker-end="url(#arrowhead)"
                    />
                    <defs>
                        <marker
                            id="arrowhead"
                            markerWidth="10"
                            markerHeight="7"
                            refX="10"
                            refY="3.5"
                            orient="auto"
                        >
                            <polygon points="0 0, 10 3.5, 0 7" fill="#4f46e5" />
                        </marker>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth fade-in animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

div[class*='w-24'] {
    animation: fadeInUp 0.8s ease-in-out both;
}
</style>
