<template>
  <section class="w-full h-1/2 bg-gradient-to-b from-gray-50 to-custom-gray-me rounded-b-3xl">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
      <p class="tracking-widest text-center text-gray-500 md:text-lg">
        ENRIQUECE TU VIDA ESPIRITUAL Y ENCUENTRA INSPIRACIÓN ESCUCHANDO LA
        PALABRA DE DIOS
      </p>
      <p class="font-semibold text-center text-custom-text md:text-2xl">
        Homilías
      </p>
      <div class="grid md:grid-cols-2 mt-4">
        <!-- Primera columna -->
        <div class="rounded-lg flex justify-end items-end">
          <figure class="relative max-w-sm cursor-pointer text-center">
            <a>
              <div
                class="rounded-lg overflow-hidden transition-transform duration-200 transform scale-100 hover:scale-105">
                <img v-if="dataHomilyDesc.img" class="w-[400px] h-[400px] object-cover"
                  :src="'/support/imgHomily/' + dataHomilyDesc.img" />
              </div>
            </a>
            <figcaption class="absolute bottom-0 left-0 right-0 px-4 pb-4 text-lg text-white text-center">
              <audio controls class="mx-auto">
                <source v-if="dataHomilyDesc.audio"
                  :src="'/support/audioHomily/' + dataHomilyDesc.audio" type="audio/*" />
                Tu navegador no admite el elemento de audio.
              </audio>
            </figcaption>
          </figure>
        </div>
        <!-- Segunda columna -->
        <div class="rounded-lg flex justify-start items-start">
          <div class="max-w-md p-8 bg-white border border-gray-200 rounded-lg shadow mt-7">
            <a>
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                Evangelio del día
              </h5>
            </a>
            <p class="mb-3 text-sm font-normal text-gray-400">
              {{
                dataHomilyDesc.date ? convertirFecha(dataHomilyDesc.date) : ""
              }}
            </p>
            <p class="mb-3 font-normal text-gray-700" v-html="sanitizedGospel"></p>
            <div class="justify-end text-end">
              <RouterLink v-if="dataHomilyDesc.id" :to="{
                name: 'homilyDetail',
                params: { id: dataHomilyDesc.id },
              }"
                class="px-3 py-2 text-sm font-medium justify-end text-end text-white bg-custom-icon rounded-full hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300"
                title="Ver más">
                <i class="fa-solid fa-plus"></i>
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import axios from "axios";
import DOMPurify from "dompurify";
const dataHomilyDesc = ref([]);
const getHomilyDesc = async () => {
  const { data } = await axios.get('/homilies_desc');
  dataHomilyDesc.value = data;
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

const maxLength = 300;

const truncatedGospel = computed(() => {
  if (
    dataHomilyDesc.value.gospel &&
    dataHomilyDesc.value.gospel.length <= maxLength
  ) {
    return dataHomilyDesc.value.gospel;
  } else if (dataHomilyDesc.value.gospel) {
    return dataHomilyDesc.value.gospel.slice(0, maxLength) + "...";
  } else {
    return "";
  }
});
const sanitizedGospel = computed(() => {
  return DOMPurify.sanitize(truncatedGospel.value);
});
onMounted(() => {
  getHomilyDesc();
});
</script>
