<template>
  <section class="reflections-section">
    <div class="reflections-container">

      <!-- ==========================================
           COLUMNA IZQUIERDA
      =========================================== -->
      <div class="reflections-intro">

        <div class="intro-content">

          <div class="section-label">
            <span>CHARLAS SOBRE FAMILIA</span>
            <div class="label-line"></div>
          </div>

          <h2 class="section-title">
            Reflexiones
          </h2>

          <p class="section-description">
            Charlas que inspiran, fortalecen
            a la familia y nos acercan a Dios
            en la vida diaria.
          </p>

        </div>

        <!-- DECORACIÓN -->
        <div class="family-decoration">

          <div class="family-circle">
            <i class="fas fa-users"></i>
          </div>

          <div class="leaf leaf-1"></div>
          <div class="leaf leaf-2"></div>
          <div class="leaf leaf-3"></div>

        </div>

      </div>


      <!-- ==========================================
           CONTENIDO
      =========================================== -->
      <div class="reflections-content">

        <!-- ==========================================
             WEB / TABLET
             SIEMPRE LAS 9 CHARLAS
        =========================================== -->
        <div class="reflections-grid desktop-grid">

          <!-- COLUMNA 1 -->
          <div class="reflection-column">

            <article
              v-for="reflection in reflections.slice(0, 3)"
              :key="reflection.id"
              class="reflection-card"
            >

              <img
                :src="reflection.image"
                :alt="reflection.title"
                class="reflection-image"
              />

              <div class="reflection-info">

                <p class="reflection-title">
                  {{ reflection.id }}. {{ reflection.title }}
                </p>

                <audio
                  controls
                  preload="metadata"
                  class="reflection-audio"
                >
                  <source
                    :src="reflection.audio"
                    :type="reflection.type"
                  />

                  Tu navegador no soporta la etiqueta de audio.
                </audio>

              </div>

            </article>

          </div>


          <!-- COLUMNA 2 -->
          <div class="reflection-column">

            <article
              v-for="reflection in reflections.slice(3, 6)"
              :key="reflection.id"
              class="reflection-card"
            >

              <img
                :src="reflection.image"
                :alt="reflection.title"
                class="reflection-image"
              />

              <div class="reflection-info">

                <p class="reflection-title">
                  {{ reflection.id }}. {{ reflection.title }}
                </p>

                <audio
                  controls
                  preload="metadata"
                  class="reflection-audio"
                >
                  <source
                    :src="reflection.audio"
                    :type="reflection.type"
                  />

                  Tu navegador no soporta la etiqueta de audio.
                </audio>

              </div>

            </article>

          </div>


          <!-- COLUMNA 3 -->
          <div class="reflection-column">

            <article
              v-for="reflection in reflections.slice(6, 9)"
              :key="reflection.id"
              class="reflection-card"
            >

              <img
                :src="reflection.image"
                :alt="reflection.title"
                class="reflection-image"
              />

              <div class="reflection-info">

                <p class="reflection-title">
                  {{ reflection.id }}. {{ reflection.title }}
                </p>

                <audio
                  controls
                  preload="metadata"
                  class="reflection-audio"
                >
                  <source
                    :src="reflection.audio"
                    :type="reflection.type"
                  />

                  Tu navegador no soporta la etiqueta de audio.
                </audio>

              </div>

            </article>

          </div>

        </div>


        <!-- ==========================================
             MÓVIL
             5 INICIALMENTE / 9 AL VER MÁS
        =========================================== -->
        <div class="mobile-list">

          <article
            v-for="reflection in mobileReflections"
            :key="reflection.id"
            class="reflection-card"
          >

            <img
              :src="reflection.image"
              :alt="reflection.title"
              class="reflection-image"
            />

            <div class="reflection-info">

              <p class="reflection-title">
                {{ reflection.id }}. {{ reflection.title }}
              </p>

              <audio
                controls
                preload="metadata"
                class="reflection-audio"
              >
                <source
                  :src="reflection.audio"
                  :type="reflection.type"
                />

                Tu navegador no soporta la etiqueta de audio.
              </audio>

            </div>

          </article>


          <!-- BOTÓN SOLO MÓVIL -->
          <button
            type="button"
            class="more-button"
            @click="toggleAll"
          >

            <i class="fas fa-headphones-alt"></i>

            <span>
              {{ showAll ? "Ver menos charlas" : "Ver más charlas" }}
            </span>

            <i
              class="fas"
              :class="showAll ? 'fa-arrow-up' : 'fa-arrow-right'"
            ></i>

          </button>

        </div>

      </div>

    </div>
  </section>
