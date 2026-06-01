<template>

<section class="gospel-card">

  <h2>

    Evangelio

  </h2>

  <p>

    {{ homily.citation }}

  </p>

  <div
    v-html="homily.gospel">
  </div>

</section>

</template>

<script setup>
defineProps({
  homily: Object
});
</script>

