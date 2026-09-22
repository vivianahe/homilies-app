<template>
  <section class="prayer-priest-section">

    <!-- =====================================================
         1. ORACIÓN DEL DÍA
    ====================================================== -->
    <div class="content-card prayer-card">

      <!-- ETIQUETA MÓVIL -->
      <div class="mobile-label">
        ORACIÓN DEL DÍA
      </div>

      <!-- TEXTO -->
      <div class="prayer-info">

        <div class="section-label desktop-label">
          ORACIÓN DEL DÍA
        </div>

        <h2 class="prayer-title">
          Danos tu guía en<br class="desktop-break" />
          el trabajo
        </h2>

        <p class="prayer-description">
          Señor, te pedimos que bendigas nuestro trabajo,
          que nos des sabiduría en cada decisión, que pongas
          en nuestras manos las oportunidades correctas y
          que todo lo que hagamos sea para tu gloria. Amén.
        </p>

        <button
          type="button"
          class="primary-button prayer-button"
          @click="openPrayer"
        >
          <span class="play-button-icon">
            <i class="fas fa-play"></i>
          </span>

          <span>Ver oración</span>
        </button>

      </div>

      <!-- VIDEO -->
      <div class="prayer-video">
        <div class="video-wrapper">
          <iframe
            v-if="dataPrayerDesc && dataPrayerDesc.link"
            :src="youtubeEmbedUrl"
            title="Oración del día"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
          ></iframe>
        </div>
      </div>

    </div>


    <!-- =====================================================
         2. NUESTRO SACERDOTE
    ====================================================== -->
    <div class="content-card priest-card">

      <!-- INFORMACIÓN -->
      <div class="priest-info">

        <div class="section-label">
          NUESTRO SACERDOTE
        </div>

        <h2 class="priest-title">
          Padre Uriel Franco
        </h2>

        <p class="priest-description">
          {{ showFullText ? fullText : priestShortText }}
        </p>

        <button
          type="button"
          class="primary-button priest-button"
          @click="toggleText"
        >
          <span>
            {{ showFullText ? "Ver menos" : "Conocer más" }}
          </span>

          <i
            class="fas"
            :class="showFullText ? 'fa-arrow-left' : 'fa-arrow-right'"
          ></i>
        </button>

      </div>


      <!-- FOTO -->
      <div class="priest-photo-area">

        <div class="priest-decoration decoration-top"></div>
        <div class="priest-decoration decoration-bottom"></div>

        <div class="priest-photo">
          <img
            src="/img/padre1.jpeg"
            alt="Padre Uriel Franco"
          />
        </div>

      </div>


      <!-- FRASE -->
      <div class="priest-quote">

        <div class="quote-symbol">
          “
        </div>

        <p>
          “Llevar a Dios<br class="desktop-break" />
          a la vida real<br class="desktop-break" />
          de cada persona.”
        </p>

      </div>

    </div>

  </section>
</template>


<script setup>
import { computed, onMounted, ref } from "vue";
import axios from "axios";


/* =========================================================
   TEXTO DEL SACERDOTE
========================================================= */

const fullText = ref(
  "Presbítero y Magíster, sacerdote de la Diócesis de Neiva, Colombia. Su vocación sacerdotal ha estado acompañada por una amplia formación académica, pastoral y musical, orientada especialmente al servicio de la familia y la comunidad. Es Normalista de la Escuela Normal Superior de Neiva y Licenciado en Matemáticas. También es Licenciado en Filosofía y Educación Religiosa y Teólogo de la Universidad Católica de Oriente, en Rionegro, Antioquia. Realizó su formación eclesiástica en el Seminario Cristo Sacerdote de La Ceja, Antioquia, como miembro de la Asociación Siervos del Espíritu Santo. Es Magíster en Asesoría Familiar y Gestión de Programas para la Familia de la Universidad de La Sabana, en Bogotá, y cuenta además con formación musical en el Conservatorio Departamental del Huila. Actualmente es Delegado Diocesano de Pastoral Familiar, misión desde la cual acompaña y orienta a las familias, integrando su experiencia sacerdotal, académica y pastoral. " );