</template>


<script setup>

import { ref, computed } from "vue";


const showAll = ref(false);


const reflections = [

  {
    id: 1,
    title: "Purifica mi familia",
    image: "/img/reflection/1.jpg",
    audio: "/support/audioNinth/day1.mp3",
    type: "audio/mp3",
  },

  {
    id: 2,
    title: "Misericordia en mi familia",
    image: "/img/reflection/2.jpg",
    audio: "/support/audioNinth/day2.m4a",
    type: "audio/mp4",
  },

  {
    id: 3,
    title: "Pastorear mi familia",
    image: "/img/reflection/3.jpg",
    audio: "/support/audioNinth/day3.mp3",
    type: "audio/mp3",
  },

  {
    id: 4,
    title: "Fidelidad a Dios y a mi familia",
    image: "/img/reflection/4.jpg",
    audio: "/support/audioNinth/day4.mp3",
    type: "audio/mp3",
  },

  {
    id: 5,
    title: "Romper las máscaras de mi familia",
    image: "/img/reflection/5.jpg",
    audio: "/support/audioNinth/day5.mp3",
    type: "audio/mp3",
  },

  {
    id: 6,
    title: "Formar la parresia en la familia",
    image: "/img/reflection/6.jpg",
    audio: "/support/audioNinth/day6.mp3",
    type: "audio/mp3",
  },

  {
    id: 7,
    title: "Amar la iglesia en familia",
    image: "/img/reflection/7.jpg",
    audio: "/support/audioNinth/day7.m4a",
    type: "audio/mp4",
  },

  {
    id: 8,
    title: "Formar en el poder en la familia",
    image: "/img/reflection/8.jpg",
    audio: "/support/audioNinth/day8.mp3",
    type: "audio/mp3",
  },

  {
    id: 9,
    title: "Estar vigilantes en la familia",
    image: "/img/reflection/9.jpg",
    audio: "/support/audioNinth/day9.m4a",
    type: "audio/mp4",
  },

];


const mobileReflections = computed(() => {

  return showAll.value
    ? reflections
    : reflections.slice(0, 5);

});


const toggleAll = () => {
  showAll.value = !showAll.value;
};

</script>


<style scoped>

/* =========================================================
   PALETA

   #071a58  Títulos
   #20355f  Texto
   #273df2  Azul principal
   #1646e8  Azul secundario
   #6636ff  Violeta
   #ffffff  Fondo
========================================================= */


/* =========================================================
   SECCIÓN GENERAL
========================================================= */

.reflections-section {
  width: 100%;

  padding: 0px 24px;

  background: #ffffff;
}


/* =========================================================
   CONTENEDOR PRINCIPAL
========================================================= */

.reflections-container {
  position: relative;

  width: 100%;
  max-width: 1500px;

  min-height: 390px;

  margin: 0 auto;

  display: grid;

  grid-template-columns:
    310px minmax(0, 1fr);

  align-items: center;

  gap: 38px;

  padding: 45px 35px;

  overflow: hidden;

  border-radius: 18px;

  /* FONDO BLANCO */
  background: #ffffff;

}


/* =========================================================
   INTRO IZQUIERDO
========================================================= */

.reflections-intro {
  position: relative;

  width: 100%;
  min-height: 300px;

  display: flex;
  align-items: flex-start;

  padding:
    12px
    0
    0
    15px;
}


/* =========================================================
   CONTENIDO INTRO
========================================================= */

.intro-content {
  position: relative;

  width: 100%;

  padding-left: 20px;

  border-left:
    2px solid
    #6636ff;

  z-index: 4;
}


