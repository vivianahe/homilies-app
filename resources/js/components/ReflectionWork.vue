<template>
  <section class="reflection-section">

    <div class="reflection-container">

      <!-- =========================
           ENCABEZADO
      ========================== -->
      <div class="reflection-header">
        <span class="reflection-eyebrow"><i class="fa-solid fa-seedling" aria-hidden="true"></i> FE, ESPERANZA Y PROPÓSITO</span>

        <h2 class="reflection-main-title">
          <span>9 días de oración y reflexión</span> para conseguir trabajo
        </h2>

        <p class="reflection-subtitle">
          Un recorrido de 9 días con reflexiones y oraciones para fortalecerte:
          tu fe, confiar en Dios y poner tu trabajo en Sus manos.
        </p>

      </div>


      <!-- =========================
           DÍAS
      ========================== -->
      <div class="reflection-grid">

        <div
          v-for="(reflection, index) in formattedReflections"
          :key="index"
          class="reflection-card"
          :class="{ 'reflection-card-open': openIndex === index }"
        >

          <!-- BOTÓN -->
          <button
            type="button"
            class="reflection-button"
            @click="toggleOpen(index)"
            :aria-expanded="openIndex === index"
            :aria-controls="`work-reflection-${index + 1}`"
          >

            <!-- NÚMERO -->
            <span class="reflection-number">
              {{ String(index + 1).padStart(2, '0') }}
            </span>


            <!-- INFORMACIÓN -->
            <span class="reflection-info">

              <span class="reflection-day">
                Día {{ index + 1 }}
              </span>

              <span class="reflection-title">
                {{ reflection.shortTitle }}
              </span>


            </span>


            <!-- FLECHA -->
            <svg
              aria-hidden="true"
              class="reflection-arrow"
              :class="{ 'reflection-arrow-open': openIndex === index }"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>

          </button>


          <!-- =========================
               CONTENIDO DESPLEGABLE
          ========================== -->
          <div
            v-if="openIndex === index"
            class="reflection-expanded"
            :id="`work-reflection-${index + 1}`"
            role="region" :aria-label="`Reflexión del día ${index + 1}`"
          >

            <!-- TÍTULO COMPLETO -->
            <p class="reflection-full-title">
              {{ reflection.title }}
            </p>


            <!-- AUDIO -->
            <HomilyAudio :source="reflection.audio" :heading="`Oración del día ${index + 1}`" subtitle="" compact slim exclusive />


            <!-- CONTENIDO -->
            <div
              v-if="reflection.formattedContent"
              class="reflection-content"
            >

              <div
                v-for="(item, i) in reflection.formattedContent"
                :key="i"
                class="reflection-content-item"
              >

                <p
                  v-if="item.question"
                  class="reflection-question"
                >
                  {{ item.question }}
                </p>

                <p
                  v-if="item.answer"
                  class="reflection-answer"
                >
                  {{ item.answer }}
                </p>

                <p
                  v-if="item.text"
                  class="reflection-text"
                >
                  {{ item.text }}
                </p>

              </div>

            </div>

          </div>

        </div>

      </div>


      <!-- =========================
           FRASE FINAL
      ========================== -->
      <div class="reflection-quote">

        <span class="quote-line"></span>

        <div class="quote-content">

          <span class="quote-text">
            “Pon en manos del Señor todas tus obras, y tus planes se cumplirán.”
          </span>

          <span class="quote-reference">
            Proverbios 16, 3
          </span>

        </div>

        <span class="quote-line"></span>

      </div>

    </div>

  </section>
</template>


<script setup>

import { ref, computed } from 'vue'
import HomilyAudio from './detailHomilies/HomilyAudio.vue'


