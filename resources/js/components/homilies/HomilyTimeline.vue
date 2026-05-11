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

        {{ homilies.length }}
        homilías

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

              <button class="primary-button">

                <i class="fa-solid fa-book-open"></i>

                Leer homilía

              </button>

              <button class="secondary-button">

                <i class="fa-solid fa-share-nodes"></i>

                Compartir

              </button>

            </div>

          </div>

        </div>

      </article>

    </div>

  </section>

</template>

<script setup>

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
  grid-template-columns: 60px 1fr;
  gap: 20px;
}

.timeline-line{
  display: flex;
  justify-content: center;

  position: relative;
}

.timeline-line::before{
  content: "";

  position: absolute;

  top: 0;
  bottom: 0;

  width: 2px;

  background: #dbeafe;
}

.timeline-dot{
  width: 18px;
  height: 18px;

  border-radius: 999px;

  background: #1d4ed8;

  border: 4px solid white;

  margin-top: 28px;

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

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 1200px){

  .card-content{
    grid-template-columns: 1fr;
  }

  .card-image{
    min-height: 280px;
  }

}

@media (max-width: 768px){

  .timeline-card{
    grid-template-columns: 30px 1fr;
  }

  .timeline-title{
    font-size: 28px;
  }

  .card-title{
    font-size: 24px;
  }

  .card-body{
    padding: 20px;
  }

  .timeline-header{
    flex-direction: column;
    align-items: flex-start;
  }

}

</style>