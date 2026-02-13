<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-1">
                    <div class="text-[#1D2939] font-bold text-2xl flex items-center">
                        <svg class="w-8 h-8 mr-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 6L22 16L10 26" stroke="#0085FF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Daily Grow
                    </div>
                </div>

                <div class="mb-8 px-2 text-[#98A2B3] text-sm font-normal uppercase tracking-wider">
                    {{ $page.props.auth.user.name }}
                </div>

                <nav class="space-y-1">
                    <div class="flex items-center gap-2 text-gray-400 mb-2 mt-4 px-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium text-gray-900">Отзывы</span>
                    </div>
                    
                    <Link 
                        :href="route('reviews.index')" 
                        class="block px-8 py-2 text-sm font-medium rounded-lg"
                        :class="route().current('reviews.index') ? 'bg-gray-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                    >
                        Отзывы
                    </Link>
                    <Link 
                        :href="route('settings.edit')" 
                        class="block px-8 py-2 text-sm font-medium rounded-lg"
                        :class="route().current('settings.edit') ? 'bg-gray-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                    >
                        Настройка
                    </Link>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-end px-8 flex-shrink-0">
                <Link :href="route('logout')" method="post" as="button" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </Link>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
