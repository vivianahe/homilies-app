<template>

  <section class="homily-timeline">

    <!-- HEADER -->
    <div class="timeline-header">

      <div>

        <h2 class="timeline-title">
          Homilías Disponibles
        </h2>

        <p class="timeline-description">
          Explora las reflexiones y enseñanzas organizadas cronológicamente.
        </p>

      </div>

      <div class="timeline-counter">

        {{
          homilies.length === 0
            ? 'Sin homilías'
            : `${homilies.length} ${
                homilies.length === 1
                  ? 'homilía'
                  : 'homilías'
              }`
        }}

      </div>

    </div>

    <!-- EMPTY -->
    <div
      v-if="homilies.length === 0"
      class="timeline-empty"
    >

      <i class="fa-regular fa-folder-open"></i>

      <h3>
        No existen homilías disponibles
      </h3>

      <p>
        Intenta cambiar los filtros o seleccionar otra fecha.
      </p>

    </div>

    <!-- LIST -->
    <div
      v-else
      class="timeline-list"
    >

      <article
        v-for="(homily, index) in homilies"
        :key="homily.id || index"
        class="timeline-card"
      >

        <!-- LINE -->
        <div class="timeline-line">

          <div
            v-if="
              index === 0 ||
              getYear(homily.date) !==
              getYear(homilies[index - 1].date)
            "
            class="timeline-year">

            {{ getYear(homily.date) }}

          </div>

          <div class="timeline-dot"></div>

        </div>

        <!-- CARD -->
        <div class="card-content">

          <!-- IMAGE -->
          <div class="card-image-container">

          <img
            :src="'/support/imgHomily/' + homily.img"
            :alt="homily.title"
            class="card-image"
          />

          </div>

          <!-- CONTENT -->
          <div class="card-body">

            <!-- META -->
            <div class="card-meta">

              <span class="card-year-mobile">
              {{ getYear(homily.date) }}
              </span>

              <span class="card-date">

                <i class="fa-regular fa-calendar"></i>

                {{ formatDate(homily.date) }}

              </span>

              <span
                v-if="homily.liturgical_time"
                class="card-tag"
              >
                {{ homily.liturgical_time }}
              </span>

            </div>

            <!-- TITLE -->
            <h3 class="card-title">
              {{ homily.title }}
            </h3>

            <!-- DESCRIPTION -->
            <p class="card-description">
              {{
                homily.description ||
                "Reflexión espiritual y enseñanza basada en el Evangelio del día."
              }}
            </p>

            <!-- AUTHOR -->
            <div class="card-author">

              <div class="author-avatar">

                <i class="fa-solid fa-user"></i>

              </div>

              <div>

                <p class="author-name">
                  {{ homily.author || "Padre Uriel Franco" }}
                </p>

                <p class="author-role">
                  Sacerdote y predicador
                </p>

              </div>

            </div>

            <!-- AUDIO -->
            <div
              v-if="homily.audio_url"
              class="audio-player"
            >

              <audio
                controls
                class="audio-element"
              >
                <source
                  :src="homily.audio_url"
                  type="audio/mpeg"
                />
              </audio>

            </div>

            <!-- ACTIONS -->
            <div class="card-actions">

              <a
                :href="`/homilyDetail/${homily.id}`"
                class="primary-button"
              >

                <i class="fa-solid fa-book-open"></i>

                Leer homilía

              </a>

              <button
                class="secondary-button"
                @click="shareHomily(homily)"
              >
                <i class="fa-solid fa-share-nodes"></i>

                Compartir

              </button>

            </div>

          </div>

        </div>

      </article>

    </div>

    <transition name="toast">

      <div
        v-if="showShareToast"
        class="share-toast"
      >

        <i class="fa-solid fa-circle-check"></i>

        <div>

          <strong>Enlace copiado</strong>

          <p>
            Ya puedes compartir la homilía.
          </p>

        </div>

      </div>

    </transition>

  </section>

</template>

<script setup>

import { ref } from "vue";

const showShareToast = ref(false);

/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

defineProps({
  homilies: {
    type: Array,
    default: () => [],
  },
});

/*
|--------------------------------------------------------------------------
| METHODS
|--------------------------------------------------------------------------
*/

