<template>
  <Header />

  <section class="bg-custom-found">
    <div class="flex justify-center">
      <img src="/img/4.png" alt="" class="w-1/2 md:w-1/4 lg:w-1/4" />
      <img src="/img/donate.png" alt="" class="w-1/2 md:w-1/4 lg:w-1/4 mx-auto mt-6" />
      <img src="/img/3.png" alt="" class="w-1/2 md:w-1/4 lg:w-1/4" />
    </div>
    <div class="py-8 px-9 mx-auto max-w-screen-xl text-center lg:py-10">
      <p class="mb-3 text-base md:text-lg lg:text-xl xl:text-xl font-medium text-custom-text">
        Tu contribución es un acto de Fe que respalda nuestra misión de difundir
        la palabra de Dios y llevar su amor a los corazones necesitados.
      </p>
      <p class="mb-3 text-base md:text-lg lg:text-xl xl:text-xl font-semibold text-custom-text"
        style="display: inline-block">
        Ayúdanos con tu
      </p>
      <p class="mb-3 text-base md:text-lg lg:text-xl xl:text-xl font-semibold text-custom-text-yell"
        style="display: inline-block">
        &nbsp;ofrenda
      </p>
      <p class="mb-3 text-base md:text-lg lg:text-xl xl:text-1xl font-semibold text-custom-text">
        La puedes realizar mediante la cuenta de ahorros de Bancolombia
      </p>
      <p class="mb-3 text-base md:text-xl lg:text-xl xl:text-1xl font-medium text-custom-text underline">
        Abraham dio el diezmo a Melquisedec, el sacerdote de Dios (Génesis 14:20)
      </p>


      <a href="https://wa.link/kw36eo" type="button" title="Copiar cuenta"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">Ir
        a donar</a>
    </div>
  </section>

  <Footer />
</template>

<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import { onMounted, ref } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>
