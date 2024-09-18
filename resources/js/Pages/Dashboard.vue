<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';
</script>

<template>
    <layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-bold py-2">Welcome to Wordcraft Dashboard</h1>
                        <p>
                            Here, you can manage words, tags...
                        </p>
                    </div>

                    <div class="px-1 py-2 lg:px-8 lg:py-4">
                        <h2 class="font-bold text-2xl text-primary">Manage</h2>
                        <div class="py-4">
                            <Link
                                class="btn btn-xs text-base bg-yellow-400"
                                :href="route('word.index')">
                                <i class="fas fa-light-bulb"></i>
                                <span>Words and sentences</span>
                            </Link>
                        </div>
                        <div class="py-4">
                            <Link
                                class="btn btn-xs text-base bg-yellow-400"
                                :href="route('tag.index')">
                                <i class="fas fa-light-bulb"></i>
                                <span>Tags</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>