/* =========================================================
   ETIQUETA
========================================================= */

.section-label {
  display: flex;
  align-items: center;

  gap: 14px;

  margin-bottom: 11px;
}


.section-label span {
  color: #273df2;

  font-size: 12px;
  font-weight: 800;

  line-height: 1;

  letter-spacing: 1.8px;

  white-space: nowrap;
}


.label-line {
  width: 48px;
  height: 2px;

  flex-shrink: 0;

  border-radius: 10px;

  background:
    linear-gradient(
      135deg,
      #273df2 0%,
      #6636ff 100%
    );
}


/* =========================================================
   TÍTULO
========================================================= */

.section-title {
  margin:
    0
    0
    12px;

  color: #071a58;

  font-size: 38px;
  font-weight: 800;

  line-height: 1.05;

  letter-spacing: -0.8px;
}


/* =========================================================
   DESCRIPCIÓN
========================================================= */

.section-description {
  max-width: 260px;

  margin: 0;

  color: #20355f;

  font-size: 16px;
  font-weight: 400;

  line-height: 1.5;
}


/* =========================================================
   DECORACIÓN
========================================================= */

.family-decoration {
  position: absolute;

  left: -25px;
  bottom: -35px;

  width: 290px;
  height: 200px;

  pointer-events: none;

  z-index: 1;
}


/* =========================================================
   CÍRCULO DECORATIVO
========================================================= */

.family-circle {
  position: absolute;

  width: 175px;
  height: 175px;

  right: 0;
  bottom: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 50%;

  background:
    rgba(39, 61, 242, 0.035);

  color: #273df2;

  font-size: 66px;

  opacity: 0.68;
}


/* =========================================================
   HOJAS DECORATIVAS
========================================================= */

.leaf {
  position: absolute;

  width: 55px;
  height: 125px;

  border-radius:
    100%
    0
    100%
    0;

  background:
    rgba(39, 61, 242, 0.055);

  transform-origin:
    bottom center;
}


.leaf-1 {
  left: 8px;
  bottom: -15px;

  transform:
    rotate(-35deg);
}


.leaf-2 {
  left: 52px;
  bottom: -12px;

  transform:
    rotate(-10deg);
}


.leaf-3 {
  left: 95px;
  bottom: -20px;

  transform:
    rotate(22deg);
}


/* =========================================================
   CONTENIDO DERECHO
========================================================= */

.reflections-content {
  position: relative;

  width: 100%;

  min-width: 0;
}


/* =========================================================
   GRID WEB
========================================================= */

.reflections-grid {
  width: 100%;

  display: grid;

  grid-template-columns:
    repeat(
      3,
      minmax(0, 1fr)
    );

  gap: 15px;
}


/* =========================================================
   COLUMNA
========================================================= */

.reflection-column {
  min-width: 0;

  display: flex;
  flex-direction: column;

  gap: 15px;
}


/* =========================================================
   TARJETAS
========================================================= */

.reflection-card {
  width: 100%;

  min-width: 0;
  min-height: 82px;

  display: flex;
  align-items: center;

  gap: 12px;

  padding: 10px 12px;

  overflow: hidden;

  border:
    1px solid
    rgba(39, 61, 242, 0.07);

  border-radius: 12px;

  background: #ffffff;

  box-shadow:
    0 5px 18px
    rgba(7, 26, 88, 0.065);

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease,
    border-color 0.2s ease;
}


.reflection-card:hover {
  transform:
    translateY(-2px);

  border-color:
    rgba(39, 61, 242, 0.16);

  box-shadow:
    0 9px 24px
    rgba(7, 26, 88, 0.10);
}


/* =========================================================
   IMAGEN
========================================================= */

.reflection-image {
  width: 60px;
  height: 60px;

  flex:
    0
    0
    60px;

  display: block;

  border-radius: 50%;

  object-fit: cover;
}


/* =========================================================
   INFORMACIÓN
========================================================= */

.reflection-info {
  min-width: 0;

  flex: 1;
}


