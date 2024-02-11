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
  const { data } = await axios.get('/homilies/' + HomilyId);
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
      <img v-if="dataHomilyId.img" class="rounded-sm w-[600px] h-[400px] object-contain"
        :src="'/support/imgHomily/' + dataHomilyId.img" alt="Imagen" />
    </div>


    <div class="absolute top-0 left-0 w-1/2 h-[500px] bg-gray-200 opacity-75"></div>
  </div>

  <div class="flex flex-col md:flex-row md:items-center md:justify-center mt-8 mb-4">
    <p class="text-2xl font-semibold">Homilía</p>
    <div class="my-2 md:my-0 md:mx-2"></div>
    <!-- Espacio vertical en pantallas pequeñas, espacio horizontal en pantallas medianas y grandes -->
    <audio controls>
      <source v-if="dataHomilyId.audio" :src="'/support/audioHomily/' + dataHomilyId.audio" type="audio/mp3" />
      Tu navegador no admite el elemento de audio.
    </audio>
  </div>
  <hr />
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-8">
    <div class="main" v-if="dataHomilyId.message !== null">
        <ul class="cardst">
            <li class="cardst_item">
                <div class="card" tabindex="0">
                    <div class="card_content">
                        <h2 class="card_title md:text-2xl">Mensaje del día</h2>
                        <div class="card_text">
                            <p class="text-md text-black-50 ul_tet" v-html="dataHomilyId.message"></p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
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

<style scoped>
*,
*::before,
*::after {
    box-sizing: border-box;
}

.main {
    max-width: 1000px;
    margin: 30px auto;
}

.cardst {
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.cardst_item {
    display: flex;
    align-content: center;
    justify-content: center;
}


.card {
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    background-color: #2A8EB8;
    border-radius: 5px 25px 5px 50px;
    transition: transform 0.1s linear, box-shadow 0.2s;

}

.card_text:focus,
.card:focus {
    outline: 2px dashed transparent;
}

.card:focus,
.card:hover {
    transform: scale(1.01);
    box-shadow: 0 10px 5px -5px rgba(0, 0, 0, 0.2);
}

.card_content {
    padding: 0.5rem 1rem 1rem;
    color: #FFF;
    width: 100%;
}

.card_title {
    position: absolute;
    top: 0;
    right: 0;
    left: 18px;
    width: 100%;
    height: auto;
    color: #0072ae;
    padding: 0.5rem;
    border-radius: 5px 0 0 5px;
    transform: rotate(-3.3deg);
    transform-origin: left top;
    font-weight: 600;
    font-size: 1.325rem;
    position: relative;
    overflow: hidden;
    z-index: 1;
    background-color: #e6f4f1;
}

.card_text {
    padding: 0 1rem;
    margin-top: 10px;
}

.card_text p:first-of-type:first-letter {
    font-size: 1.325rem;
    margin-right: 0.05em;
    margin-top: 30px;
    ;
}

.p {
    margin-top: 20px;
}

@media (min-width: 480px) {
    .card_text {
        overflow: auto;
        max-height: 20rem;
        scrollbar-width: thin;
        scrollbar-color: #b4fee7 #0072ae;
    }

    .card_text::-webkit-scrollbar {
        width: 12px;
    }

    .card_text::-webkit-scrollbar-track {
        background: #0072ae;
    }

    .card_text::-webkit-scrollbar-thumb {
        background-color: #b4fee7;
    }
}

.card_text strong {
    color: #b4fee7;
}

@keyframes fly-in {
    0% {
        top: 0;
        right: 0;
        font-size: 1.325rem;
    }

    25% {
        top: 0;
        right: -200%;
        font-size: 1.325rem;
    }

    26% {
        font-size: 2rem;
    }

    100% {
        top: 2rem;
        right: 0;
        font-size: 2rem;
    }
}

@keyframes fly-out {
    0% {
        top: 2rem;
        right: 0;
        font-size: 2rem;
    }

    50% {
        top: 0;
        right: -200%;
        font-size: 1.325rem;
    }

    100% {
        top: 0;
        right: 0;
        font-size: 1.325rem;
    }
}</style>