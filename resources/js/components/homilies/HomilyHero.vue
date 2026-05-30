<template>
  <section
    v-if="homilyData"
    class="homily-hero"
  >

    <!-- BREADCRUMB -->
    <div class="breadcrumb">

      <span>
        Homilías
      </span>

      <i class="fa-solid fa-chevron-right"></i>

      <span>
        {{ homilyData.liturgical_time }}
      </span>

      <i class="fa-solid fa-chevron-right"></i>

      <span class="breadcrumb-current">
        {{ homilyData.solemnity_name }}
      </span>

    </div>

    <div class="hero-main">

      <div class="hero-content">

        <div class="hero-tags">

          <span class="hero-tag">
            Ciclo {{ homilyData.cycle }}
          </span>

          <span class="hero-tag">
            {{ homilyData.liturgical_time }}
          </span>

          <span class="hero-tag">
            Semana {{ homilyData.week_number }}
          </span>

        </div>

        <h1 class="hero-title">
          {{ homilyData.title }}
        </h1>

        <p class="hero-description">
          {{ homilyData.description }}
        </p>

        <div class="hero-info">

          <div class="hero-info-item">

            <i class="fa-regular fa-calendar"></i>

            <span>
              {{ homilyData.date }}
            </span>

          </div>

          <div class="hero-info-item">

            <i class="fa-solid fa-book-bible"></i>

            <span>
              {{ homilyData.citation }}
            </span>

          </div>

          <div class="hero-info-item">

            <i class="fa-solid fa-church"></i>

            <span>
              {{ homilyData.celebration_type }}
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

  grid-template-columns: minmax(0, 1fr) 610px;

  gap: 44px;

  align-items: center;
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

  margin-bottom: 22px;
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

  margin-bottom: 24px;
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

  top: 18px;
  right: 18px;

  display: flex;

  gap: 12px;
}

.hero-action-btn{
  height: 48px;

  padding: 0 18px;

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

  height: 430px;

  object-fit: cover;

  border-radius: 32px;

  box-shadow:
    0 20px 45px rgba(15, 23, 42, 0.12);

  border: 1px solid rgba(255,255,255,0.4);
}

@media (max-width: 1400px){

  .hero-main{
    grid-template-columns: 1fr 520px;
  }

  .hero-title{
    font-size: 54px;
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
    font-size: 16px;

    line-height: 1.7;
  }

  .hero-info{
    gap: 16px;
  }

}

</style>