<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

interface Props {
    title: string;
    description?: string;
}

const props = withDefaults(defineProps<Props>(), {
    description: ''
});
</script>

<template>
    <Head :title="title ? title : 'Wordcraft'">
        <title inertia>{{ title }}</title>
        <meta name="description" :content="description">
    </Head>
</template>
