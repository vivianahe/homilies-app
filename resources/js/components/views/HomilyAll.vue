<template>
  <Header />
  <Calendar @date-calendar="getDataHomilies" />
  <div class="flex justify-center items-center" v-if="showBtnAll">
    <button type="button"
      class="text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2"
      @click="getDataHomiliesAll">
      Mostrar todas
    </button>
  </div>
  <div class="flex justify-center items-center" v-for="homilies in displayedHomilies" :key="homilies.id">
    <a class="flex flex-col items-center bg-white border-gray-200 rounded-lg md:flex-row md:max-w-4xl">
      <img class="object-cover w-full rounded h-96 md:h-auto md:w-48 md:rounded"
        :src="'/support/imgHomily/' + homilies.img" alt="" />
      <div class="flex flex-col justify-between p-4 leading-normal">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
          {{ homilies.date ? convertirFecha(homilies.date) : "" }}
        </h5>
        <p class="mb-3 font-normal text-custom-text">{{ homilies.citation }}</p>
        <p class="mb-3 font-semibold italic text-gray-700">
          {{ homilies.title }}
        </p>
        <p class="mb-3 font-normal text-gray-700">
          {{ homilies.reading }}
        </p>
      </div>
      <div class="flex flex-col justify-between p-4 leading-normal">
        <audio controls>
          <source :src="'/support/audioHomily/' + homilies.audio" type="audio/mp3, audio/mp4" />
          Tu navegador no admite el elemento de audio.
        </audio>
        <RouterLink :to="{ name: 'homilyDetail', params: { id: homilies.id } }" type="button"
          class="mt-3 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 sm:w-full md:w-1/2 lg:w-1/3 xl:w-1/4">
          Ver
        </RouterLink>
      </div>
    </a>
  </div>
  <nav aria-label="Page navigation example">
    <ul class="flex items-center justify-center -space-x-px h-8 text-sm mb-4">
      <li>
        <a href="#"
          class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700"
          @click="previousPage">
          <span class="sr-only">Previous</span>
          <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 1 1 5l4 4" />
          </svg>
        </a>
      </li>
      <li v-for="page in totalPages" :key="page">
        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 border border-gray-300 hover:bg-gray-100 
         {{ page === currentPage ? 'bg-gray-700 text-white' : 'bg-white' }}" @click="changePage(page)">
          {{ page }}
        </a>
      </li>

      <li>
        <a href="#"
          class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700"
          @click="nextPage">
          <span class="sr-only">Next</span>
          <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 9 4-4-4-4" />
          </svg>
        </a>
      </li>
    </ul>
  </nav>
  <button v-show="showBackToTopButton" @click="scrollToTop" class="fixed bottom-4 right-4 w-12 h-12 bg-custom-blue text-white rounded-full shadow-lg hover:bg-blue-700 transition-all 
      duration-300 z-50">
    <i class="fa-solid fa-arrow-up"></i>
  </button>
  <Footer />
</template>

<script setup>
import { ref, onMounted, computed, onBeforeUnmount } from "vue";
import axios from "axios";
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import Calendar from "../Calendar.vue";
import { initFlowbite } from "flowbite";
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
const dataHomilies = ref([]);
const currentPage = ref(1);
const perPage = ref(5);
const showBtnAll = ref(false);

const totalPages = computed(() => {
  return Math.ceil(dataHomilies.value.length / perPage.value);
});

const displayedHomilies = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return dataHomilies.value.slice(start, end);
});

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const changePage = (page) => {
  currentPage.value = page;
};

const getDataHomiliesAll = () => {
  getDataHomilies();
  showBtnAll.value = false;
};
const getDataHomilies = async (fechaCalendar = "") => {
  const { data } = await axios.get('/homilies');
  if (fechaCalendar != "") {
    const homiliesWithFecha = data.filter(
      (homily) => homily.date === fechaCalendar
    );
    if (homiliesWithFecha.length > 0) {
      // La fechaCalendar existe en el arreglo, asignar el valor
      dataHomilies.value = homiliesWithFecha;
      showBtnAll.value = true;
    } else {
      Swal.fire(
        "Atención!",
        "No existe la homilía con fecha " + fechaCalendar,
        "warning"
      );
      dataHomilies.value = data;
      showBtnAll.value = false;
    }
  } else {
    dataHomilies.value = data;
  }
};

const convertirFecha = (fecha) => {
  const fechaParts = fecha.split("-");
  const year = parseInt(fechaParts[0]);
  const month = parseInt(fechaParts[1]);
  const day = parseInt(fechaParts[2]);

  const meses = [
    "enero",
    "febrero",
    "marzo",
    "abril",
    "mayo",
    "junio",
    "julio",
    "agosto",
    "septiembre",
    "octubre",
    "noviembre",
    "diciembre",
  ];

  return `${day} de ${meses[month - 1]} de ${year}`;
};

onMounted(() => {
  getDataHomilies();
  initFlowbite();
});
</script>
