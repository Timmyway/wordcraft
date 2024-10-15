<script setup>
import { computed } from 'vue';
import Layout from '@/Layouts/Layout.vue';

const props = defineProps({ status: Number })

const title = computed(() => {
  return {
    503: "503: Service Unavailable - We'll be back soon!",
    500: "500: Something went wrong - We're fixing it!",
    404: "404: Page Not Found - Let's help you get back on track!",
    403: "403: Access Denied - This area is off-limits!",
  }[props.status]
})

const description = computed(() => {
  return {
    503: "We're just freshening things up! Our site is taking a quick break for improvements. Please check back in a few minutes.",
    500: "Oops! Looks like our system is taking an unexpected nap. We're working on waking it up. Try again shortly!",
    404: "Hmm, we can't seem to find that page. It might be on a coffee break. Double-check the URL or try our homepage?",
    403: "Looks like you've stumbled into a restricted area. You may not need to access this part of the site. If you think you should have access, please double-check your permissions or reach out to our support team.",
  }[props.status]
})
</script>

<template>
<Layout>
    <div class="tw-error-page bg-cover bg-no-repeat p-4">
        <div class="bg-white/90 rounded p-4 max-w-2xl shadow-lg">
            <h1 class="font-black text-pink-600 text-xl lg:text-4xl">{{ title }}</h1>
            <div class="text-lg py-4">{{ description }}</div>
        </div>
    </div>
</Layout>
</template>

<style lang="scss">
.tw-error-page {
    background-image: url('../../images//error.WebP');
    min-height: 100vh;
    height: 100%;
}
</style>
