<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <Head title="About Us" />

    <AuthenticatedLayout>
        <section class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 px-6 py-16">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    🎓 Про платформу EduCore
                </h1>
                <p class="text-gray-700 text-lg leading-relaxed max-w-3xl mx-auto mb-12">
                    EduCore — це сучасна fullstack-платформа для онлайн-навчання, створена на базі
                    <strong>Laravel 11</strong> та <strong>Vue 3</strong>. Ми поєднуємо технології, зручність
                    і мотивацію до навчання, щоб зробити освітній процес простим і натхненним.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10">
                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">🌍 Наша місія</h3>
                        <p class="text-gray-700">
                            Ми прагнемо зробити якісну освіту доступною кожному. EduCore допомагає людям
                            навчатися у зручний час, у будь-якому місці та у власному темпі.
                        </p>
                    </div>

                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">💡 Наш підхід</h3>
                        <p class="text-gray-700">
                            Ми будуємо платформу на передових технологіях — <b>Laravel</b>, <b>Inertia.js</b>,
                            <b>Vue 3</b> і <b>Tailwind CSS</b> — щоб створювати швидкий, стабільний та
                            приємний інтерфейс для кожного користувача.
                        </p>
                    </div>

                    <div class="bg-white/30 backdrop-blur-md rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold text-indigo-700 mb-3">🤝 Наша команда</h3>
                        <p class="text-gray-700">
                            Ми — розробники, викладачі, дизайнери та ментори, об’єднані спільною метою:
                            створити найзручнішу платформу для онлайн-освіти в Україні.
                        </p>
                    </div>
                </div>

                <div class="mt-16 text-gray-700 leading-relaxed max-w-4xl mx-auto">
                    <h2 class="text-2xl font-semibold text-indigo-700 mb-4">📖 Наша історія</h2>
                    <p>
                        Ідея EduCore народилася з бажання об’єднати навчання, технології та спільноту.
                        Ми почали з кількох невеликих курсів і виросли у повноцінну освітню екосистему,
                        де кожен студент може навчатися ефективно, а викладачі мають зручні інструменти
                        для створення контенту.
                    </p>

                    <h2 class="text-2xl font-semibold text-indigo-700 mt-8 mb-4">🚀 Наші переваги</h2>
                    <ul class="list-disc list-inside space-y-2 text-left">
                        <li>🎥 Відеоуроки та інтерактивні тести</li>
                        <li>📜 Сертифікати після завершення курсів</li>
                        <li>🤖 Telegram-бот для нагадувань і оновлень</li>
                        <li>📚 Простий та інтуїтивний інтерфейс</li>
                        <li>⚡ Швидка робота завдяки кешуванню та оптимізації</li>
                    </ul>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
