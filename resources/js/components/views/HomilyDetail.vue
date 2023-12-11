<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import { useRoute } from "vue-router";
import { onMounted, ref, onBeforeUnmount } from "vue";
import axios from "axios";
import { initFlowbite } from "flowbite";

const route = useRoute();
const HomilyId = route.params.id;
const dataHomilyId = ref([]);
const showBackToTopButton = ref(false);

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};

const checkScrollPosition = () => {
  showBackToTopButton.value = window.scrollY > 100; // Cambia 100 al valor deseado para mostrar el botón
};

onMounted(() => {
  window.addEventListener("scroll", checkScrollPosition);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", checkScrollPosition);
});
const getHomilyId = async () => {
  const { data } = await axios.get('/homilies/'+ HomilyId);
  dataHomilyId.value = data;
};
const convertirFecha = (fecha) => {
  const fechaParts = fecha.split("-");
  const year = parseInt(fechaParts[0]);
  const month = parseInt(fechaParts[1]);
  const day = parseInt(fechaParts[2]);

  const meses = [
    "ENE",
    "FEB",
    "MAR",
    "ABR",
    "MAY",
    "JUN",
    "JUL",
    "AGO",
    "SEP",
    "OCT",
    "NOV",
    "DIC",
  ];

  return `${day} ${meses[month - 1]}`;
};

onMounted(() => {
  getHomilyId();
  initFlowbite();
});
</script>

<template>
  <Header />
  <div class="flex items-center justify-center p-4">
    <div class="bg-gray-600 rounded-full w-32 h-32">
      <p class="text-3xl text-white font-semibold text-center mt-11">
        {{ dataHomilyId.date ? convertirFecha(dataHomilyId.date) : "" }}
      </p>
    </div>
    <blockquote class="text-lg italic font-semibold text-gray-900 ml-4">
      <p>
        {{ dataHomilyId.title }}
      </p>
    </blockquote>
  </div>

  <div class="flex justify-center items-center relative">
    <div class="relative z-10 mt-10 mb-10">
      <img v-if="dataHomilyId.img" class="rounded-sm w-[800px] h-[300px] object-cover"
        :src="'/support/imgHomily/' + dataHomilyId.img" alt="Imagen" />
    </div>

    <div class="absolute top-0 left-0 w-1/2 h-[400px] bg-gray-200 opacity-75"></div>
  </div>

  <div class="flex flex-col md:flex-row md:items-center md:justify-center mt-8 mb-4">
    <p class="text-2xl font-semibold">Homilía</p>
    <div class="my-2 md:my-0 md:mx-2"></div>
    <!-- Espacio vertical en pantallas pequeñas, espacio horizontal en pantallas medianas y grandes -->
    <audio controls>
      <source v-if="dataHomilyId.audio" :src="'/support/audioHomily/' + dataHomilyId.audio"
        type="audio/mp3" />
      Tu navegador no admite el elemento de audio.
    </audio>
  </div>
  <hr />
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
    <p class="mb-3 text-lg text-black md:text-xl font-semibold">
      <i class="fa-solid fa-file-lines mr-3"></i> Evangelio
    </p>
    <p class="mb-3 text-sm text-black-50 md:text-sm">
      {{ dataHomilyId.citation }}
    </p>
    <p class="mb-3 text-lg text-gray-600 md:text-xl">
      {{ dataHomilyId.reading }}
    </p>

    <p class="text-gray-500" v-html="dataHomilyId.gospel"></p>
  </div>
  <hr />
  <br />
  <button v-show="showBackToTopButton" @click="scrollToTop" class="fixed bottom-4 right-4 w-12 h-12 bg-custom-blue text-white rounded-full shadow-lg hover:bg-blue-700 transition-all 
      duration-300 z-50">
    <i class="fa-solid fa-arrow-up"></i>
  </button>
  <Footer />
</template>
