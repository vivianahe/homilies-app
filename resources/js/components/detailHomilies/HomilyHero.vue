<template>

<section class="hero-card">

  <div class="hero-image-wrapper">

    <img
      v-if="homily.img"
      :src="'/support/imgHomily/' + homily.img"
      class="hero-image"
    >

    <div class="hero-image-actions">

      <button
        type="button"
        class="hero-action-btn"
        @click="viewFullImage"
      >
        <i class="fa-solid fa-expand"></i>
        Ver completa
      </button>

      <button
        type="button"
        class="hero-action-btn primary"
        @click="downloadImage"
      >
        <i class="fa-solid fa-download"></i>
        Descargar
      </button>

    </div>

  </div>

  <div class="hero-content">

    <div
      v-if="homily.cycle || homily.liturgical_time"
      class="hero-meta"
    >

      <span
        v-if="homily.cycle"
        class="hero-badge"
      >
        {{ getCycleLabel(homily.cycle) }}
      </span>

      <span
        v-if="homily.liturgical_time"
        class="hero-badge"
      >
        {{ homily.liturgical_time }}
      </span>

      <span
        v-if="homily.celebration_type"
        class="hero-badge"
      >
        {{ homily.celebration_type }}
      </span>

    </div>

    <div
      v-if="homily.week_number"
      class="hero-week"
    >
      Semana {{ homily.week_number }}
    </div>

    <h1>
      {{ homily.title }}
    </h1>

    <p
      v-if="homily.description"
      class="hero-description"
    >
      {{ homily.description }}
    </p>

    <div
      v-if="homily.citation"
      class="hero-citation"
    >
      <i class="fa-solid fa-book-bible"></i>

      <span>
        {{ homily.citation }}
      </span>
    </div>

  </div>

  <div
    v-if="showImageModal"
    class="image-modal"
    @click="showImageModal = false"
  >

    <button
      class="image-modal-close"
      @click.stop="showImageModal = false"
    >
      <i class="fa-solid fa-xmark"></i>
    </button>

    <img
      :src="'/support/imgHomily/' + homily.img"
      class="image-modal-content"
      @click.stop
    >

  </div>

</section>

</template>

<script setup>

import { ref } from "vue";

const showImageModal = ref(false);

const props = defineProps({
  homily: Object
});

const getCycleLabel = (cycle) => {

  const labels = {
    A: "Ciclo A",
    B: "Ciclo B",
    C: "Ciclo C",
    P: "Ciclo Par",
    I: "Ciclo Impar"
  };

  return labels[cycle] || `Ciclo ${cycle}`;
};

const viewFullImage = () => {
  showImageModal.value = true;
};

const downloadImage = () => {

  const link = document.createElement("a");

  link.href =
    "/support/imgHomily/" +
    props.homily.img;

  link.download =
    props.homily.title + ".jpg";

  document.body.appendChild(link);

  link.click();

  document.body.removeChild(link);
};

</script>

<style scoped>

.hero-card{
  background:#fff;
  border-radius:24px;
  overflow:hidden;
  border:1px solid #edf2f7;
}

.hero-image{
  width:100%;
  height:320px;
  object-fit:cover;
  display:block;
}

.hero-content{
  padding:18px 32px 24px;
}

.hero-meta{
  display:flex;
  flex-wrap:wrap;
  gap:10px;

  margin-bottom:16px;
}

.hero-badge{
  height:38px;

  padding:0 16px;

  display:flex;
  align-items:center;
  justify-content:center;

  border-radius:999px;

  background:#eff6ff;

  border:1px solid #dbeafe;

  color:#2563eb;

  font-size:.92rem;
  font-weight:700;
}

.hero-week{
  margin-bottom:14px;

  font-size:1rem;
  font-weight:800;

  color:#0f172a;
}

.hero-content h1{
  font-size:3.3rem;
  line-height:1.05;
  font-weight:800;
  color:#0f172a;
  margin:6px 0 14px;
}

.hero-description{
  max-width:850px;
  font-size:1.02rem;
  line-height:1.7;
  color:#475569;
}

.hero-citation{
  margin-top:18px;

  display:inline-flex;
  align-items:center;
  gap:8px;

  padding:0;

  background:transparent;
  border:none;

  font-size:1rem;
  font-weight:700;
  color:#0f172a;
}

.hero-citation i{
  color:#2563eb;
  font-size:18px;
}

.citation-icon{
  width:20px;
  height:20px;
  color:#2563eb;
  flex-shrink:0;
}

.citation-emoji{
  font-size:18px;
}

.hero-citation{
  margin-top:20px;

  display:inline-flex;
  align-items:center;
  gap:10px;

  font-size:1.05rem;
  font-weight:700;
  color:#0f172a;
}

.hero-citation i{
  color:#2563eb;
  font-size:18px;
}

.hero-citation span{
  position:relative;
}

.citation-icon{
  width:34px;
  height:34px;

  display:flex;
  align-items:center;
  justify-content:center;

  border-radius:10px;

  background:#dbeafe;
  color:#2563eb;

  font-size:15px;
}

.citation-text{
  font-size:1rem;
  font-weight:700;
  color:#0f172a;
  line-height:1.3;
}

.hero-citation{
  margin-top:22px;

  display:flex;
  align-items:center;
  gap:10px;

  font-size:1.05rem;
  font-weight:700;
  color:#0f172a;
}

.hero-citation i{
  font-size:18px;
  color:#2563eb;
  flex-shrink:0;
}

.hero-image-wrapper{
  position:relative;
}

.hero-image-actions{
  position:absolute;

  top:16px;
  right:16px;

  display:flex;
  gap:10px;

  z-index:5;
}

.hero-action-btn{
  height:42px;

  padding:0 16px;

  border:none;
  border-radius:14px;

  background:rgba(255,255,255,.95);

  backdrop-filter:blur(10px);

  display:flex;
  align-items:center;
  gap:8px;

  font-size:.92rem;
  font-weight:700;

  color:#0f172a;

  cursor:pointer;

  box-shadow:0 10px 25px rgba(0,0,0,.15);

  transition:.2s;
}

.hero-action-btn:hover{
  transform:translateY(-2px);
}

.hero-action-btn.primary{
  background:#2563eb;
  color:#fff;
}

.image-modal{
  position:fixed;
  inset:0;

  background:rgba(0,0,0,.9);

  display:flex;
  align-items:center;
  justify-content:center;

  z-index:9999;

  padding:30px;
}

.image-modal-content{
  max-width:95vw;
  max-height:90vh;

  border-radius:20px;
}

.image-modal-close{
  position:absolute;

  top:24px;
  right:24px;

  width:50px;
  height:50px;

  border:none;
  border-radius:14px;

  background:rgba(255,255,255,.15);

  color:#fff;

  font-size:22px;

  cursor:pointer;
}

@media(max-width:768px){

  .hero-image{
    height:220px;
  }

  .hero-content{
    padding:22px;
  }

  .hero-content h1{
    font-size:2rem;
    line-height:1.15;
  }

  .hero-description{
    font-size:1rem;
    line-height:1.7;
  }

}

</style>