/* =========================================================
   TÍTULO CHARLA
========================================================= */

.reflection-title {
  width: 100%;

  margin:
    0
    0
    4px;

  overflow: hidden;

  color: #20355f;

  font-size: 13px;
  font-weight: 500;

  line-height: 1.3;

  white-space: nowrap;

  text-overflow: ellipsis;
}


/* =========================================================
   AUDIO
========================================================= */

.reflection-audio {
  display: block;

  width: 100%;
  max-width: 100%;

  height: 32px;

  margin: 0;

  accent-color: #273df2;
}


/* =========================================================
   AUDIO CHROME / EDGE
========================================================= */

.reflection-audio::-webkit-media-controls-panel {
  background: #ffffff;
}


.reflection-audio::-webkit-media-controls-play-button {
  filter:
    sepia(100%)
    saturate(7000%)
    hue-rotate(230deg)
    brightness(85%);
}


/* =========================================================
   MÓVIL OCULTO EN WEB
========================================================= */

.mobile-list {
  display: none;
}


/* =========================================================
   BOTÓN MÓVIL
========================================================= */

.more-button {
  min-height: 48px;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  gap: 12px;

  padding:
    0
    20px;

  border: 0;

  border-radius: 10px;

  background:
    linear-gradient(
      135deg,
      #273df2 0%,
      #6636ff 100%
    );

  color: #ffffff;

  font-family: inherit;

  font-size: 13px;
  font-weight: 700;

  cursor: pointer;

  box-shadow:
    0 9px 22px
    rgba(39, 61, 242, 0.20);

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}


.more-button:hover {
  transform:
    translateY(-2px);

  box-shadow:
    0 12px 28px
    rgba(39, 61, 242, 0.28);
}


/* =========================================================
   DESKTOP MEDIANO
========================================================= */

@media (max-width: 1250px) {

  .reflections-container {
    grid-template-columns:
      270px minmax(0, 1fr);

    gap: 25px;

    padding-left: 25px;
    padding-right: 25px;
  }


  .section-title {
    font-size: 35px;
  }


  .section-description {
    font-size: 14px;
  }


  .reflection-card {
    gap: 9px;

    padding-left: 9px;
    padding-right: 9px;
  }


  .reflection-image {
    width: 52px;
    height: 52px;

    flex-basis: 52px;
  }


  .reflection-title {
    font-size: 12px;
  }

}


/* =========================================================
   TABLET
========================================================= */

@media
(max-width: 1000px)
and
(min-width: 768px) {

  .reflections-container {
    grid-template-columns:
      230px minmax(0, 1fr);

    gap: 20px;

    padding:
      35px
      20px;
  }


  .section-label {
    gap: 8px;
  }


  .section-label span {
    font-size: 10px;

    letter-spacing: 1.3px;
  }


  .label-line {
    width: 30px;
  }


  .section-title {
    font-size: 31px;
  }


  .section-description {
    max-width: 210px;

    font-size: 13px;
  }


  .reflection-image {
    width: 45px;
    height: 45px;

    flex-basis: 45px;
  }


  .reflection-card {
    min-height: 72px;

    padding: 8px;
  }


  .reflection-title {
    font-size: 11px;
  }


  .reflection-audio {
    height: 29px;
  }

}


/* =========================================================
   MÓVIL
========================================================= */

