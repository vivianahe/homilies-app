<template>
  <section class="reflection-section">

    <div class="reflection-container">

      <!-- =========================
           ENCABEZADO
      ========================== -->
      <div class="reflection-header">

        <h2 class="reflection-main-title">
          9 días de oración y reflexión para conseguir trabajo
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
          >

            <!-- NÚMERO -->
            <span class="reflection-number">
              {{ index + 1 }}
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
            class="reflection-expanded animate-fadeIn"
          >

            <!-- TÍTULO COMPLETO -->
            <p class="reflection-full-title">
              {{ reflection.title }}
            </p>


            <!-- AUDIO -->
            <audio
              controls
              class="reflection-audio"
            >
              <source
                :src="reflection.audio"
                type="audio/mp3"
              />

              Tu navegador no soporta la etiqueta de audio.
            </audio>


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

/* ==========================================================
   RESET LOCAL
========================================================== */

*,
*::before,
*::after {
  box-sizing: border-box;
}


/* ==========================================================
   SECCIÓN GENERAL

   El bloque de los 9 días debe verse más contenido que
   "Mensaje del día", como en el diseño de referencia.
========================================================== */

.reflection-section {
  width: 100%;

  padding: 32px 20px;

  box-sizing: border-box;
}


/* ==========================================================
   CONTENEDOR PRINCIPAL - WEB

   Mensaje del día: 1380px
   9 días:          1320px

   Así el bloque queda ligeramente más angosto.
========================================================== */

.reflection-container {
  width: 100%;

  max-width: 1320px;

  margin: 0 auto;

  padding: 28px 28px 20px;

  background:
    linear-gradient(
      135deg,
      #f7fbff 0%,
      #eef6ff 50%,
      #edf4ff 100%
    );

  border-radius: 20px;

  box-shadow:
    0 10px 35px rgba(36, 78, 140, 0.08);

  box-sizing: border-box;
}


/* ==========================================================
   ENCABEZADO
========================================================== */

.reflection-header {
  text-align: center;

  margin-bottom: 22px;
}


.reflection-main-title {
  margin: 0;

  color: #15157a;

  font-size: 25px;
  font-weight: 800;

  line-height: 1.2;

  letter-spacing: -0.4px;
}


.reflection-subtitle {
  max-width: 750px;

  margin: 8px auto 0;

  color: #45456f;

  font-size: 13px;
  font-weight: 400;

  line-height: 1.5;
}


/* ==========================================================
   GRID WEB
========================================================== */

.reflection-grid {
  display: grid;

  grid-template-columns:
    repeat(3, minmax(0, 1fr));

  gap: 14px;
}


/* ==========================================================
   TARJETAS
========================================================== */

.reflection-card {
  min-width: 0;

  background:
    rgba(255, 255, 255, 0.96);

  border: 1px solid #edf1ff;

  border-radius: 12px;

  overflow: hidden;

  box-shadow:
    0 3px 10px rgba(35, 55, 110, 0.08);

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease,
    border-color 0.2s ease;
}


.reflection-card:hover {
  transform: translateY(-2px);

  border-color: #dfe7ff;

  box-shadow:
    0 7px 18px rgba(35, 55, 110, 0.12);
}


.reflection-card-open {
  grid-row: span 2;

  border-color: #dce5ff;

  box-shadow:
    0 8px 22px rgba(35, 55, 110, 0.12);
}


/* ==========================================================
   BOTÓN DE CADA DÍA
========================================================== */

.reflection-button {
  width: 100%;

  min-height: 80px;

  padding: 14px 16px;

  display: flex;

  align-items: center;

  border: 0;

  outline: none;

  background: transparent;

  cursor: pointer;

  text-align: left;

  font-family: inherit;

  box-sizing: border-box;
}


/* ==========================================================
   NÚMERO
========================================================== */

.reflection-number {
  width: 38px;
  height: 38px;

  min-width: 38px;

  display: flex;

  align-items: center;
  justify-content: center;

  margin-right: 14px;

  border-radius: 50%;

  background:
    linear-gradient(
      135deg,
      #e6edff,
      #dce6ff
    );

  color: #3232ff;

  font-size: 16px;
  font-weight: 800;

  box-shadow:
    inset 0 0 0 1px rgba(90, 110, 255, 0.04);
}


/* ==========================================================
   INFORMACIÓN
========================================================== */

.reflection-info {
  flex: 1;

  min-width: 0;

  display: flex;

  flex-direction: column;

  gap: 4px;
}


