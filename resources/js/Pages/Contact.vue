<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PopupMessage from "@/Components/PopupMessage.vue";
import { usePage } from '@inertiajs/vue3';
import {useTranslations} from "@/composables/useTranslations.js";

const page = usePage();
const { t } = useTranslations();

const form = useForm({
    name: "",
    email: "",
    subject: "",
    message: "",
});

const errorMessage = ref("");
const flashMessage = ref("");

const submit = () => {
    if (form.name.trim().length < 2) {
        errorMessage.value = "Ім’я має містити щонайменше 2 символи.";
        return;
    }

    errorMessage.value = "";

    form.post(route("contact.store"), {
        preserveState: true,
        onSuccess: (page) => {
            flashMessage.value = page.props.flash?.successContactMessage || "Повідомлення надіслано!";
            form.reset();

            setTimeout(() => flashMessage.value = '', 5000);
        },
        onError: (errors) => {
            console.log(errors);
        },
    });

};
</script>

<template>
    <Head title="Contact Us" />

    <AuthenticatedLayout>
        <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 px-6 py-16">
            <div class="max-w-2xl mx-auto text-center">

                <!-- Popup повідомлення -->
                <PopupMessage v-if="flashMessage" :message="flashMessage" type="success" />

                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">📬 Зв’яжіться з нами</h1>
                <p class="text-gray-700 text-lg mb-10">
                    {{ t('contact.description') }}
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
                            :placeholder="t('contact.name_placeholder')"
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
                            :placeholder="t('contact.email_placeholder')"
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
                            :placeholder="t('contact.subject_placeholder')"
                            class="w-full border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                    </div>

                    <div>
                        <label for="message" class="block text-gray-800 font-semibold mb-2">Повідомлення</label>
                        <textarea
                            v-model="form.message"
                            id="message"
                            rows="5"
                            :placeholder="t('contact.message_placeholder')"
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
                </form>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