@media (max-width: 767px) {

  /* SECCIÓN */

  .reflections-section {
    padding:
      42px
      16px;

    background: #ffffff;
  }


  /* CONTENEDOR */

  .reflections-container {
    display: block;

    width: 100%;
    max-width: 430px;

    min-height: auto;

    margin: 0 auto;

    padding:
      28px
      16px
      0px;

    border-radius: 17px;

    /* FONDO BLANCO */
    background: #ffffff;
  }


  /* =======================================================
     CABECERA
  ======================================================== */

  .reflections-intro {
    position: relative;

    width: 100%;
    min-height: 125px;

    display: block;

    padding:
      0
      90px
      0
      0;

    margin-bottom: 20px;
  }


  .intro-content {
    width: 100%;

    padding-left: 16px;
  }


  /* LABEL */

  .section-label {
    gap: 9px;

    margin-bottom: 8px;
  }


  .section-label span {
    font-size: 9px;

    letter-spacing: 1.2px;
  }


  .label-line {
    width: 35px;
  }


  /* TÍTULO */

  .section-title {
    margin-bottom: 7px;

    font-size: 29px;

    line-height: 1.05;

    letter-spacing: -0.5px;
  }


  /* DESCRIPCIÓN */

  .section-description {
    width: 100%;
    max-width: 255px;

    font-size: 12px;

    line-height: 1.4;
  }


  /* =======================================================
     DECORACIÓN MÓVIL
  ======================================================== */

  .family-decoration {
    left: auto;
    right: -15px;

    top: -15px;
    bottom: auto;

    width: 125px;
    height: 120px;
  }


  .family-circle {
    width: 88px;
    height: 88px;

    right: 12px;
    bottom: 15px;

    font-size: 37px;

    background:
      rgba(39, 61, 242, 0.035);

    color: #273df2;

    opacity: 0.68;
  }


  /* HOJAS */

  .leaf {
    width: 25px;
    height: 65px;

    background:
      rgba(39, 61, 242, 0.055);
  }


  .leaf-1 {
    left: 76px;
    bottom: -14px;
  }


  .leaf-2 {
    left: 96px;
    bottom: -15px;
  }


  .leaf-3 {
    left: 112px;
    bottom: -18px;
  }


  /* =======================================================
     OCULTAR WEB
  ======================================================== */

  .desktop-grid {
    display: none;
  }


  /* =======================================================
     MOSTRAR MÓVIL
  ======================================================== */

  .mobile-list {
    display: flex;
    flex-direction: column;

    gap: 10px;
  }


  /* TARJETA */

  .reflection-card {
    width: 100%;

    min-height: 68px;

    gap: 10px;

    padding:
      8px
      10px;

    border-radius: 11px;

    background: #ffffff;

    border:
      1px solid
      rgba(39, 61, 242, 0.07);

    box-shadow:
      0 4px 14px
      rgba(7, 26, 88, 0.065);
  }


  .reflection-card:hover {
    transform: none;
  }


  /* IMAGEN */

  .reflection-image {
    width: 50px;
    height: 50px;

    flex:
      0
      0
      50px;
  }


  /* INFORMACIÓN */

  .reflection-info {
    min-width: 0;

    flex: 1;
  }


  /* TÍTULO */

  .reflection-title {
    margin-bottom: 2px;

    font-size: 11px;

    line-height: 1.25;
  }


  /* AUDIO */

  .reflection-audio {
    width: 100%;

    height: 29px;
  }


  /* BOTÓN */

  .more-button {
    width: 100%;
    height: 48px;

    margin-top: 5px;

    border-radius: 10px;

    font-size: 13px;
  }

}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 390px) {

  .reflections-section {
    padding-left: 12px;
    padding-right: 12px;
  }


  .reflections-container {
    padding-left: 12px;
    padding-right: 12px;
  }


  /* CABECERA */

  .reflections-intro {
    padding-right: 70px;
  }


  .intro-content {
    padding-left: 13px;
  }


  .section-label {
    gap: 7px;
  }


  .section-label span {
    font-size: 8px;

    letter-spacing: 1px;
  }


  .label-line {
    width: 25px;
  }


  .section-title {
    font-size: 27px;
  }


  .section-description {
    font-size: 11px;
  }


  /* DECORACIÓN */

  .family-circle {
    width: 76px;
    height: 76px;

    right: 8px;

    font-size: 31px;
  }


  /* TARJETAS */

  .reflection-card {
    gap: 8px;

    padding:
      7px
      8px;
  }


  .reflection-image {
    width: 46px;
    height: 46px;

    flex-basis: 46px;
  }


  .reflection-title {
    font-size: 10.5px;
  }


  .reflection-audio {
    height: 28px;
  }


  /* BOTÓN */

  .more-button {
    height: 46px;

    font-size: 12px;
  }

}

</style>