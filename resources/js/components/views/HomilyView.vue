<script setup>
import Header from "../Header.vue";
import Carousel from "../Carousel.vue";
import HomilyDay from "../HomilyDay.vue";
import Priest from "../Priest.vue";
import Footer from "../Footer.vue";
import Reflection from "../Reflection.vue";
import ReflectionWork from "../ReflectionWork.vue";
import MessageTip from "../MessageTip.vue";
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
  <MessageTip />
  <ReflectionWork />
  <Priest />
  <Reflection />
  <Contact id="contacto" />
  <Footer />

  <div>
    <!-- Contenido de tu sitio aquí -->
    <!-- Tu código HTML existente -->

    <a href="https://wa.link/11pcwe"
      class="fixed bottom-20 right-4 w-12 h-12 bg-custom-wp text-white rounded-full shadow-lg hover:bg-green-700 transition duration-300 z-40 flex items-center justify-center">
      <i class="fa-brands fa-whatsapp fa-2x"></i>
    </a>


    <!-- Más código HTML si es necesario -->

    <button v-show="showBackToTopButton" @click="scrollToTop" class="fixed bottom-4 right-4 w-12 h-12 bg-custom-blue text-white rounded-full shadow-lg hover:bg-blue-700 transition-all 
    duration-300 z-40">
      <i class="fa-solid fa-arrow-up"></i>
    </button>
  </div>
</template>
