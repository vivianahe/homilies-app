<template>

<section
  v-if="message"
  class="message-card">

  <h2>

    Mensaje del día

  </h2>

  <div
    v-html="message">
  </div>

</section>

</template>

<script setup>
defineProps({
  message: String
});
</script>
