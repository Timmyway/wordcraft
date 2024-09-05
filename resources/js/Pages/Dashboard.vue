<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
</script>

<template>
    <layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">Welcome to Vocatools</div>

                    <div class="px-8 py-4">
                        <h2 class="font-bold text-2xl text-indigo-600">Manage</h2>
                        <div class="py-4">
                            <Link
                                class="btn btn-xs text-base bg-yellow-400"
                                :href="route('word.list')">
                                <i class="fas fa-light-bulb"></i>
                                <span>Word list</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>
