<template>
  <section class="gospel-card">

    <div class="gospel-header">

      <div class="gospel-icon">
        <i class="fa-solid fa-book-open"></i>
      </div>

      <div>
        <h2>Evangelio</h2>
        <div class="gospel-citation">
          {{ homily.citation }}
        </div>
      </div>

    </div>

    <div
      class="gospel-content"
      :class="{ collapsed: isLongText && !expanded }"
      v-html="homily.gospel"
    ></div>

    <div
      v-if="isLongText"
      class="gospel-actions"
    >
      <button
        class="btn-read-more"
        @click="expanded = !expanded"
      >
        {{ expanded ? 'Ver menos' : 'Leer texto completo' }}

        <i
          class="fa-solid"
          :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"
        ></i>
      </button>
    </div>

  </section>
</template>

<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
  homily: Object
});

const expanded = ref(false);

const isLongText = computed(() => {
  return (props.homily?.gospel?.length || 0) > 20;
});
</script>

<style scoped>

.gospel-card{
  background:var(--public-surface);
  padding:32px 48px;
}

.gospel-header{
  display:flex;
  align-items:center;
  gap:16px;
  margin-bottom:24px;
}

.gospel-icon{
  width:52px;
  height:52px;

  border-radius:50%;

  background:var(--public-soft);
  color:var(--public-primary);

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
  color:var(--public-heading);
}

.gospel-citation{
  margin-top:4px;
  font-size:.9rem;
  font-weight:600;
  color:var(--public-text);
}

.gospel-content{
  max-width:900px;

  color:var(--public-heading);

  font-size:1rem;
  line-height:1.7;

  font-weight:400;
}

.gospel-content :deep(p){
  margin:0 0 8px 0;
}

.gospel-content :deep(br){
  display:block;
  content:"";
  margin-bottom:4px;
}


.gospel-content :deep(p:first-child:first-letter){
  float:none;
  font-size:inherit;
  line-height:inherit;
  margin-right:0;
  font-weight:inherit;
  color:inherit;
}



.gospel-content :deep(strong){
  color:var(--public-heading);
  font-weight:700;
}



.gospel-content :deep(blockquote){
  margin:16px 0;
  padding:14px 18px;

  border-left:4px solid var(--public-primary);
  background:var(--public-surface);

  border-radius:12px;

  color:var(--public-heading);
}

.gospel-content{
  overflow:hidden;
  transition:max-height .4s ease;
}

.gospel-content.collapsed{
  max-height:320px;
  position:relative;
}

.gospel-content.collapsed::after{
  content:'';

  position:absolute;
  left:0;
  right:0;
  bottom:0;

  height:120px;

  background:var(--public-soft);
}

.gospel-actions{
  display:flex;
  justify-content:center;

  margin-top:20px;
}

.btn-read-more{
  display:flex;
  align-items:center;
  gap:8px;

  padding:12px 20px;

  border:1px solid var(--public-soft);
  border-radius:12px;

  background:#fff;

  color:var(--public-primary);

  font-size:.95rem;
  font-weight:600;

  cursor:pointer;

  transition:.2s;
}

.btn-read-more:hover{
  background:var(--public-surface);
  border-color:var(--public-border);
}

@media(max-width:768px){

  .gospel-card{
    padding:24px;
  }

  .gospel-header h2{
    font-size:1.6rem;
  }

  .gospel-content{
    font-size:.95rem;
    line-height:1.6;
  }

}

</style>
