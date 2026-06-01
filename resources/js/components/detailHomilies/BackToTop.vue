<template>

<button
  v-if="visible"
  @click="scrollTop"
  class="back-top">

  ↑

</button>

</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const visible = ref(false);

const handleScroll = () => {
  visible.value = window.scrollY > 300;
};

const scrollTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
};

onMounted(() => {
  window.addEventListener(
    "scroll",
    handleScroll
  );
});

onBeforeUnmount(() => {
  window.removeEventListener(
    "scroll",
    handleScroll
  );
});
</script>

