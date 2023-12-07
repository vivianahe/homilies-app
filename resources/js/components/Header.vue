<template>
  <nav class="bg-custom-blue border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
      <button data-collapse-toggle="navbar-default" type="button"
        class="inline-flex items-center p-2 w-10 h-10 bg-custom-blue justify-center text-sm text-white rounded-lg md:hidden hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-gray-200"
        aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul
          class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-custom-blue md:flex-row md:space-x-8 md:mt-0 md:border-0">
          <li :class="{ 'border-b-2 border-white': $route.name === 'pag' }">
            <RouterLink :to="{ name: 'inicio' }"
              class="block py-2 pl-3 pr-4 text-white rounded hover:bg-cyan-500 md:hover:bg-transparent md:border-0 md:hover:text-custom-gray-me md:p-0">
              <i class="fa-solid fa-house mr-2"></i>
              Inicio
            </RouterLink>
          </li>
          <li :class="{ 'border-b-2 border-white': $route.name === 'homilyAll' }">
            <RouterLink :to="{ name: 'homilyAll' }"
              class="block py-2 pl-3 pr-4 text-white rounded hover:bg-cyan-500 md:hover:bg-transparent md:border-0 md:hover:text-custom-gray-me md:p-0">
              <i class="fa-solid fa-book-bible mr-2"></i>
              Homilías
            </RouterLink>
          </li>
          <li :class="{ 'border-b-2 border-white': $route.name === 'contact' }">
            <RouterLink :to="{ name: 'contact' }"
              class="block py-2 pl-3 pr-4 text-white rounded hover:bg-cyan-500 md:hover:bg-transparent md:border-0 md:hover:text-custom-gray-me md:p-0">
              <i class="fa-solid fa-envelope-circle-check mr-2"></i>
              Contáctanos
            </RouterLink>
          </li>
          <li :class="{ ' hover:text-custom-gray-me border-b-2 border-white': $route.name === 'donateView' }">
            <RouterLink :to="{ name: 'donateView' }"
              class="block py-2 pl-3 pr-4 text-white rounded hover:bg-cyan-500 md:hover:bg-transparent md:border-0 md:hover:text-custom-gray-me md:p-0">
              <i class="fa-solid fa-hand-holding-heart mr-2"></i>
              Donar
            </RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { RouterLink } from "vue-router";
</script>
