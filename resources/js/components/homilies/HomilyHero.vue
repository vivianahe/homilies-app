<template>

  <section
    v-if="homilyData"
    class="homily-hero"
  >
    <!-- HERO PRINCIPAL -->
    <div class="hero-main">

      <!-- CONTENIDO -->
      <div class="hero-content">

        <span class="hero-subtitle">
          {{ homilyData.cycle || "Ciclo A" }},
          {{ homilyData.liturgical_time || "Tiempo de Pascua" }}
        </span>

        <h1 class="hero-title">
          {{ homilyData.title }}
        </h1>

        <p class="hero-description">
          {{
            homilyData.description ||
            "Este domingo se celebra dentro del tiempo litúrgico correspondiente. Las lecturas y reflexiones ayudan a profundizar en el mensaje del Evangelio."
          }}
        </p>

      </div>

      <!-- IMAGEN -->
      <div class="hero-image-container">

      <img
        :src="'/support/imgHomily/' + homilyData.img"
        alt="Homilía"
        class="hero-image"
      />

      </div>

    </div>

    <!-- LECTURAS -->
    <div class="readings-grid">

      <!-- PRIMERA LECTURA -->
      <div class="reading-card">

        <div class="reading-icon">
          <i class="fa-solid fa-book-open"></i>
        </div>

        <div class="reading-content">

          <h3 class="reading-title">
            Primera lectura
          </h3>

          <p class="reading-reference">
            {{ homilyData.first_reading || "Hechos 8, 5-8. 14-17" }}
          </p>

          <p class="reading-text">
            {{
              homilyData.first_reading_text ||
              "La gente acogía con alegría la palabra de Dios."
            }}
          </p>

        </div>

      </div>

      <!-- SALMO -->
      <div class="reading-card">

        <div class="reading-icon">
          <i class="fa-solid fa-book-bible"></i>
        </div>

        <div class="reading-content">

          <h3 class="reading-title">
            Salmo responsorial
          </h3>

          <p class="reading-reference">
            {{ homilyData.psalm || "Salmo 65(66)" }}
          </p>

          <p class="reading-text">
            {{
              homilyData.psalm_text ||
              "Aclama al Señor, tierra entera."
            }}
          </p>

        </div>

      </div>

      <!-- EVANGELIO -->
      <div class="reading-card">

        <div class="reading-icon">
          <i class="fa-solid fa-cross"></i>
        </div>

        <div class="reading-content">

          <h3 class="reading-title">
            Evangelio
          </h3>

          <p class="reading-reference">
            {{ homilyData.gospel || "Juan 14, 15-21" }}
          </p>

          <p class="reading-text">
            {{
              homilyData.gospel_text ||
              "El Espíritu Santo les enseñará todas las cosas."
            }}
          </p>

        </div>

      </div>

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
  homilyData: {
    type: Object,
    required: true,
  },
});

</script>

<style scoped>

.homily-hero{
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/*
|--------------------------------------------------------------------------
| BREADCRUMB
|--------------------------------------------------------------------------
*/

.breadcrumb{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;

  font-size: 14px;

  color: #64748b;
}

.breadcrumb-current{
  color: #0f172a;
  font-weight: 600;
}

/*
|--------------------------------------------------------------------------
| HERO
|--------------------------------------------------------------------------
*/

.hero-main{
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 24px;

  align-items: center;
}

.hero-content{
  display: flex;
  flex-direction: column;
  padding: 0;
  margin-top: 0px;
  margin-bottom: 0px;
  padding-top: 0px;
  padding-bottom: 0px;
}

.hero-subtitle{
  font-size: 25px;
  font-weight: 600;

  color: #475569;
}

.hero-title{
  font-size: 52px;
  line-height: 1.1;
  font-weight: 800;

  color: #0f172a;
}

.hero-description{
  font-size: 18px;
  line-height: 1.8;

  color: #475569;
}

.hero-image-container{
  width: 100%;
  height: 100%;
}

.hero-image{
  width: 100%;
  height: 100%;
  min-height: 320px;
  object-fit: cover;
  border-radius: 24px;
}

/*
|--------------------------------------------------------------------------
| LECTURAS
|--------------------------------------------------------------------------
*/

.readings-grid{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.reading-card{
  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 20px;

  padding: 24px;

  display: flex;
  gap: 18px;

  transition: 0.2s ease;
}

.reading-card:hover{
  transform: translateY(-2px);

  box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.reading-icon{
  width: 52px;
  height: 52px;

  min-width: 52px;

  border-radius: 14px;

  background: #eef2ff;

  color: #1d4ed8;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 22px;
}

.reading-content{
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.reading-title{
  font-size: 16px;
  font-weight: 700;

  color: #0f172a;
}

.reading-reference{
  font-size: 15px;
  font-weight: 600;

  color: #1d4ed8;
}

.reading-text{
  font-size: 15px;
  line-height: 1.7;

  color: #475569;
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 1200px){

  .hero-main{
    grid-template-columns: 1fr;
  }

  .readings-grid{
    grid-template-columns: 1fr;
  }

}

@media (max-width: 768px){

  .hero-title{
    font-size: 38px;
  }

  .hero-description{
    font-size: 16px;
  }

}

</style>