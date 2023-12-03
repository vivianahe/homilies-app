<template>
  <section>
    <div class="mx-auto max-w-screen-xl lg:py-16">
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg p-8 md:p-12">
          <p class="mb-3 font-bold text-custom-text md:text-2xl">
            Oración del día
          </p>
          <iframe width="260" height="315" :src="'https://www.youtube.com/embed/' +
            dataPrayerDesc.link
            " frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="bg-white rounded-lg p-8 md:p-12">
          <p class="mb-3 font-bold text-custom-text md:text-2xl">Sacerdote</p>
          <p class="mb-3 text-black font-semibold">
            Uriel Alejandro Franco Sánchez
          </p>
          <p class="mb-3 text-gray-500">
            So I started to walk into the water. I won't lie to you boys, I was
            terrified. But I pressed on, and as I made my way past the breakers
            a strange calm came over me. I don't know if it was divine
            intervention or the kinship of all living things but I tell you
            Jerry at that moment, I was a marine biologist.
          </p>
        </div>
        <div class="md:flex md:flex-col md:items-center">
          <div class="relative bg-white rounded-lg sm:p-8 md:p-12">
            <div class="absolute inset-0 bg-no-repeat bg-center bg-cover md:bg-contain"
              style="background-image: url('/img/decoration.png')"></div>
            <img class="h-auto max-w-full rounded-full relative z-10 mx-auto" src="/img/sacerdote.jpg" alt="Sacerdote" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
const dataPrayerDesc = ref([]);
const getPrayerDesc = async () => {
  const { data } = await axios.get('/prayers');
  dataPrayerDesc.value = data[0];
};
onMounted(() => {
  getPrayerDesc();
});
</script>