.reflection-day {
  color: #18184d;

  font-size: 14px;
  font-weight: 800;

  line-height: 1.15;
}


.reflection-title {
  color: #37375f;

  font-size: 13px;
  font-weight: 400;

  line-height: 1.3;

  overflow-wrap: anywhere;
}


/* ==========================================================
   FLECHA
========================================================== */

.reflection-arrow {
  width: 16px;
  height: 16px;

  min-width: 16px;

  margin-left: 10px;

  color: #626cff;

  transition:
    transform 0.25s ease;
}


.reflection-arrow-open {
  transform: rotate(90deg);
}


/* ==========================================================
   CONTENIDO ABIERTO
========================================================== */

.reflection-expanded {
  padding:
    0 18px 20px 68px;
}


.reflection-full-title {
  margin: 0 0 12px;

  color: #292956;

  font-size: 13px;
  font-weight: 600;

  line-height: 1.5;
}


/* ==========================================================
   AUDIO
========================================================== */

.reflection-audio {
  display: block;

  width: 100%;
  height: 38px;

  margin-bottom: 14px;

  border-radius: 20px;
}


/* ==========================================================
   CONTENIDO
========================================================== */

.reflection-content {
  color: #51516e;

  font-size: 13px;

  line-height: 1.55;
}


.reflection-content-item {
  margin-bottom: 7px;
}


.reflection-question {
  margin: 0;

  color: #252550;

  font-weight: 700;
}


.reflection-answer {
  margin: 0;

  padding-left: 10px;

  color: #555572;
}


.reflection-text {
  margin: 0;

  color: #555572;
}


/* ==========================================================
   FRASE FINAL
========================================================== */

.reflection-quote {
  width: 100%;

  display: flex;

  align-items: center;
  justify-content: center;

  gap: 12px;

  margin-top: 20px;

  padding: 0;

  text-align: center;
}


/* ==========================================================
   LÍNEAS LATERALES
========================================================== */

.quote-line {
  flex: 1 1 auto;

  height: 1px;

  min-width: 30px;

  background: #d8e3f5;
}


/* ==========================================================
   CONTENEDOR FRASE + REFERENCIA
========================================================== */

.quote-content {
  flex: 0 1 auto;

  display: flex;

  align-items: center;
  justify-content: center;

  gap: 12px;

  min-width: 0;
}


/* ==========================================================
   FRASE
========================================================== */

.quote-text {
  color: #373782;

  font-size: 13px;
  font-style: italic;
  font-weight: 400;

  line-height: 1.4;

  white-space: nowrap;
}


/* ==========================================================
   REFERENCIA
========================================================== */

.quote-reference {
  color: #62627e;

  font-size: 11px;
  font-weight: 500;

  white-space: nowrap;
}


/* ==========================================================
   ANIMACIÓN
========================================================== */

.animate-fadeIn {
  animation:
    fadeIn 0.25s ease-in-out;
}


@keyframes fadeIn {

  from {
    opacity: 0;

    transform:
      translateY(-5px);
  }

  to {
    opacity: 1;

    transform:
      translateY(0);
  }

}


/* ==========================================================
   PANTALLAS GRANDES

   Conservamos la proporción del boceto aunque el monitor
   sea muy ancho.
========================================================== */

@media (min-width: 1400px) {

  .reflection-section {
    padding-left: 30px;
    padding-right: 30px;
  }


  .reflection-container {
    max-width: 1320px;
  }

}


/* ==========================================================
   TABLET
========================================================== */

@media (max-width: 900px) {

  .reflection-section {
    padding:
      25px 16px;
  }


  .reflection-container {
    max-width: 100%;

    padding:
      25px 20px 18px;
  }


  .reflection-grid {
    grid-template-columns:
      repeat(2, minmax(0, 1fr));

    gap: 12px;
  }


  .reflection-main-title {
    font-size: 22px;
  }


  .quote-content {
    gap: 8px;
  }


  .quote-text {
    white-space: normal;

    max-width: 430px;
  }

}


/* ==========================================================
   MÓVIL
========================================================== */

