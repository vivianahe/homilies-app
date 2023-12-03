<script setup>
import Header from "../Header.vue";
import Carousel from "../Carousel.vue";
import HomilyDay from "../HomilyDay.vue";
import Priest from "../Priest.vue";
import Footer from "../Footer.vue";
import Contact from "../Contact.vue";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
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
</script>

<template>
  <Header />
  <carousel />
  <HomilyDay />
  <Priest />
  <Contact id="contacto" />
  <Footer />

  <div>
    <!-- Contenido de tu sitio aquí -->

    <button v-show="showBackToTopButton" @click="scrollToTop" class="fixed bottom-4 right-4 w-12 h-12 bg-custom-blue text-white rounded-full shadow-lg hover:bg-blue-700 transition-all 
      duration-300 z-50">
      <i class="fa-solid fa-arrow-up"></i>
    </button>
  </div>
</template>
