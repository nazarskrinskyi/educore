<script setup>
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const currentLocale = computed(() => page.props.locale || 'en');
const isOpen = ref(false);

const locales = [
    { code: 'en', name: 'English', flag: '🇬🇧' },
    { code: 'uk', name: 'Українська', flag: '🇺🇦' },
];

const currentLocaleData = computed(() => {
    return locales.find(l => l.code === currentLocale.value) || locales[1];
});

const switchLocale = (locale) => {
    if (locale !== currentLocale.value) {
        // Use a form to submit the locale change
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = route('locale.switch');

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfInput);

        // Add locale input
        const localeInput = document.createElement('input');
        localeInput.type = 'hidden';
        localeInput.name = 'locale';
        localeInput.value = locale;
        form.appendChild(localeInput);

        document.body.appendChild(form);
        form.submit();
    } else {
        isOpen.value = false;
    }
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = () => {
    isOpen.value = false;
};
</script>

<template>
    <div class="relative" v-click-away="closeDropdown">
        <!-- Trigger Button -->
        <button
            @click="toggleDropdown"
            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200"
            :aria-expanded="isOpen"
            aria-haspopup="true"
        >
            <span class="text-lg">{{ currentLocaleData.flag }}</span>
            <span class="hidden sm:inline">{{ currentLocaleData.name }}</span>
            <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-if="isOpen"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
            >
                <div class="py-1" role="menu" aria-orientation="vertical">
                    <button
                        v-for="locale in locales"
                        :key="locale.code"
                        @click="switchLocale(locale.code)"
                        class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150"
                        :class="{
                            'bg-purple-100 text-purple-700 font-semibold': locale.code === currentLocale,
                        }"
                        role="menuitem"
                    >
                        <span class="text-lg">{{ locale.flag }}</span>
                        <span>{{ locale.name }}</span>
                        <svg
                            v-if="locale.code === currentLocale"
                            class="w-4 h-4 ml-auto text-purple-600"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
