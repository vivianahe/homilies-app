<template>

<section
  v-if="message"
  class="message-card"
>

  <div class="message-quote">
    <i class="fa-solid fa-quote-left"></i>
  </div>

  <div class="message-content">

    <div class="message-title">
      Mensaje del día
    </div>

    <div
      class="message-text"
      v-html="message"
    ></div>

  </div>

</section>

</template>

<script setup>
defineProps({
  message: String
});
</script>

<style scoped>

.message-card{
  display:flex;
  align-items:center;
  gap:20px;

  margin-bottom:32px;
  padding:18px 24px;

  border-radius:18px;

  background:#f5f9ff;

  border-left:6px solid #2563eb;

  box-shadow:
    0 4px 20px rgba(37,99,235,.08);

  overflow:hidden;
}

.message-quote{
  flex-shrink:0;

  width:64px;
  height:64px;

  display:flex;
  align-items:center;
  justify-content:center;

  border-radius:50%;

  background:#2563eb;
  color:white;

  font-size:24px;

  box-shadow:
    0 8px 20px rgba(37,99,235,.25);
}

.message-content{
  flex:1;
  min-width:0;
}

.message-title{
  margin-bottom:6px;

  font-size:1.25rem;
  font-weight:800;

  color:#1d4ed8;
}

.message-text{
  font-size:1rem;
  line-height:1.6;

  color:#334155;
}

.message-text :deep(p){
  margin:0;
}

.message-text :deep(strong){
  color:#0f172a;
}

@media (max-width: 768px){

  .message-card{
    align-items:flex-start;
    gap:16px;
    padding:16px;
  }

  .message-quote{
    width:52px;
    height:52px;
    font-size:20px;
  }

  .message-title{
    font-size:1.1rem;
  }

  .message-text{
    font-size:.95rem;
  }
}

</style>