const priestShortText =
  "Sacerdote, evangelizador y acompañante en el camino de la fe. A través de sus homilías, busca llevar el mensaje de Dios a cada persona, fortaleciendo la esperanza y la vida cristiana en el día a día.";

const showFullText = ref(false);


/* =========================================================
   ORACIÓN
========================================================= */

const dataPrayerDesc = ref({});


const getPrayerDesc = async () => {
  try {

    const { data } = await axios.get("/prayers");

    if (data && data.length > 0) {
      dataPrayerDesc.value = data[0];
    }

  } catch (error) {

    console.error(
      "Error cargando la oración del día:",
      error
    );

  }
};


/* =========================================================
   URL YOUTUBE
========================================================= */

const youtubeEmbedUrl = computed(() => {

  if (!dataPrayerDesc.value?.link) {
    return "";
  }

  return `https://www.youtube.com/embed/${dataPrayerDesc.value.link}`;
});


const youtubeWatchUrl = computed(() => {

  if (!dataPrayerDesc.value?.link) {
    return "#";
  }

  return `https://www.youtube.com/watch?v=${dataPrayerDesc.value.link}`;
});


/* =========================================================
   ACCIONES
========================================================= */

const openPrayer = () => {

  if (!dataPrayerDesc.value?.link) {
    return;
  }

  window.open(
    youtubeWatchUrl.value,
    "_blank",
    "noopener,noreferrer"
  );

};


const toggleText = () => {
  showFullText.value = !showFullText.value;
};


onMounted(() => {
  getPrayerDesc();
});
</script>


<style scoped>

/* =========================================================
   CONTENEDOR GENERAL
========================================================= */

.prayer-priest-section {
  width: 100%;
  max-width: 1280px;

  margin: 0 auto;

  padding: 50px 24px 70px;

  font-family:
    "Poppins",
    sans-serif;
}


/* =========================================================
   TARJETAS
========================================================= */

.content-card {
  width: 100%;

  background: #ffffff;

  border-radius: 18px;

  box-shadow:
    0 8px 30px
    rgba(34, 122, 190, 0.08);
}


/* =========================================================
   ETIQUETAS
========================================================= */

.section-label,
.mobile-label {

  display: inline-flex;

  align-items: center;

  justify-content: center;

  width: fit-content;

  padding: 7px 17px;

  border-radius: 30px;

  background:
    linear-gradient(
      90deg,
      #edf7ff 0%,
      #dceeff 100%
    );

  color: #0866f5;

  font-size: 14px;

  font-weight: 700;

  line-height: 1;

  text-transform: uppercase;
}


.mobile-label {
  display: none;
}


/* =========================================================
   ORACIÓN DEL DÍA
========================================================= */

.prayer-card {

  display: grid;

  grid-template-columns:
    minmax(320px, 0.9fr)
    minmax(500px, 1.5fr);

  align-items: center;

  gap: 55px;

  padding: 30px 28px 30px 38px;

  margin-bottom: 36px;
}


.prayer-info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}


.prayer-title {

  margin: 16px 0 15px;

  color: #071e70;

  font-size: 34px;

  font-weight: 800;

  line-height: 1.12;

  letter-spacing: -0.8px;
}


.prayer-description {

  max-width: 430px;

  margin: 0;

  color: #40568f;

  font-size: 17px;

  line-height: 1.55;

  font-weight: 400;
}


/* =========================================================
   VIDEO
========================================================= */

.prayer-video {
  width: 100%;
}


.video-wrapper {

  position: relative;

  width: 100%;

  aspect-ratio: 16 / 9;

  overflow: hidden;

  border-radius: 10px;

  background: #000;
}


.video-wrapper iframe {

  position: absolute;

  top: 0;
  left: 0;

  width: 100%;
  height: 100%;

  border: 0;
}


/* =========================================================
   BOTONES
========================================================= */

