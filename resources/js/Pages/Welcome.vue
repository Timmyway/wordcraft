<script setup>
import TwAuthorCredit from '@/Components/media/TwAuthorCredit.vue';
import Layout from '../Layouts/Layout.vue';
</script>

<template>
<Layout>
    <section>
        <div class="bg-orange-300 bg-no-repeat bg-contain bg-right relative bg-blend-multiply"
            style="background-image: url('images/pages/login/background.WebP');"
        >
                <tw-author-credit>
                    <!-- Image by natanaelginting on Freepik -->
                </tw-author-credit>
            <div class="min-h-dvh">
                <div class="max-w-2xl rounded-b-lg mx-auto px-12 py-6 text-center bg-white/80">
                    <h1 class="text-3xl font-black uppercase lg:text-6xl">WORDCRAFT: Master Your Words</h1>
                    <p class="py-6 text-lg max-w-xl mx-auto text-gray-800 xl:text-xl leading-8">
                        Welcome to WordCraft, the ultimate destination for mastering the art of words.
                        Powered by advanced AI, explore definitions, synonyms, antonyms, and much more.
                        <br><br>
                        Elevate your vocabulary and uncover new ways to express your thoughts effortlessly!
                    </p>
                    <Link :href="route('word.list')"
                        class="call-to-action-button mt-8 py-4 px-3 flex items-center justify-center text-xl font-black border-primary border-4 rounded-full lg:text-3xl lg:py-8 lg:px-6 transition-all duration-100"
                        style="text-decoration: none;"
                    >
                        Get Started with WordCraft
                    </Link>
                </div>
            </div>
        </div>
    </section>
</Layout>
</template>

<style>
@keyframes futuristic-glow {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.01);
  }
  100% {
    transform: scale(1);
  }
}

.call-to-action-button {
  background-color: rgb(160, 229, 153);
  border: none;
  padding: 30px 30px;
  /* font-size: 18px; */
  cursor: pointer;
  /* border-radius: 5px; */
  transition: all 0.3s ease-in-out;
  animation: futuristic-glow .7s infinite;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}

.call-to-action-button:hover {
  transform: scale(1.1);
}
</style>
