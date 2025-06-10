<template>
  <section class="py-8">
    <div
      class="w-full mx-auto max-w-screen-xl p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border border-indigo-100 rounded-xl shadow-lg">
      <h2 class="text-2xl font-bold mb-8 text-custom-text text-center">9 días de oración y reflexión para pedir a Dios por tu trabajo</h2>

      <div class="grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
        <div v-for="(reflection, index) in reflections" :key="index"
          class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-indigo-50">
          <button @click="toggleOpen(index)" class="w-full cursor-pointer flex items-start focus:outline-none">
            <span
              class="bg-indigo-100 text-custom-text font-bold rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">
              {{ index + 1 }}
            </span>
            <span
              class="font-medium text-lg text-gray-700 hover:text-custom-text transition-colors duration-200 text-left">
              {{
                openIndex === index
                  ? reflection.title
                  : truncate(reflection.title, 60) + (reflection.title.length > 60 ? '...' : '')
              }}
            </span>
            <svg class="w-5 h-5 ml-auto text-indigo-400 transform transition-transform duration-200"
              :class="{ 'rotate-180': openIndex === index }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <div v-if="openIndex === index" class="mt-6 space-y-4 pl-11 animate-fadeIn">
            <audio controls
              class="w-full rounded-lg shadow-inner bg-indigo-50 [&::-webkit-media-controls-panel]:bg-indigo-50">
              <source :src="reflection.audio" type="audio/mp3" />
              Tu navegador no soporta la etiqueta de audio.
            </audio>

            <div class="text-sm text-gray-500 italic pt-2">
              Haz clic en el reproductor para escuchar la reflexión
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const reflections = [
  { title: 'día: el trabajo que estoy pidiendo me debe acercar a Dios', audio: '/support/audioWork/1.mp3' },
  { title: 'día: la cruz de nuestro trabajo nos llevará al cielo (el trabajo bien hecho me santifica)', audio: '/support/audioWork/2.mp3' },
  { title: 'día: ¿Cómo trabajar según San Pedro? Rta/ 1. Tomar la iniciativa 2. Revestirnos del Espíritu Santo 3. ⁠Obedecer a Dios antes que a los hombres 4. ⁠Apacentar las ovejas cercanas', audio: '/support/audioWork/3.mp3' },
  { title: 'día: Todo lo que hagan, háganlo con el alma, como para el Señor y no para los hombres, sabiendo que recibirán del Señor la herencia como recompensa. Es a Cristo el Señor a quien sirven.', audio: '/support/audioWork/4.mp3' },
  { title: 'día: A. Dios es el que nos da el trabajo, el sustento, el dinero. B. San Esteban me enseña que entre más antiguos, más experiencia, más humildad debo tener. C. Aprender a perdonar, no te desgastes', audio: '/support/audioWork/5.mp3' },
  { title: 'día: Tendremos gente en contra en nuestros trabajos, pero solo la Palabra y la Eucaristía nos mantendrán firmes y fuertes. (Poner un poco de paz y alegría en mi entorno con ayuda de Dios)', audio: '/support/audioWork/6.mp3' },
  { title: 'día: Para hacer que mis compañeros de trabajo crean más en Dios 1. Dejarme mover por el Espíritu Santo 2. ⁠Mirar y oír con ojos del Espíritu 3. ⁠Acercarme y explicar la fe 4. ⁠Celebrar los sacramentos 5. ⁠Hacer misioneros', audio: '/support/audioWork/7.mp3' },
  { title: 'día: ¿Qué hacer con los enemigos? ¿Con los que me atacan?', audio: '/support/audioWork/8.mp3' },
  { title: 'día: Para que mi trabajo progrese, crezca y se viva en paz, debemos creerle al Señor y ser fiel a Él', audio: '/support/audioWork/9.mp3' }
]

const openIndex = ref(null)

function toggleOpen(index) {
  openIndex.value = openIndex.value === index ? null : index
}

function truncate(text, maxLength) {
  return text.length > maxLength ? text.slice(0, maxLength) : text
}
</script>

<style>
.animate-fadeIn {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>