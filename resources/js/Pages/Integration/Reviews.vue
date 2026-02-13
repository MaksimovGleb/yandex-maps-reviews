<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    yandexData: Object,
});
</script>

<template>
    <Head title="Отзывы" />

    <AuthenticatedLayout>
        <div class="flex gap-8">
            <!-- Список отзывов -->
            <div class="flex-1 space-y-4">
                <!-- Общий заголовок сервиса -->
                <div v-if="yandexData && yandexData.reviews?.length" class="flex items-center gap-2 mb-2">
                    <div class="bg-white px-3 py-1 rounded-lg border border-gray-200 flex items-center gap-2 text-xs font-medium text-gray-700 shadow-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1a9.002 9.002 0 0 0-6.366 15.362c1.63 1.63 5.466 3.988 5.693 6.465.034.37.303.673.673.673.37 0 .64-.303.673-.673.227-2.477 4.06-4.831 5.689-6.46A9.002 9.002 0 0 0 12 1zm0 12.079a3.079 3.079 0 1 1 0-6.158 3.079 3.079 0 0 1 0 6.158z" fill="#FF0000"></path>
                        </svg>
                        Яндекс Карты
                    </div>
                </div>

                <div v-if="yandexData && yandexData.reviews?.length" v-for="review in yandexData.reviews" :key="review.external_id"
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="bg-gray-50 px-6 py-2 border-b border-gray-100 flex items-center justify-between">
                        <div class="text-xs text-gray-400 flex items-center gap-2">
                            {{ new Date(review.published_at).toLocaleDateString() }} {{ new Date(review.published_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }}
                            <svg width="14" height="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-red-500">
                                <path d="M12 1a9.002 9.002 0 0 0-6.366 15.362c1.63 1.63 5.466 3.988 5.693 6.465.034.37.303.673.673.673.37 0 .64-.303.673-.673.227-2.477 4.06-4.831 5.689-6.46A9.002 9.002 0 0 0 12 1zm0 12.079a3.079 3.079 0 1 1 0-6.158 3.079 3.079 0 0 1 0 6.158z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">{{ review.author_name }}</h3>
                            </div>
                            <div class="flex text-yellow-400">
                                <span v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-200'">★</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-xs leading-relaxed">
                            {{ review.text }}
                        </p>
                    </div>
                </div>

                <div v-else class="bg-white p-12 rounded-xl border border-gray-200 text-center text-gray-500">
                    Отзывы не найдены. Пожалуйста, проверьте настройки подключения.
                </div>
            </div>

            <!-- Правая колонка: Рейтинг -->
            <div class="w-64" v-if="yandexData">
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div class="text-5xl font-bold text-gray-900 mb-2">{{ yandexData.rating }}</div>
                    <div class="flex justify-center text-yellow-400 text-xl mb-4">
                        <span v-for="i in 5" :key="i" :class="i <= Math.round(yandexData.rating) ? 'text-yellow-400' : 'text-gray-200'">★</span>
                    </div>
                    <div class="text-xs text-gray-400 border-t pt-4">
                        Всего отзывов: {{ yandexData.reviews_count }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
