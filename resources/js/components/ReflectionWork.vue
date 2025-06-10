<template>
  <section class="py-8">
    <div
      class="w-full mx-auto max-w-screen-xl p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border border-indigo-100 rounded-xl shadow-lg">
      <h2 class="text-2xl font-bold mb-8 text-custom-text text-center">9 días de oración y reflexión para conseguir trabajo</h2>

      <div class="grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
        <div v-for="(reflection, index) in formattedReflections" :key="index"
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
            
            <!-- Contenido formateado con preguntas y respuestas -->
            <div class="text-gray-700 mt-4 space-y-3" v-if="reflection.formattedContent">
              <div v-for="(item, i) in reflection.formattedContent" :key="i" class="space-y-1">
                <p class="font-medium" v-if="item.question">{{ item.question }}</p>
                <p class="text-gray-600 pl-4" v-if="item.answer">{{ item.answer }}</p>
                <p v-if="item.text">{{ item.text }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const reflections = [
  { title: 'Día: El trabajo que estoy pidiendo me debe acercar a Dios', audio: '/support/audioWork/1.mp3' },
  { title: 'Día: La cruz de nuestro trabajo nos llevará al cielo (el trabajo bien hecho me santifica)', audio: '/support/audioWork/2.mp3' },
  { title: 'Día: Cómo trabajar según San Pedro', audio: '/support/audioWork/3.mp3', 
    content: '¿Cómo trabajar según San Pedro?|1. Tomar la iniciativa|2. Revestirnos del Espíritu Santo|3. Obedecer a Dios antes que a los hombres|4. Apacentar las ovejas cercanas' },
  { title: 'Día: Trabajar para el Señor', audio: '/support/audioWork/4.mp3', 
    content: 'Todo lo que hagan, háganlo con el alma, como para el Señor y no para los hombres, sabiendo que recibirán del Señor la herencia como recompensa. Es a Cristo el Señor a quien sirven.' },
  { title: 'Día: Lecciones de San Esteban', audio: '/support/audioWork/5.mp3', 
    content: 'A. Dios es el que nos da el trabajo, el sustento, el dinero.|B. San Esteban me enseña que entre más antiguos, más experiencia, más humildad debo tener.|C. Aprender a perdonar, no te desgastes' },
  { title: 'Día: Mantenerse firme en el trabajo', audio: '/support/audioWork/6.mp3', 
    content: 'Tendremos gente en contra en nuestros trabajos, pero solo la Palabra y la Eucaristía nos mantendrán firmes y fuertes.|(Poner un poco de paz y alegría en mi entorno con ayuda de Dios)' },
  { title: 'Día: Hacer que mis compañeros crean más en Dios', audio: '/support/audioWork/7.mp3', 
    content: 'Para hacer que mis compañeros de trabajo crean más en Dios|1. Dejarme mover por el Espíritu Santo|2. Mirar y oír con ojos del Espíritu|3. Acercarme y explicar la fe|4. Celebrar los sacramentos|5. Hacer misioneros' },
  { title: 'Día: ¿Qué hacer con los enemigos?', audio: '/support/audioWork/8.mp3', 
    content: '¿Qué hacer con los enemigos? ¿Con los que me atacan?' },
  { title: 'Día: Para que mi trabajo progrese', audio: '/support/audioWork/9.mp3', 
    content: 'Para que mi trabajo progrese, crezca y se viva en paz, debemos creerle al Señor y ser fiel a Él' }
]

const openIndex = ref(null)

// Formateamos las reflexiones para separar preguntas y respuestas
const formattedReflections = computed(() => {
  return reflections.map(reflection => {
    if (!reflection.content) return reflection
    
    const parts = reflection.content.split('|')
    const formattedContent = []
    
    // Si la primera parte tiene signo de interrogación, la tratamos como pregunta
    if (parts[0].includes('?')) {
      formattedContent.push({ question: parts[0] })
      parts.slice(1).forEach(part => {
        // Detectamos si es un punto numerado (1., 2., etc.)
        if (/^\d+\./.test(part.trim())) {
          formattedContent.push({ answer: part })
        } else {
          formattedContent.push({ text: part })
        }
      })
    } else {
      // Si no hay pregunta, mostramos todo como texto normal
      parts.forEach(part => {
        formattedContent.push({ text: part })
      })
    }
    
    return {
      ...reflection,
      formattedContent
    }
  })
})

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
