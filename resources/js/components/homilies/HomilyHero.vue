<template>
  <section
    v-if="homilyData"
    class="homily-hero"
  >

    <div class="hero-main">

      <div class="hero-content">

      <div class="hero-liturgical">

      <div class="hero-liturgical-top">

        {{ getCycleLabel(homilyData.cycle) }}

        <span v-if="homilyData.liturgical_time">
          , {{ homilyData.liturgical_time }}
        </span>

        <span
          v-if="
            homilyData.celebration_type &&
            homilyData.celebration_type !== 'null'
          ">

          , {{ homilyData.celebration_type }}

        </span>

      </div>

        <div
          v-if="homilyData.week_number"
          class="hero-liturgical-bottom">

          Semana {{ homilyData.week_number }}

        </div>

      </div>

        <h1 class="hero-title">
          {{ homilyData.title }}
        </h1>

        <p class="hero-description">
          {{ homilyData.description }}
        </p>

        <div class="hero-info">

          <div class="hero-info-item">

            <i class="fa-solid fa-book-bible"></i>

            <span>
              {{ homilyData.citation }}
            </span>

          </div>

        </div>

      </div>

      <div class="hero-image-container">

        <div class="hero-image-wrapper">

          <img
            :src="'/support/imgHomily/' + homilyData.img"
            alt="Homilía"
            class="hero-image"
          />

          <div class="hero-image-actions">

            <button
              type="button"
              class="hero-action-btn"
              @click="viewFullImage">

              <i class="fa-solid fa-expand"></i>

              <span>Ver completa</span>

            </button>

            <button
              type="button"
              class="hero-action-btn primary"
              @click="downloadImage">

              <i class="fa-solid fa-download"></i>

              <span>Descargar</span>

            </button>

          </div>

        </div>

      </div>

    </div>

  </section>
  
  <div
    v-if="showImageModal"
    class="image-modal"
    @click="showImageModal = false">

    <button
      type="button"
      class="image-modal-close"
      @click.stop="showImageModal = false">

      <i class="fa-solid fa-xmark"></i>

    </button>

    <img
      :src="'/support/imgHomily/' + homilyData.img"
      class="image-modal-content"
      @click.stop
    />

  </div>

</template>

<script setup>

import { ref } from "vue";

const showImageModal = ref(false);

const props = defineProps({
  homilyData: {
    type: Object,
    required: true,
  },
});

const getCycleLabel = (cycle) => {

  const labels = {
    A: 'Ciclo A',
    B: 'Ciclo B',
    C: 'Ciclo C',
    P: 'Ciclo Par',
    I: 'Ciclo Impar'
  };

  return labels[cycle] || cycle;

};

const viewFullImage = () => {
  showImageModal.value = true;
};

const downloadImage = () => {

  const link = document.createElement('a');

  link.href =
    '/support/imgHomily/' +
    props.homilyData.img;

  link.download =
    props.homilyData.title + '.jpg';

  document.body.appendChild(link);

  link.click();

  document.body.removeChild(link);
};

</script>
<style scoped>

.homily-hero{
  display: flex;
  flex-direction: column;

  gap: 26px;
}

.breadcrumb{
  display: flex;

  align-items: center;

  gap: 12px;

  flex-wrap: wrap;

  font-size: 14px;

  color: #64748b;

  font-weight: 500;
}

.breadcrumb i{
  font-size: 11px;

  color: #94a3b8;
}

.breadcrumb-current{
  color: #0f172a;

  font-weight: 700;
}

.hero-main{
  display: grid;

  grid-template-columns: minmax(0,1fr) 680px;

  gap: 40px;

  align-items: start;
}

.hero-content{
  display: flex;

  flex-direction: column;

  justify-content: center;
}

.hero-tags{
  display: flex;

  align-items: center;

  gap: 12px;

  flex-wrap: wrap;

  margin-bottom: 32px;
}

.hero-tag{
  height: 38px;

  padding: 0 18px;

  border-radius: 999px;

  background: #eef2ff;

  color: #1d4ed8;

  display: inline-flex;

  align-items: center;

  justify-content: center;

  font-size: 14px;

  font-weight: 700;

  border: 1px solid #dbeafe;
}

.hero-title{
  font-size: 62px;

  line-height: 1;

  letter-spacing: -2px;

  font-weight: 800;

  color: #0f172a;

  margin-bottom: 32px;
}

.hero-description{
  font-size: 20px;

  line-height: 1.9;

  color: #475569;

  max-width: 760px;

  margin-bottom: 30px;
}

.hero-info{
  display: flex;

  align-items: center;

  gap: 28px;

  flex-wrap: wrap;
}

.hero-info-item{
  display: flex;

  align-items: center;

  gap: 10px;

  color: #334155;

  font-size: 15px;

  font-weight: 600;
}

.hero-info-item i{
  color: #2563eb;
}

.hero-image-container{
  width: 100%;
}

.hero-image-wrapper{
  position: relative;
}

.hero-image-actions{
  position: absolute;

  top: 12px;
  right: 12px;

  display: flex;

  gap: 10px;
}

.hero-action-btn{
  height: 42px;

  padding: 0 16px;

  border: none;

  border-radius: 16px;

  background: rgba(255,255,255,.92);

  backdrop-filter: blur(10px);

  display: flex;

  align-items: center;

  gap: 10px;

  cursor: pointer;

  font-weight: 700;

  color: #0f172a;

  box-shadow:
    0 10px 25px rgba(15,23,42,.12);

  transition: .25s;
}

.hero-action-btn:hover{
  transform: translateY(-2px);
}

.hero-action-btn.primary{
  background: #4f46e5;

  color: white;
}

.image-modal{
  position: fixed;

  inset: 0;

  background: rgba(0,0,0,.88);

  z-index: 9999;

  display: flex;

  align-items: center;

  justify-content: center;

  padding: 40px;
}

.image-modal-content{
  max-width: 95vw;

  max-height: 90vh;

  border-radius: 24px;
}

.image-modal-close{
  position: absolute;

  top: 30px;
  right: 30px;

  width: 54px;
  height: 54px;

  border: none;

  border-radius: 18px;

  background: rgba(255,255,255,.15);

  color: white;

  cursor: pointer;

  font-size: 22px;
}

.hero-image{
  width: 100%;
  height: 280px;
  object-fit: cover;
  border-radius: 24px;
}

@media (max-width: 1400px){

  .hero-main{
    grid-template-columns: 1fr 520px;
  }

  .hero-title{
    font-size: 58px;

    line-height: .95;
  }

}

@media (max-width: 1200px){

  .hero-main{
    grid-template-columns: 1fr;

    gap: 28px;
  }

  .hero-image{
    height: auto;
  }

}

@media (max-width: 768px){

  .hero-title{
    font-size: 40px;

    line-height: 1.08;
  }

  .hero-description{
    font-size: 18px;

    line-height: 1.8;

    max-width: 700px;
  }

  .hero-info{
    gap: 16px;
  }

}

.hero-liturgical{
  margin-bottom: 22px;
}

.hero-liturgical-top{
  font-size: 18px;
  font-weight: 700;
  color: #7c83f7;
}

.hero-liturgical-bottom{
  margin-top: 6px;

  font-size: 24px;

  font-weight: 800;

  color: #1e1b4b;
}

</style>