<template>

<section
  v-if="description"
  class="description-card"
>

  <div class="description-header">

    <div class="description-icon">
      <i class="fa-solid fa-book-open-reader"></i>
    </div>

    <div>
      <div class="description-title">
        Descripción
      </div>
    </div>

  </div>

  <div class="description-body">

    <div
      class="description-text"
      v-html="description"
    ></div>

    <div class="description-decoration">
      ⛪
    </div>

  </div>

</section>

</template>

<script setup>
defineProps({
  description: String
});
</script>

<style scoped>

.description-card{
  position:relative;
  background:#fafaff;
  border-radius:24px;
  padding:28px;
  height:100%;
  overflow:hidden;
}

.description-header{
  display:flex;
  align-items:center;
  gap:14px;

  margin-bottom:20px;

  position:relative;
  z-index:2;
}

.description-icon{
  width:52px;
  height:52px;

  border-radius:50%;

  background:#eef3ff;
  color:#2563eb;

  display:flex;
  align-items:center;
  justify-content:center;

  font-size:22px;

  flex-shrink:0;
}

.description-title{
  font-size:1.5rem;
  font-weight:800;

  color:#18244a;
}

.description-body{
  position:relative;
}

.description-text{
  position:relative;
  z-index:2;

  color:#475569;

  font-size:1rem;
  line-height:2;

  max-width:100%;
}

.description-text :deep(p){
  margin:0;
}

.description-decoration{
  position:absolute;

  right:16px;
  bottom:10px;

  font-size:120px;

  opacity:.06;

  pointer-events:none;

  z-index:1;

  line-height:1;
}

/* MOBILE */

@media(max-width:768px){

  .description-card{
    padding:20px;
  }

  .description-header{
    gap:12px;
    margin-bottom:16px;
  }

  .description-icon{
    width:44px;
    height:44px;

    font-size:18px;
  }

  .description-title{
    font-size:1.2rem;
  }

  .description-text{
    font-size:.95rem;
    line-height:1.8;

    padding-right:16px;
  }

  .description-decoration{
    right:10px;
    bottom:10px;

    font-size:90px;

    opacity:.05;
  }

}

</style>