const reflections = [

  {
    title: 'Día: El trabajo que estoy pidiendo me debe acercar a Dios',
    shortTitle: 'Confiar en el plan de Dios',
    audio: '/support/audioWork/1.mp3'
  },

  {
    title: 'Día: La cruz de nuestro trabajo nos llevará al cielo (el trabajo bien hecho me santifica)',
    shortTitle: 'La dignidad del trabajo',
    audio: '/support/audioWork/2.mp3'
  },

  {
    title: 'Día: Cómo trabajar según San Pedro',
    shortTitle: 'Discernir con sabiduría',
    audio: '/support/audioWork/3.mp3',

    content:
      '¿Cómo trabajar según San Pedro?|1. Tomar la iniciativa|2. Revestirnos del Espíritu Santo|3. Obedecer a Dios antes que a los hombres|4. Apacentar las ovejas cercanas'
  },

  {
    title: 'Día: Trabajar para el Señor',
    shortTitle: 'Perseverar en la esperanza',
    audio: '/support/audioWork/4.mp3',

    content:
      'Todo lo que hagan, háganlo con el alma, como para el Señor y no para los hombres, sabiendo que recibirán del Señor la herencia como recompensa. Es a Cristo el Señor a quien sirven.'
  },

  {
    title: 'Día: Lecciones de San Esteban',
    shortTitle: 'El valor de mis talentos',
    audio: '/support/audioWork/5.mp3',

    content:
      'A. Dios es el que nos da el trabajo, el sustento, el dinero.|B. San Esteban me enseña que entre más antiguos, más experiencia, más humildad debo tener.|C. Aprender a perdonar, no te desgastes'
  },

  {
    title: 'Día: Mantenerse firme en el trabajo',
    shortTitle: 'Vencer el desánimo',
    audio: '/support/audioWork/6.mp3',

    content:
      'Tendremos gente en contra en nuestros trabajos, pero solo la Palabra y la Eucaristía nos mantendrán firmes y fuertes.|(Poner un poco de paz y alegría en mi entorno con ayuda de Dios)'
  },

  {
    title: 'Día: Hacer que mis compañeros crean más en Dios',
    shortTitle: 'Trabajo con propósito',
    audio: '/support/audioWork/7.mp3',

    content:
      'Para hacer que mis compañeros de trabajo crean más en Dios|1. Dejarme mover por el Espíritu Santo|2. Mirar y oír con ojos del Espíritu|3. Acercarme y explicar la fe|4. Celebrar los sacramentos|5. Hacer misioneros'
  },

  {
    title: 'Día: ¿Qué hacer con los enemigos?',
    shortTitle: 'Ser luz en mi entorno',
    audio: '/support/audioWork/8.mp3',

    content:
      '¿Qué hacer con los enemigos? ¿Con los que me atacan?'
  },

  {
    title: 'Día: Para que mi trabajo progrese',
    shortTitle: 'Oración final',
    audio: '/support/audioWork/9.mp3',

    content:
      'Para que mi trabajo progrese, crezca y se viva en paz, debemos creerle al Señor y ser fiel a Él'
  }

]


const openIndex = ref(null)


/* ==========================================================
   FORMATEAR CONTENIDO
========================================================== */

const formattedReflections = computed(() => {

  return reflections.map(reflection => {

    if (!reflection.content) {
      return reflection
    }


    const parts = reflection.content.split('|')

    const formattedContent = []


    if (parts[0].includes('?')) {

      formattedContent.push({
        question: parts[0]
      })


      parts.slice(1).forEach(part => {

        if (/^\d+\./.test(part.trim())) {

          formattedContent.push({
            answer: part
          })

        } else {

          formattedContent.push({
            text: part
          })

        }

      })

    } else {

      parts.forEach(part => {

        formattedContent.push({
          text: part
        })

      })

    }


    return {
      ...reflection,
      formattedContent
    }

  })

})


/* ==========================================================
   ABRIR / CERRAR
========================================================== */

function toggleOpen(index) {

  openIndex.value =
    openIndex.value === index
      ? null
      : index

}

</script>


