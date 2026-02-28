<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('student.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Student Login"/>

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Student Login</h2>
            <p class="mt-2 text-sm text-gray-600">Sign in to access your courses</p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email Address"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember"/>
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="flex flex-col space-y-2">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link>
                    <Link
                        :href="route('instructor.login')"
                        class="text-sm text-indigo-600 underline hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Login as Instructor
                    </Link>
                </div>

                <PrimaryButton
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <a
                    :href="route('auth.google.redirect')"
                    class="w-full inline-flex justify-center items-center"
                >
                    <SecondaryButton class="w-full">
                        <img src="../../../assets/google-icon-logo-svgrepo-com.svg" alt="Google Logo" class="w-5 mr-2" />
                        Login with Google
                    </SecondaryButton>
                </a>
            </div>

            <div class="mt-4 text-center">
                <Link
                    :href="route('student.register')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Don't have an account? <span class="underline">Register as Student</span>
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