.primary-button {

  border: 0;

  outline: none;

  cursor: pointer;

  display: inline-flex;

  align-items: center;

  justify-content: center;

  gap: 22px;

  min-height: 54px;

  padding: 0 32px;

  border-radius: 10px;

  background:
    linear-gradient(
      135deg,
      #126cff 0%,
      #0757ed 100%
    );

  color: #ffffff;

  font-family: inherit;

  font-size: 17px;

  font-weight: 600;

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}


.primary-button:hover {

  transform: translateY(-2px);

  box-shadow:
    0 8px 20px
    rgba(13, 99, 245, 0.25);
}


.prayer-button {

  width: 245px;

  margin-top: 25px;
}


.play-button-icon {

  width: 31px;
  height: 31px;

  flex-shrink: 0;

  display: flex;

  align-items: center;

  justify-content: center;

  border-radius: 50%;

  background: #ffffff;

  color: #176cf8;

  font-size: 13px;
}


.play-button-icon i {
  margin-left: 2px;
}


/* =========================================================
   SACERDOTE
========================================================= */

.priest-card {

  display: grid;

  grid-template-columns:
    minmax(350px, 1.1fr)
    minmax(320px, 0.9fr)
    190px;

  align-items: center;

  gap: 34px;

  min-height: 405px;

  padding: 38px;
}


.priest-info {

  display: flex;

  flex-direction: column;

  align-items: flex-start;
}


.priest-title {

  margin: 17px 0 12px;

  color: #071e70;

  font-size: 34px;

  font-weight: 800;

  line-height: 1.15;

  letter-spacing: -0.8px;
}


.priest-description {

  max-width: 470px;

  margin: 0;

  color: #40568f;

  font-size: 17px;

  line-height: 1.52;
}


.priest-button {

  min-width: 235px;

  margin-top: 24px;
}


/* =========================================================
   FOTO SACERDOTE
========================================================= */

.priest-photo-area {

  position: relative;

  width: 330px;
  height: 330px;

  margin: 0 auto;

  display: flex;

  align-items: center;

  justify-content: center;
}


.priest-photo {

  position: relative;

  z-index: 3;

  width: 285px;
  height: 285px;

  overflow: hidden;

  border-radius: 50%;

  background: #ffffff;
}


.priest-photo img {

  width: 100%;
  height: 100%;

  display: block;

  object-fit: cover;

  object-position: center;
}


/* DECORACIONES AZULES */

.priest-decoration {

  position: absolute;

  z-index: 1;

  width: 100px;
  height: 55px;

  background:
    linear-gradient(
      135deg,
      #0878ff,
      #27a9dc
    );

  transform: rotate(-38deg);
}


.decoration-top {

  top: 27px;
  right: -3px;
}


.decoration-bottom {

  bottom: 30px;
  left: 0;
}


/* =========================================================
   FRASE SACERDOTE
========================================================= */

.priest-quote {

  min-height: 220px;

  padding: 28px 23px;

  display: flex;

  flex-direction: column;

  justify-content: center;

  border-radius: 15px;

  background:
    linear-gradient(
      135deg,
      #f1f9ff 0%,
      #e4f3ff 100%
    );
}


.quote-symbol {

  height: 55px;

  color: #5597ff;

  font-family: Georgia, serif;

  font-size: 75px;

  font-weight: 700;

  line-height: 0.9;
}


.priest-quote p {

  margin: 6px 0 0;

  color: #071e70;

  font-family: Georgia, serif;

  font-size: 18px;

  font-style: italic;

  line-height: 1.5;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1050px) {

  .prayer-card {

    grid-template-columns:
      minmax(280px, 0.85fr)
      minmax(400px, 1.3fr);

    gap: 30px;
  }


  .priest-card {

    grid-template-columns:
      1fr
      300px;

  }


  .priest-quote {

    grid-column: 1 / -1;

    min-height: auto;

    flex-direction: row;

    align-items: center;

    justify-content: center;

    gap: 20px;

    padding: 18px 25px;
  }


  .priest-quote p {
    margin: 0;
  }

}


