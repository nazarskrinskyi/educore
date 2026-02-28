<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useTranslations } from '@/composables/useTranslations';

const { t } = useTranslations();
</script>

<template>
    <Head :title="t('about.title', 'About Us')" />

    <AuthenticatedLayout>
        <section class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 px-6 py-16">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    🎓 {{ t('about.title', 'About EduCore Platform') }}
                </h1>
                <p class="text-gray-700 text-lg leading-relaxed max-w-3xl mx-auto mb-12">
                    {{ t('about.description', 'EduCore is a modern fullstack platform for online learning, built on Laravel 11 and Vue 3. We combine technology, convenience, and motivation for learning to make the educational process simple and inspiring.') }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10">
                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">🌍 {{ t('about.our_mission', 'Our Mission') }}</h3>
                        <p class="text-gray-700">
                            {{ t('about.mission_text', 'We strive to make quality education accessible to everyone. EduCore helps people learn at a convenient time, anywhere, and at their own pace.') }}
                        </p>
                    </div>

                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">💡 {{ t('about.our_approach', 'Our Approach') }}</h3>
                        <p class="text-gray-700">
                            {{ t('about.approach_text', 'We build the platform on cutting-edge technologies — Laravel, Inertia.js, Vue 3, and Tailwind CSS — to create a fast, stable, and pleasant interface for every user.') }}
                        </p>
                    </div>

                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">🤝 {{ t('about.our_team', 'Our Team') }}</h3>
                        <p class="text-gray-700">
                            Ми — розробники, викладачі, дизайнери та ментори, об’єднані спільною метою:
                            створити найзручнішу платформу для онлайн-освіти в Україні.
                        </p>
                    </div>
                </div>

                <div class="mt-16 text-gray-700 leading-relaxed max-w-4xl mx-auto">
                    <h2 class="text-2xl font-semibold text-indigo-700 mb-4">📖 {{ t('about.our_story', 'Our Story') }}</h2>
                    <p>
                        Ідея EduCore народилася з бажання об’єднати навчання, технології та спільноту.
                        Ми почали з кількох невеликих курсів і виросли у повноцінну освітню екосистему,
                        де кожен студент може навчатися ефективно, а викладачі мають зручні інструменти
                        для створення контенту.
                    </p>

                    <h2 class="text-2xl font-semibold text-indigo-700 mt-8 mb-4">🚀 {{ t('about.our_advantages', 'Our Advantages') }}</h2>
                    <ul class="list-disc list-inside space-y-2 text-left">
                        <li>🎥 {{ t('about.advantage_videos', 'Video lessons and interactive tests') }}</li>
                        <li>📜 {{ t('about.advantage_certificates', 'Certificates upon course completion') }}</li>
                        <li>🤖 {{ t('about.advantage_bot', 'Telegram bot for reminders and updates') }}</li>
                        <li>📚 {{ t('about.advantage_interface', 'Simple and intuitive interface') }}</li>
                        <li>⚡ {{ t('about.advantage_performance', 'Fast performance thanks to caching and optimization') }}</li>
                    </ul>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
