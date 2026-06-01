<template>

  <Header />

  <main
    v-if="dataHomilyId"
    class="homily-page">

    <pre>
{{ dataHomilyId }}
</pre>

    <div class="detail-layout">

      <div>

        <HomilyHero
          :homily="dataHomilyId"
        />

        <HomilyAudio
          :homily="dataHomilyId"
        />

        <HomilyMessage
          :message="dataHomilyId.message"
        />

        <HomilyGospel
          :homily="dataHomilyId"
        />

      </div>

      <HomilySidebar />

    </div>

  </main>

  <BackToTop />

  <Footer />

</template>

<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";

import HomilyHero from "../detailHomilies/HomilyHero.vue";
import HomilyAudio from "../detailHomilies/HomilyAudio.vue";
import HomilyMessage from "../detailHomilies/HomilyMessage.vue";
import HomilyGospel from "../detailHomilies/HomilyGospel.vue";
import HomilySidebar from "../detailHomilies/HomilySidebar.vue";
import BackToTop from "../detailHomilies/BackToTop.vue";



import { useRoute } from "vue-router";
import { onMounted, ref, onBeforeUnmount } from "vue";
import axios from "axios";
import { initFlowbite } from "flowbite";

const route = useRoute();
const HomilyId = route.params.id;
const dataHomilyId = ref(null);
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
<style scoped>

.homily-page{
  max-width: 1600px;
  margin: 0 auto;
  padding: 30px;
}

.detail-layout{
  display:grid;
  grid-template-columns: minmax(0, 1fr) 420px;
  gap:30px;
  align-items:start;
}

@media(max-width:1200px){

  .detail-layout{
    grid-template-columns:1fr;
  }

}

</style>