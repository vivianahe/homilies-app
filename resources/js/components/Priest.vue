<template>
  <section>
    <div class="mx-auto max-w-screen-xl lg:py-16">
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg p-8 md:p-6">
          <p class="mb-3 font-bold text-custom-text md:text-2xl">
            Oración del día
          </p>
          <iframe width="260" height="315" :src="'https://www.youtube.com/embed/' +
            dataPrayerDesc.link
            " frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="bg-white rounded-lg p-2 md:p-6">
          <p class="mb-3 font-bold text-custom-text md:text-2xl">Sacerdote</p>
          <p class="mb-3 text-black font-semibold">
            Uriel Alejandro Franco Sánchez
          </p>
          <p id="texto" class="mb-3 text-gray-500">
            {{ showFullText ? fullText : halfText }}
          </p>
          <button @click="toggleText" class="text-blue-500 cursor-pointer">
            {{ showFullText ? "Ver menos" : "Ver más" }}
          </button>
        </div>
        <div class="md:flex md:flex-col md:items-center">
          <div class="relative bg-white rounded-lg sm:p-8 md:p-6">
            <div class="absolute inset-0 bg-no-repeat bg-center bg-cover md:bg-contain"
              style="background-image: url('/img/decoration.png')"></div>
            <img class="h-auto w-auto rounded-full relative z-10 mx-auto" src="/img/padre1.jpg" alt="Sacerdote" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const fullText = ref('Presbítero Magister - sacerdote de la Diócesis de Neiva, Colombia. Graduado de la Licenciatura en Matemáticas, Normalista de la Escuela Normal Superior de Neiva. Licenciado en Filosofía y Educación Religiosa de la Universidad Católica de Oriente en Rionegro – Antioquia. Teólogo de la misma universidad; Realizó sus estudios eclesiales en el seminario Cristo Sacerdote de la Ceja (Antioquia) en la asociación Siervos del Espíritu Santo – Magister en Asesoría Familiar y Gestión de proyectos de la Familia de la Universidad de la Sabana en Bogotá. Músico del conservatorio departamental del Huila y delegado Diocesano de la Pastoral Familiar y actualmente sacerdote de la Parroquia Jesús Obrero de Neiva.');

const halfText = ref('');
const showFullText = ref(false);

const dataPrayerDesc = ref([]);
const getPrayerDesc = async () => {
  const { data } = await axios.get('/prayers');
  dataPrayerDesc.value = data[0];
};
onMounted(() => {
  getPrayerDesc();
  const halfLength = Math.ceil(fullText.value.length / 2);
  halfText.value = fullText.value.slice(0, halfLength)+'...';
});
const toggleText = () => {
  showFullText.value = !showFullText.value;
};
</script>
