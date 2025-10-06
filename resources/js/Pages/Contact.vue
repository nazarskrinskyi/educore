<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import PopupMessage from "@/Components/PopupMessage.vue";

const form = useForm({
    name: "",
    email: "",
    subject: "",
    message: "",
});

const successMessage = ref("");
const errorMessage = ref("");

const submit = () => {
    if (form.name.trim().length < 2) {
        errorMessage.value = "Ім’я має містити щонайменше 2 символи.";
        return;
    }

    errorMessage.value = "";
    form.post(route("contact.store"), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = "✅ Дякуємо! Ми зв’яжемось із вами найближчим часом.";
            form.reset();
        },
    });
};

const flashMessage = ref(usePage().props.value.flash.message || '');
</script>

<template>
    <Head title="Contact Us" />

    <AuthenticatedLayout>
        <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 px-6 py-16">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">📬 Зв’яжіться з нами</h1>
                <p class="text-gray-700 text-lg mb-10">
                    Ми відкриті до співпраці, пропозицій і нових ідей. Ваш відгук допомагає нам розвивати EduCore.
                </p>

                <form
                    @submit.prevent="submit"
                    class="backdrop-blur-md bg-white/30 rounded-2xl p-8 shadow-lg space-y-6 text-left"
                >
                    <div>
                        <label for="name" class="block text-gray-800 font-semibold mb-2">Ім’я</label>
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            placeholder="Ваше ім’я"
                            class="w-full border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required
                        />
                    </div>

                    <div>
                        <label for="email" class="block text-gray-800 font-semibold mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            placeholder="you@example.com"
                            class="w-full border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            required
                        />
                    </div>

                    <div>
                        <label for="subject" class="block text-gray-800 font-semibold mb-2">Тема</label>
                        <input
                            v-model="form.subject"
                            type="text"
                            id="subject"
                            placeholder="Тема вашого звернення"
                            class="w-full border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                    </div>

                    <div>
                        <label for="message" class="block text-gray-800 font-semibold mb-2">Повідомлення</label>
                        <textarea
                            v-model="form.message"
                            id="message"
                            rows="5"
                            placeholder="Ваше повідомлення..."
                            class="w-full border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
                            required
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition"
                    >
                        Відправити
                    </button>

                    <p v-if="errorMessage" class="text-red-600 font-semibold text-center mt-4">
                        {{ errorMessage }}
                    </p>
                    <p v-if="successMessage" class="text-green-600 font-semibold text-center mt-4">
                        {{ successMessage }}
                    </p>
                </form>
            </div>
        </section>

        <PopupMessage v-if="flashMessage" :message="flashMessage" type="success" />
    </AuthenticatedLayout>
</template>