<style scoped>
.reflection-section { padding: 48px 24px; background: white; }
.reflection-container { max-width: 1280px; margin: 0 auto; }
.reflection-header { max-width: 760px; margin: 0 0 32px; padding-left: 20px; border-left: 3px solid var(--public-primary); }
.reflection-eyebrow { display: inline-flex; align-items: center; gap: 8px; color: var(--public-primary); font-size: 10px; letter-spacing: .12em; font-weight: 700; }
.reflection-main-title { margin: 12px 0; color: var(--public-heading); font-size: clamp(25px, 3vw, 34px); line-height: 1.3; font-weight: 800; }
.reflection-subtitle { color: var(--public-text); font-size: 14px; line-height: 1.8; }
.reflection-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); column-gap: 28px; align-items: start; }
.reflection-card { min-width: 0; border-bottom: 1px solid #e2e8f0; background: white; }
.reflection-button { display: flex; align-items: center; gap: 14px; width: 100%; min-height: 104px; padding: 20px 12px; border: 0; border-radius: 12px; text-align: left; background: white; cursor: pointer; transition: background .2s; }
.reflection-button:hover, .reflection-card-open .reflection-button { background: var(--public-soft); }
.reflection-button:focus-visible { outline: 2px solid var(--public-primary); outline-offset: -2px; }
.reflection-number { flex-shrink: 0; width: 38px; color: var(--public-primary); font-size: 26px; font-weight: 800; letter-spacing: -.04em; font-variant-numeric: tabular-nums; }
.reflection-info { display: flex; flex-direction: column; gap: 5px; min-width: 0; flex: 1; }
.reflection-day { color: var(--public-muted); font-size: 11px; font-weight: 500; }
.reflection-title { color: var(--public-heading); font-size: 14px; line-height: 1.5; font-weight: 600; }
.reflection-arrow { width: 30px; height: 30px; padding: 7px; flex-shrink: 0; border-radius: 50%; background: #f8fafc; color: var(--public-muted); transition: transform .2s; }
.reflection-card-open .reflection-arrow { background: white; color: var(--public-primary); }
.reflection-arrow-open { transform: rotate(90deg); }
.reflection-expanded { padding: 18px 0 22px; }
.reflection-full-title { margin: 0 12px 16px; color: var(--public-heading); font-size: 14px; font-weight: 600; line-height: 1.7; }
.reflection-content { margin: 18px 12px 0; padding-top: 16px; border-top: 1px solid #e2e8f0; }
.reflection-content-item + .reflection-content-item { margin-top: 12px; }
.reflection-question { color: var(--public-heading); font-size: 14px; font-weight: 700; line-height: 1.7; }
.reflection-answer, .reflection-text { color: var(--public-text); font-size: 13px; line-height: 1.8; }
.reflection-quote { display: flex; align-items: center; gap: 20px; margin-top: 28px; }
.quote-line { height: 1px; background: #e2e8f0; flex: 1; }
.quote-content { max-width: 650px; text-align: center; }
.quote-text { color: var(--public-text); font-size: 12px; font-style: italic; line-height: 1.8; }
.quote-reference { display: inline-block; margin-left: 8px; color: var(--public-muted); font-size: 11px; }
@media (max-width: 1050px) {
  .reflection-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 24px; }
}
@media (max-width: 640px) {
  .reflection-section { padding: 32px 20px; }
  .reflection-header { margin-bottom: 20px; padding-left: 14px; }
  .reflection-subtitle { font-size: 13px; }
  .reflection-grid { grid-template-columns: minmax(0, 1fr); gap: 0; }
  .reflection-button { min-height: 90px; padding: 18px 8px; gap: 12px; }
  .reflection-number { width: 34px; font-size: 24px; }
  .reflection-expanded { padding: 14px 0 20px; }
  .quote-line { display: none; }
  .reflection-quote { margin-top: 24px; justify-content: center; }
}
@media (prefers-reduced-motion: reduce) {
  .reflection-button, .reflection-arrow { transition: none; }
}
</style>
