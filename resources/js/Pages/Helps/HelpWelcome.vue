<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';

interface Engine {
    id: string;
    name: string;
    slug: string;
}

interface Props {
    engines: Engine[];
}

const props = withDefaults(defineProps<Props>(), {

});

</script>

<template>
<Layout>
<div class="px-4 py-2 max-w-7xl mx-auto dark:bg-gray-950">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center">WordCraft Help Guide</h1>
        <p class="text-center mt-2">Everything you need to know to master WordCraft</p>
    </div>

    <!-- Introduction Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">1. Introduction to WordCraft</h2>
        <p class="leading-relaxed">
        WordCraft is a tool designed to help you expand your vocabulary and improve your language skills.
        Whether you're learning English or just want to keep track of important words, WordCraft makes it
        easy to add, manage, and revise words.
        </p>
    </section>

    <!-- How it Works Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">2. How WordCraft Works</h2>
        <p class="leading-relaxed mb-4">
        With WordCraft, you can:
        </p>
        <ul class="list-disc list-inside mb-4">
        <li><strong>Add new words:</strong> Enter a word, and our AI provides definitions, synonyms, antonyms, word types, and more.</li>
        <li><strong>Tag words:</strong> You can tag your words with custom labels and easily search for them later.</li>
        <li><strong>Review and study:</strong> Access your word lists anytime to review and reinforce your understanding.</li>
        </ul>
    </section>

    <!-- Getting Started Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">3. Getting Started</h2>
        <p class="leading-relaxed mb-4">Here’s a step-by-step guide on how to use WordCraft:</p>

        <div class="mb-6">
        <h3 class="text-xl font-semibold mb-2">Step 1: Add a Word</h3>
        <p class="leading-relaxed">
            On the main page, enter the word you want to learn or remember. Once you hit "Add," our AI gathers all the information for you, including:
        </p>
        <ul class="list-disc list-inside ml-6">
            <li>Definition(s)</li>
            <li>Synonyms and antonyms</li>
            <li>Word type (noun, verb, adjective, etc.)</li>
            <li>Related words</li>
        </ul>
        </div>

        <div>
        <h3 class="text-xl font-semibold mb-2">Step 3: Study and Revise</h3>
        <p class="leading-relaxed">
            Revisit your word lists anytime! You can filter them by list or search for a specific word to refresh your memory. Each word comes with useful metadata, so you’ll always have context when revising.
        </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">4. Useful Features</h2>
        <ul class="list-disc list-inside ml-6 leading-relaxed">
            <li><strong>Add new word or sentence:</strong> You can quickly and efficiently add a new word.</li>
            <li><strong>Search Function:</strong> Use the search bar to quickly find any word in your database.</li>
            <li><strong>Tagging Words:</strong> Add custom tags to group your words based on themes or personal preferences.</li>
        </ul>
    </section>

    <!-- Study Tips Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">5. Tips for Maximizing Your Learning</h2>
        <ul class="list-disc list-inside ml-6 leading-relaxed">
            <li><strong>Consistency is Key:</strong> Add a few new words each day to reinforce your learning.</li>
            <li><strong>Use Tags Effectively:</strong> Group words with tags like "difficult," "common," or "technical" for easier revision later.</li>
        </ul>
    </section>

    <!-- FAQ Section -->
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">6. Frequently Asked Questions</h2>
        <div class="mb-4">
        <h3 class="font-semibold">Q: Can I use WordCraft for languages other than English?</h3>
        <p class="leading-relaxed">A: Currently, WordCraft focuses on English, but we plan to add support for other languages in the future.</p>
        </div>
        <div class="mb-4">
        <h3 class="font-semibold">Q: How do I delete a word from my list?</h3>
        <p class="leading-relaxed">A: It's coming soon.</p>
        </div>
        <div class="mb-4">
        <h3 class="font-semibold">Q: Can I export my word lists?</h3>
        <p class="leading-relaxed">A: It's coming soon.</p>
        </div>
        <div class="mb-4">
        <h3 class="font-semibold">Q: I noticed some incorrect information about a word. Can I fix it?</h3>
        <p class="leading-relaxed">A: Yes, you can regenerate the word's informations yourself.</p>
        </div>
    </section>
</div>
</Layout>
</template>
