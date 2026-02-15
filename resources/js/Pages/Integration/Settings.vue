<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    company: Object,
});

const form = useForm({
    yandex_url: props.company?.yandex_url ?? '',
});

const submit = () => {
    form.post(route('settings.store'));
};
</script>

<template>
    <Head title="Настройка" />

    <AuthenticatedLayout>
        <div class="max-w-4xl">
            <h1 class="text-2xl font-medium text-gray-900 mb-6">Подключить Яндекс</h1>
            
            <p class="text-gray-500 text-sm mb-4 flex items-center gap-1">
                Укажите ссылку на Яндекс, пример 
                <span class="text-gray-400 underline ml-1">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</span>
            </p>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="max-w-xl">
                    <input
                        id="yandex_url"
                        type="url"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-400 text-sm py-2 px-3"
                        v-model="form.yandex_url"
                        required
                    />
                    <div v-if="form.errors.yandex_url" class="mt-2 text-sm text-red-600">
                        {{ form.errors.yandex_url }}
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-8 rounded-lg shadow-sm transition duration-150 ease-in-out disabled:opacity-50"
                >
                    Сохранить
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
