<template>

<section class="audio-card">

  <h2>

    🎧 Escuchar Homilía

  </h2>

  <audio
    controls
    class="audio-player">

    <source
      v-if="homily.audio"
      :src="'/support/audioHomily/' + homily.audio"
      type="audio/mp3"
    />

  </audio>

</section>

</template>

<script setup>
defineProps({
  homily: Object
})
</script>

<style scoped>

.audio-card{
  margin-top:25px;
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 8px 30px rgba(0,0,0,.08);
}

.audio-player{
  width:100%;
}  
</style>