/* =========================================================
   MÓVIL
========================================================= */

@media (max-width: 767px) {

  .prayer-priest-section {

    padding:
      20px
      14px
      45px;
  }


  .content-card {

    border-radius: 15px;

    box-shadow:
      0 5px 20px
      rgba(34, 122, 190, 0.08);
  }


  /* =============================================
     ORACIÓN MÓVIL
  ============================================== */

  .prayer-card {

    display: flex;

    flex-direction: column;

    gap: 0;

    padding: 13px;

    margin-bottom: 22px;
  }


  .mobile-label {

    display: inline-flex;

    align-self: flex-start;

    margin-bottom: 10px;

    padding: 6px 13px;

    font-size: 11px;
  }


  .desktop-label {
    display: none;
  }


  .prayer-video {

    order: 1;

    margin-bottom: 12px;
  }


  .prayer-info {

    order: 2;

    width: 100%;
  }


  .video-wrapper {

    width: 100%;

    aspect-ratio: 16 / 8.2;

    border-radius: 8px;
  }


  .prayer-title {

    margin: 0 0 8px;

    font-size: 21px;

    line-height: 1.18;

    letter-spacing: -0.4px;
  }


  .desktop-break {
    display: none;
  }


  .prayer-description {

    max-width: none;

    font-size: 14px;

    line-height: 1.48;
  }


  .prayer-button {

    width: 100%;

    min-height: 50px;

    margin-top: 14px;

    font-size: 16px;

    border-radius: 9px;
  }


  .play-button-icon {

    width: 29px;
    height: 29px;
  }


  /* =============================================
     SACERDOTE MÓVIL
  ============================================== */

  .priest-card {

    display: flex;

    flex-direction: column;

    gap: 0;

    min-height: 0;

    padding: 13px;
  }


  /* FOTO ARRIBA */

  .priest-photo-area {

    order: 1;

    width: 250px;
    height: 190px;

    margin:
      0 auto
      6px;
  }


  .priest-photo {

    width: 185px;
    height: 185px;
  }


  .priest-decoration {

    width: 70px;
    height: 40px;
  }


  .decoration-top {

    top: 6px;
    right: 10px;
  }


  .decoration-bottom {

    bottom: 5px;
    left: 12px;
  }


  /* INFORMACIÓN */

  .priest-info {

    order: 2;

    width: 100%;
  }


  .priest-info .section-label {

    padding: 6px 13px;

    font-size: 11px;
  }


  .priest-title {

    margin: 9px 0 5px;

    font-size: 23px;

    line-height: 1.15;
  }


  .priest-description {

    max-width: none;

    font-size: 15px;

    line-height: 1.4;
  }


  .priest-button {

    width: 200px;

    min-width: 0;

    min-height: 47px;

    margin-top: 10px;

    padding: 0 22px;

    font-size: 15px;
  }


  /* FRASE ABAJO */

  .priest-quote {

    order: 3;

    width: 100%;

    min-height: auto;

    margin-top: 14px;

    padding: 14px 17px;

    display: flex;

    flex-direction: row;

    align-items: center;

    justify-content: center;

    gap: 12px;

    border-radius: 10px;
  }


  .quote-symbol {

    flex-shrink: 0;

    width: 42px;
    height: 42px;

    font-size: 60px;

    line-height: 0.9;
  }


  .priest-quote p {

    margin: 0;

    font-size: 15px;

    line-height: 1.35;

    text-align: center;
  }

}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 380px) {

  .prayer-priest-section {
    padding-left: 10px;
    padding-right: 10px;
  }


  .prayer-title {
    font-size: 19px;
  }


  .prayer-description {
    font-size: 13.5px;
  }


  .priest-photo-area {

    width: 220px;
    height: 175px;
  }


  .priest-photo {

    width: 170px;
    height: 170px;
  }


  .priest-title {
    font-size: 21px;
  }


  .priest-description {
    font-size: 14px;
  }

}

</style>