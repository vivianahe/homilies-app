<template>

<button
  v-if="visible"
  @click="scrollTop"
  class="back-top"
>
  <i class="fa-solid fa-arrow-up"></i>
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
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>

<style scoped>

.back-top{
  position:fixed;

  right:24px;
  bottom:24px;

  width:56px;
  height:56px;

  border:none;
  border-radius:50%;

  display:flex;
  align-items:center;
  justify-content:center;

  background:linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
  );

  color:#fff;

  font-size:18px;

  cursor:pointer;

  z-index:999;
  transition:
    transform .25s ease,
    box-shadow .25s ease,
    opacity .25s ease;
}

.back-top:hover{

  transform:translateY(-3px);
}

.back-top:active{

  transform:translateY(0);
}

.back-top i{

  line-height:1;
}

@media(max-width:768px){

  .back-top{

    width:48px;
    height:48px;

    right:16px;
    bottom:16px;

    font-size:16px;
  }

}

</style>