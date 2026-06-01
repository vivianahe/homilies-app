<template>

<section class="hero-card">

  <img
    v-if="homily.img"
    :src="'/support/imgHomily/' + homily.img"
    class="hero-image"
  >

  <div class="hero-content">

    <h1>
      {{ homily.title }}
    </h1>

    <p>
      {{ homily.reading }}
    </p>

  </div>

</section>

</template>

<script setup>
defineProps({
  homily: Object
})
</script>

<style scoped>

.hero-card{
  background:white;
  border-radius:24px;
  overflow:hidden;
  box-shadow:0 8px 30px rgba(0,0,0,.08);
}

.hero-image{
  width:100%;
  height:420px;
  object-fit:cover;
}

.hero-content{
  padding:30px;
}

.hero-content h1{
  font-size:3rem;
  font-weight:800;
  line-height:1.1;
  color:#0f172a;
}

.hero-content p{
  margin-top:20px;
  color:#64748b;
  font-size:1.1rem;
}

</style>