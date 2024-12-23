@extends('layouts.app')
@section('title', "")
@section('description', "")

@section('content')
<main class="h-full bg-secondary">
    <section class="relative block" style="height: 500px;">
      <div
        class="absolute top-0 w-full h-full bg-center bg-cover"
        style='background-image: url("{{ asset('images/about/banner.jpg') }}");'
      >
        <span
          id="blackOverlay"
          class="w-full h-full absolute opacity-10 bg-pink-300"
        ></span>
      </div>
      <div
        class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
        style="height: 70px;"
      >
        <svg
          class="absolute bottom-0 overflow-hidden"
          xmlns="http://www.w3.org/2000/svg"
          preserveAspectRatio="none"
          version="1.1"
          viewBox="0 0 2560 100"
          x="0"
          y="0"
        >
          <polygon
            class="text-pink-100 fill-current"
            points="2560 0 2560 100 0 100"
          ></polygon>
        </svg>
      </div>
    </section>
    <section class="relative py-16 bg-pink-100">
      <div class="container mx-auto px-4">
        <div
          class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64"
        >
          <div class="px-6">
            <div class="text-center mt-12">
              <h3
                class="text-4xl font-semibold leading-normal mb-2 text-gray-800"
              >
                À propos de Jeuxgagne.fr
              </h3>
            </div>
            <div class="mt-5 py-5 border-t border-gray-300 text-justify">
              <div class="flex flex-wrap justify-center">
                <div class="w-full lg:w-9/12 px-4 mb-8">
                  <p class="mb-4 text-lg leading-relaxed text-gray-800 lg:mb-8">
                    Sur Jeuxgagne nous vous proposons très régulièrement des jeux concours, des enquêtes et des produits à tester.
                    Tous nos événements sont 100% gratuits et les dotations sont financées par nos sponsors. Pour participer,
                    il vous suffit de vous inscrire en remplissant le formulaire de l’un de nos jeux. Pour ne manquer aucune occasion de remporter
                    les lots proposés vous pouvez aussi vous inscrire à notre newsletter.
                    Bonne chance !
                  </p>
                  <a href="{{ route('home') . '#liste-des-jeux' }}" class="px-4 py-4 rounded-lg font-bold focus:outline-none text-white bg-gradient-to-r from-primary via-secondary to-yellow hover:bg-gradient-to-r hover:from-dark hover:to-primary">
                    Découvrez nos jeux
                    <img src="{{ asset('images/home/icons/arrow-right.svg')}}" alt="" class="inline-block ml-2 h-2.5 w-4">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
