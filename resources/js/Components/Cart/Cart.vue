<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Stars from "@/Components/Stars.vue";
import {useTranslations} from "@/composables/useTranslations.js";

const { cart } = defineProps({
    cart: { type: Array, default: () => [] }
})

const open = ref(false)
const cartCount = computed(() => cart.length)
const total = computed(() =>
    cart.reduce((sum, i) => Number(sum) + Number(i.price), 0)
)

const { t } = useTranslations()

function removeFromCart(id) {
    router.post(route('cart.remove', id), {}, { preserveScroll: true })
}
</script>

<template>
    <div class="relative">
        <!-- Кнопка відкриття -->
        <button
            @click="open = !open"
            class="flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700"
        >
            🛒 <span>{{ t('cart.title', 'Cart') }} ({{ cartCount }})</span>
        </button>

        <!-- Popup -->
        <div
            v-if="open"
            class="absolute right-0 mt-2 w-[420px] bg-white shadow-2xl rounded-xl overflow-hidden z-50"
        >
            <!-- Заголовок -->
            <div class="px-4 py-3 border-b font-semibold text-gray-800">
                {{ t('cart.title', 'Cart') }} ({{ cartCount }})
            </div>

            <div v-if="cart.length" class="max-h-[400px] overflow-y-auto">
                <div
                    v-for="item in cart"
                    :key="item.id"
                    class="flex items-start gap-3 px-4 py-3 border-b hover:bg-gray-50 transition"
                >
                    <!-- Картинка -->
                    <img
                        :src="item.image"
                        alt="Course image"
                        class="w-24 h-16 object-cover rounded"
                    />

                    <!-- Інфо -->
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm line-clamp-2">
                            {{ item.name }}
                        </p>
                        <p class="text-xs text-gray-600">
                            Автор: {{ item.instructor }}
                        </p>
                        <div class="flex items-center text-yellow-500 text-xs mt-1 gap-2">
                            <Stars :size="14" :rating="Number(item.rating || 0)"/>
                            <span class="text-gray-500">({{ item.reviews_count || 0 }} відгуків)</span>
                        </div>
                        <p class="text-xs text-gray-500">{{ item.duration }} min | {{ item.level }} | {{ item.lessons }} lessons</p>
                    </div>

                    <!-- Ціна + кнопка -->
                    <div class="flex flex-col items-end">
                        <span class="font-bold text-gray-800">{{ Number(item.price) }} ₴</span>
                        <button
                            @click="removeFromCart(item.id)"
                            class="text-red-500 hover:text-red-700 text-xs mt-1"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 bg-gray-50 border-t">
                <div class="flex justify-between items-center font-bold text-gray-800">
                    <span>Всього:</span>
                    <span>{{ total }} ₴</span>
                </div>
                <Link
                    :href="route('cart.checkout')"
                    class="block mt-3 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition"
                >
                    {{ t('cart.checkout', 'Checkout') }}
                </Link>
            </div>
        </div>
    </div>
</template>