const formatDate = (date) => {

  if (!date) return "";

  const months = [
    "enero",
    "febrero",
    "marzo",
    "abril",
    "mayo",
    "junio",
    "julio",
    "agosto",
    "septiembre",
    "octubre",
    "noviembre",
    "diciembre",
  ];

  const [year, month, day] = date.split("-");

  return `${parseInt(day)} de ${months[parseInt(month) - 1]} de ${year}`;

};

const getYear = (date) => {

  if (!date) return "";

  return date.split("-")[0];

};

const shareHomily = async (homily) => {

  const url =
    `${window.location.origin}/share/homily/${homily.id}`;

  try {

    if (navigator.share) {

      await navigator.share({
        url
      });

    } else {

      await navigator.clipboard.writeText(url);

      showShareToast.value = true;

      setTimeout(() => {
        showShareToast.value = false;
      }, 3000);

    }

  } catch (error) {

    console.log(error);

  }

};

</script>

<style scoped>

.homily-timeline{
  display: flex;
  flex-direction: column;
  gap: 28px;
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.timeline-header{
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

.timeline-title{
  font-size: 34px;
  font-weight: 800;

  color: #0f172a;

  margin-bottom: 8px;
}

.timeline-description{
  color: #64748b;

  font-size: 16px;
}

.timeline-counter{
  background: #eff6ff;

  color: #1d4ed8;

  font-weight: 700;

  padding: 12px 18px;

  border-radius: 14px;
}

/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.timeline-empty{
  background: white;

  border: 1px dashed #cbd5e1;

  border-radius: 24px;

  padding: 80px 24px;

  text-align: center;
}

.timeline-empty i{
  font-size: 52px;

  color: #94a3b8;

  margin-bottom: 20px;
}

.timeline-empty h3{
  font-size: 24px;
  font-weight: 700;

  color: #0f172a;

  margin-bottom: 12px;
}

.timeline-empty p{
  color: #64748b;
}

/*
|--------------------------------------------------------------------------
| LIST
|--------------------------------------------------------------------------
*/

.timeline-list{
  display: flex;
  flex-direction: column;
  gap: 28px;
}

/*
|--------------------------------------------------------------------------
| ITEM
|--------------------------------------------------------------------------
*/

.timeline-card{
  display: grid;
  grid-template-columns: 150px 1fr;
  gap: 20px;
}

/*
|--------------------------------------------------------------------------
| TIMELINE
|--------------------------------------------------------------------------
*/

.timeline-line{
  position: relative;

  width: 120px;
  min-height: 100%;

  display: flex;
  justify-content: flex-start;
}

.timeline-line::before{
  content: "";

  position: absolute;

  top: 0;
  bottom: 0;

  left: 93px;

  width: 2px;

  background: #dbeafe;
}

.timeline-year{
  position: absolute;

  top: 18px;
  left: 0;

  width: 70px;

  text-align: right;

  font-size: 26px;
  font-weight: 800;

  color: #2563eb;

  line-height: 1;

  white-space: nowrap;
}

.timeline-dot{
  position: absolute;

  top: 20px;
  left: 86px;

  width: 16px;
  height: 16px;

  border-radius: 999px;

  background: #2563eb;

  border: 3px solid white;

  z-index: 2;
}

.card-content{
  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 28px;

  overflow: hidden;

  display: grid;
  grid-template-columns: 340px 1fr;

  transition: 0.2s ease;
}

.card-content:hover{
  transform: translateY(-3px);

  box-shadow: 0 18px 40px rgba(0,0,0,0.06);
}

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
*/

.card-image-container{
  width: 100%;
  height: 100%;
}

.card-image{
  width: 100%;
  height: 100%;

  object-fit: cover;
}

/*
|--------------------------------------------------------------------------
| BODY
|--------------------------------------------------------------------------
*/

.card-body{
  padding: 28px;

  display: flex;
  flex-direction: column;
  gap: 22px;
}

/*
|--------------------------------------------------------------------------
| META
|--------------------------------------------------------------------------
*/

.card-meta{
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}

.card-date{
  display: flex;
  align-items: center;
  gap: 8px;

  color: #475569;

  font-weight: 600;
}

.card-tag{
  background: #eff6ff;

  color: #1d4ed8;

  padding: 8px 12px;

  border-radius: 999px;

  font-size: 13px;
  font-weight: 700;
}

/*
|--------------------------------------------------------------------------
| TEXT
|--------------------------------------------------------------------------
*/

.card-title{
  font-size: 30px;
  line-height: 1.2;
  font-weight: 800;

  color: #0f172a;
}

.card-description{
  font-size: 16px;
  line-height: 1.8;

  color: #475569;
}

/*
|--------------------------------------------------------------------------
| AUTHOR
|--------------------------------------------------------------------------
*/

.card-author{
  display: flex;
  align-items: center;
  gap: 14px;
}

.author-avatar{
  width: 52px;
  height: 52px;

  border-radius: 999px;

  background: #dbeafe;

  color: #1d4ed8;

  display: flex;
  align-items: center;
  justify-content: center;
}

.author-name{
  font-weight: 700;

  color: #0f172a;
}

.author-role{
  color: #64748b;

  font-size: 14px;
}

/*
|--------------------------------------------------------------------------
| AUDIO
|--------------------------------------------------------------------------
*/

.audio-player{
  width: 100%;
}

.audio-element{
  width: 100%;
}

/*
|--------------------------------------------------------------------------
| ACTIONS
|--------------------------------------------------------------------------
*/

.card-actions{
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}

.primary-button{
  background: #1d4ed8;

  color: white;

  padding: 14px 20px;

  border-radius: 14px;

  font-weight: 700;

  display: flex;
  align-items: center;
  gap: 10px;
}

.secondary-button{
  border: 1px solid #cbd5e1;

  color: #334155;

  padding: 14px 20px;

  border-radius: 14px;

  font-weight: 700;

  display: flex;
  align-items: center;
  gap: 10px;
}

.primary-button{
  background: #1d4ed8;

  color: white;

  padding: 14px 20px;

  border-radius: 14px;

  font-weight: 700;

  display: flex;
  align-items: center;
  gap: 10px;

  text-decoration: none;

  width: fit-content;
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

.card-year-mobile{
  display: none;
}

@media (max-width: 1200px){

  .card-content{
    grid-template-columns: 1fr;
  }

  .card-image{
    min-height: 280px;
  }

}

@media (max-width: 768px){

  .timeline-header{
    flex-direction: column;
    align-items: flex-start;
  }

  .timeline-title{
    font-size: 28px;
  }

  .timeline-description{
    font-size: 14px;
  }

  .timeline-counter{
    padding: 10px 14px;
    font-size: 14px;
  }

  .timeline-card{
    grid-template-columns: 32px 1fr;
    gap: 12px;
  }

  .timeline-line{
    width: 32px;
  }

  .timeline-line::before{
    left: 16px;
  }

  .timeline-dot{
    left: 9px;

    width: 14px;
    height: 14px;
  }

  /* ocultar año lateral en móvil */
  .timeline-year{
    display: none;
  }

  /* mostrar año dentro de la tarjeta */
  .card-year-mobile{
    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 6px 12px;

    border-radius: 999px;

    background: #eff6ff;

    color: #2563eb;

    font-size: 12px;
    font-weight: 700;
  }

  .card-content{
    grid-template-columns: 1fr;
  }

  .card-image{
    min-height: 180px;
  }

  .card-body{
    padding: 18px;
    gap: 16px;
  }

  .card-meta{
    gap: 10px;
  }

  .card-title{
    font-size: 24px;
  }

  .card-description{
    font-size: 15px;
    line-height: 1.7;
  }

  .card-actions{
    flex-direction: column;
  }

  .primary-button,
  .secondary-button{
    width: 100%;
    justify-content: center;
  }

}

.share-toast{

  position: fixed;

  bottom: 24px;
  right: 24px;

  z-index: 9999;

  display: flex;
  align-items: center;
  gap: 14px;

  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 16px;

  padding: 16px 20px;

  box-shadow:
    0 10px 30px rgba(0,0,0,0.12);

  min-width: 280px;
}

.share-toast i{

  color: #22c55e;

  font-size: 24px;
}

.share-toast strong{

  display: block;

  color: #0f172a;

  margin-bottom: 4px;
}

.share-toast p{

  color: #64748b;

  font-size: 14px;

  margin: 0;
}

/* ANIMACIÓN */

.toast-enter-active,
.toast-leave-active{

  transition: all .25s ease;
}

.toast-enter-from,
.toast-leave-to{

  opacity: 0;

  transform:
    translateY(20px);
}

@media (max-width:768px){

  .share-toast{

    left: 16px;
    right: 16px;

    bottom: 16px;

    min-width: auto;
  }
}

</style>