@media (max-width: 640px) {


  /* ========================================================
     SECCIÓN

     En móvil reducimos el espacio externo para aprovechar
     mejor el ancho de la pantalla.
  ======================================================== */

  .reflection-section {
    width: 100%;

    padding:
      16px 8px;
  }


  /* ========================================================
     CONTENEDOR
  ======================================================== */

  .reflection-container {
    width: 100%;

    max-width: none;

    margin: 0 auto;

    padding:
      20px 12px 16px;

    border-radius: 16px;
  }


  /* ========================================================
     CABECERA
  ======================================================== */

  .reflection-header {
    margin-bottom: 14px;
  }


  .reflection-main-title {
    max-width: 280px;

    margin:
      0 auto;

    font-size: 17px;

    line-height: 1.15;

    letter-spacing:
      -0.25px;
  }


  .reflection-subtitle {
    display: none;
  }


  /* ========================================================
     LISTA
  ======================================================== */

  .reflection-grid {
    display: flex;

    flex-direction: column;

    gap: 7px;
  }


  /* ========================================================
     TARJETA
  ======================================================== */

  .reflection-card {
    width: 100%;

    border-radius: 9px;

    box-shadow:
      0 2px 6px rgba(35, 55, 110, 0.08);
  }


  .reflection-card:hover {
    transform: none;
  }


  /* ========================================================
     BOTÓN
  ======================================================== */

  .reflection-button {
    width: 100%;

    min-height: 52px;

    padding:
      7px 10px;
  }


  /* ========================================================
     NÚMERO
  ======================================================== */

  .reflection-number {
    width: 28px;
    height: 28px;

    min-width: 28px;

    margin-right: 10px;

    font-size: 12px;
  }


  /* ========================================================
     TEXTO
  ======================================================== */

  .reflection-info {
    gap: 2px;
  }


  .reflection-day {
    font-size: 11px;

    line-height: 1.1;
  }


  .reflection-title {
    font-size: 10.5px;

    line-height: 1.2;
  }


  /* ========================================================
     FLECHA
  ======================================================== */

  .reflection-arrow {
    width: 13px;
    height: 13px;

    min-width: 13px;

    margin-left: 7px;
  }


  /* ========================================================
     CONTENIDO ABIERTO
  ======================================================== */

  .reflection-expanded {
    padding:
      2px 12px 14px 48px;
  }


  .reflection-full-title {
    margin-bottom: 10px;

    font-size: 11px;

    line-height: 1.4;
  }


  .reflection-content {
    font-size: 11px;

    line-height: 1.5;
  }


  .reflection-audio {
    width: 100%;

    height: 34px;

    margin-bottom: 10px;
  }


  /* ========================================================
     FRASE FINAL MÓVIL
  ======================================================== */

  .reflection-quote {
    width: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    margin-top: 16px;

    padding: 0;
  }


  /* LÍNEAS */

  .quote-line {
    flex: 1 1 0;

    min-width: 10px;

    height: 1px;

    background: #d8e3f5;
  }


  /* BLOQUE CENTRAL */

  .quote-content {
    flex: 0 1 auto;

    min-width: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 6px;
  }


  /* FRASE */

  .quote-text {
    flex: 0 1 auto;

    max-width: 225px;

    color: #373782;

    font-size: 9px;

    font-style: italic;
    font-weight: 400;

    line-height: 1.25;

    white-space: normal;

    text-align: center;
  }


  /* REFERENCIA */

  .quote-reference {
    flex: 0 0 auto;

    color: #62627e;

    font-size: 8px;
    font-weight: 500;

    line-height: 1.2;

    white-space: nowrap;
  }

}


/* ==========================================================
   MÓVILES PEQUEÑOS
========================================================== */

@media (max-width: 380px) {

  .reflection-section {
    padding:
      12px 6px;
  }


  .reflection-container {
    padding:
      18px 9px 14px;
  }


  .reflection-main-title {
    max-width: 250px;

    font-size: 16px;
  }


  .reflection-button {
    min-height: 49px;

    padding:
      6px 8px;
  }


  .reflection-number {
    width: 26px;
    height: 26px;

    min-width: 26px;

    margin-right: 8px;

    font-size: 11px;
  }


  .reflection-day {
    font-size: 10.5px;
  }


  .reflection-title {
    font-size: 10px;
  }


  .reflection-expanded {
    padding:
      2px 10px 12px 42px;
  }


  /* ========================================================
     FRASE
  ======================================================== */

  .reflection-quote {
    gap: 4px;

    margin-top: 14px;
  }


  .quote-line {
    min-width: 6px;
  }


  .quote-content {
    gap: 4px;
  }


  .quote-text {
    max-width: 180px;

    font-size: 8.5px;

    line-height: 1.25;
  }


  .quote-reference {
    font-size: 7.5px;
  }

}

</style>