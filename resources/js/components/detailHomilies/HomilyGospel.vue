<template>

<section class="gospel-card">

  <div class="gospel-header">

    <div class="gospel-icon">
      <i class="fa-solid fa-book-open"></i>
    </div>

    <div>

      <h2>
        Evangelio
      </h2>

      <div class="gospel-citation">
        {{ homily.citation }}
      </div>

    </div>

  </div>

  <div
    class="gospel-content"
    v-html="homily.gospel"
  ></div>

</section>

</template>

<script setup>
defineProps({
  homily: Object
});
</script>

<style scoped>

.gospel-card{
  padding:0;
}

.gospel-header{
  display:flex;
  align-items:flex-start;
  gap:16px;

  margin-bottom:16px;
}

.gospel-icon{
  width:52px;
  height:52px;

  border-radius:16px;

  background:#eff6ff;

  color:#2563eb;

  display:flex;
  align-items:center;
  justify-content:center;

  font-size:22px;

  flex-shrink:0;
}

.gospel-header h2{
  margin:0;

  font-size:2rem;
  font-weight:800;

  color:#0f172a;
}

.gospel-citation{
  margin-top:4px;

  font-size:1rem;
  font-weight:700;

  color:#475569;
}

.gospel-content{
  color:#334155;

  font-size:1rem;
  line-height:1.65;
}

.gospel-content :deep(p){
  margin-bottom:10px;
}

.gospel-content :deep(p:last-child){
  margin-bottom:0;
}

/* Citas o frases especiales */
.gospel-content :deep(blockquote){
  margin:24px 0;

  padding:16px 20px;

  border-radius:14px;

  background:#f8fafc;

  border-left:4px solid #2563eb;

  font-style:italic;

  color:#475569;
}

/* Negrillas */
.gospel-content :deep(strong){
  color:#0f172a;
  font-weight:700;
}

@media(max-width:768px){

  .gospel-card{
    padding:22px 24px;
  }

  .gospel-header h2{
    font-size:1.6rem;
  }

  .gospel-content{
    font-size:1rem;
    line-height:1.8;
  }

}

</style>
