<template>

<section
  v-if="message"
  class="message-card"
>

  <div class="message-header">

    <div class="message-quote">
      <i class="fa-solid fa-heart"></i>
    </div>

    <div class="message-title">
      Mensaje del día
    </div>

  </div>

  <div
    class="message-text"
    v-html="message"
  ></div>

</section>

</template>

<script setup>
defineProps({
  message: String
});
</script>
<style scoped>

.message-card{
  position:relative;
  height:100%;
  padding:24px;
  background:#fff7fb;
  border-radius:24px;
  display:flex;
  flex-direction:column;
}

.message-header{
  display:flex;
  align-items:center;
  gap:14px;

  margin-bottom:18px;
}

.message-quote{
  width:52px;
  height:52px;

  border-radius:50%;

  background:#ffe2ee;
  color:#ec4899;

  display:flex;
  align-items:center;
  justify-content:center;

  flex-shrink:0;

  font-size:20px;
}

.message-title{
  font-size:1.4rem;
  font-weight:800;

  color:#18244a;
}

.message-text{
  color:#334155;

  font-size:1.05rem;
  line-height:1.9;

  max-width:85%;
}

.message-text :deep(p){
  margin:0;
}

.message-card::after{
  content:"❞";

  position:absolute;

  right:18px;
  bottom:8px;

  font-size:72px;

  color:#fbcfe8;

  line-height:1;
}

@media(max-width:768px){

  .message-card{
    padding:18px;
    min-height:auto;
  }

  .message-header{
    gap:12px;
    margin-bottom:14px;
  }

  .message-quote{
    width:44px;
    height:44px;

    font-size:16px;
  }

  .message-title{
    font-size:1.15rem;
    line-height:1.3;
  }

  .message-text{
    max-width:100%;

    font-size:.95rem;
    line-height:1.7;

    padding-right:32px;
  }

  .message-card::after{

    right:12px;
    bottom:4px;

    font-size:48px;

    opacity:.6;
  }

}

</style>