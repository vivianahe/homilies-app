<template>

  <Header />

  <div
    v-if="loading"
    class="loading-overlay"
  >
    <div class="loading-content">

      <div class="spinner"></div>

      <p>
        Cargando homilía...
      </p>

    </div>
  </div>

  <main
    v-if="dataHomilyId"
    class="homily-page">

    <div class="page-nav">

      <button
        class="back-button"
        @click="goToHomilies"
      >
        <i class="fa-solid fa-arrow-left"></i>
        <span>Volver a homilías</span>
      </button>

    </div>

    <div class="detail-layout">

      <div>

        <HomilyHero
          :homily="dataHomilyId"
        />

        <HomilyAudio
          :homily="dataHomilyId"
        />
        <br>
    
        <HomilyGospel
          :homily="dataHomilyId"
        />

        <div class="content-grid">

          <HomilyDescription
            :description="dataHomilyId.description"
          />

          <HomilyMessage
            :message="dataHomilyId.message"
          />

        </div>

      </div>

      <HomilySidebar
        :homilies="relatedHomilies"
      />
    </div>

  </main>

  <BackToTop />

  <Footer />

</template>

<script setup>

import { useRouter } from 'vue-router';

import Header from "../Header.vue";
import Footer from "../Footer.vue";

import HomilyHero from "../detailHomilies/HomilyHero.vue";
import HomilyAudio from "../detailHomilies/HomilyAudio.vue";
import HomilyMessage from "../detailHomilies/HomilyMessage.vue";
import HomilyGospel from "../detailHomilies/HomilyGospel.vue";
import HomilySidebar from "../detailHomilies/HomilySidebar.vue";
import BackToTop from "../detailHomilies/BackToTop.vue";
import HomilyDescription from "../detailHomilies/HomilyDescription.vue";


import { useRoute } from "vue-router";
import { onMounted, ref, onBeforeUnmount, watch } from "vue";

import axios from "axios";
import { initFlowbite } from "flowbite";

const route = useRoute();
const HomilyId = route.params.id;
const dataHomilyId = ref(null);
const relatedHomilies = ref([]);
const showBackToTopButton = ref(false);
const loading = ref(true);

const router = useRouter();

const goToHomilies = () => {
  router.push({ name: 'homilyAllNew' });
}

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

const getHomilyId = async (id) => {

  const { data } = await axios.get(
    '/homilies/detail/' + id
  );

  dataHomilyId.value = data;

};

const getRelatedHomilies = async (id) => {

  const { data } = await axios.get(
    `/homilies/related/${id}`
  );

  relatedHomilies.value = data;

};

const loadPage = async (id) => {

  loading.value = true;

  try {

    await Promise.all([
      getHomilyId(id),
      getRelatedHomilies(id)
    ]);

  } catch (error) {

    console.error(error);

  } finally {

    loading.value = false;

  }

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

onMounted(async () => {

  await loadPage(route.params.id);

  initFlowbite();

});

watch(
  () => route.params.id,
  async (newId) => {

    await loadPage(newId);

    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });

  }
);

</script>
<style scoped>

.homily-page{
  width:100%;
  max-width:none;

  padding:20px 24px;
}

.detail-layout{
  display:grid;
  grid-template-columns:minmax(0,1fr) 460px;
  gap:32px;
}

.content-grid{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:24px;
  margin:24px 0;
}

.content-grid > *{
  min-width:0;
}
.page-nav{
  display:flex;
  align-items:center;
  justify-content:space-between;

  margin-bottom:22px;
}

.back-button{
  display:flex;
  align-items:center;
  gap:10px;

  padding:12px 18px;

  background:#fff;
  color:#2563eb;

  font-size:.95rem;
  font-weight:700;

  cursor:pointer;

  transition:all .25s ease;
}

.back-button i{
  font-size:.9rem;
}

.loading-overlay{
  position:fixed;
  inset:0;

  background:rgba(255,255,255,.85);
  backdrop-filter:blur(4px);

  display:flex;
  align-items:center;
  justify-content:center;

  z-index:9999;
}

.loading-content{
  text-align:center;
}

.spinner{
  width:56px;
  height:56px;

  border:4px solid #3b82f6;
  border-top-color:transparent;

  border-radius:50%;

  animation:spin .8s linear infinite;

  margin:0 auto;
}

.loading-content p{
  margin-top:16px;

  color:#64748b;

  font-weight:600;
}

@keyframes spin{
  to{
    transform:rotate(360deg);
  }
}

@media(max-width:768px){

  .page-nav{
    flex-direction:column;
    align-items:stretch;
    gap:12px;
  }

}

@media(max-width:992px){

  .content-grid{
    grid-template-columns:1fr;
  }

}

@media(max-width:1200px){

  .detail-layout{
    grid-template-columns:1fr;
  }

}

@media(max-width:768px){

  .homily-page{
    padding:12px;
  }

}
</style>