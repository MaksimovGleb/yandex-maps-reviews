<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Добро пожаловать" />
    <div class="relative flex min-h-screen flex-col items-center justify-center bg-gray-100 selection:bg-[#FF2D20] selection:text-white font-sans">
        <div class="w-full max-w-md bg-white p-8 shadow-md rounded-lg text-center">
            <h1 class="text-2xl font-bold mb-6 text-gray-900">Yandex Maps Reviews</h1>
            
            <div v-if="canLogin" class="space-x-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('reviews.index')"
                    class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                >
                    Перейти в сервис
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                    >
                        Войти
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="inline-block px-6 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition"
                    >
                        Регистрация
                    </Link>
                </template>
            </div>
        </div>
    </div>
</template>
