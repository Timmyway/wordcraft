<script setup lang="ts">
import Layout from '@/Layouts/Layout.vue';

</script>

<template>
<Layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="max-w-md w-full text-center">
      <!-- Error Icon -->
      <div class="bg-red-100 rounded-full p-6 inline-flex items-center justify-center">
        <svg
          class="w-16 h-16 text-red-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M18.364 5.636l-12.728 12.728m12.728 0L5.636 5.636l12.728 12.728z"
          />
        </svg>
      </div>

      <!-- Error Text -->
      <h1 class="text-5xl font-bold text-gray-900 mt-6">403</h1>
      <p class="text-xl text-gray-600 mt-2">
        Oups ! Vous n'avez pas la permission d'accéder à cette page.
      </p>

      <!-- Call-to-action Button -->
      <div class="mt-6">
        <inertia-link
          href="/"
          class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300"
        >
          Retour à l'accueil
        </inertia-link>
      </div>

      <!-- Back to previous page -->
      <div class="mt-4">
        <button
          @click="goBack"
          class="text-blue-600 hover:underline"
        >
          Revenir à la page précédente
        </button>
      </div>
    </div>
  </div>
</Layout>
</template>
