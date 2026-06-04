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
  background:#fdfcf8;
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

  background:#fff4dd;
  color:#d89a17;

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
  color:#18244a;
}

.gospel-citation{
  margin-top:4px;
  font-size:.9rem;
  font-weight:600;
  color:#64748b;
}

.gospel-content{
  max-width:900px;

  color:#2d3b66;

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
  color:#18244a;
  font-weight:700;
}



.gospel-content :deep(blockquote){
  margin:16px 0;
  padding:14px 18px;

  border-left:4px solid #d89a17;
  background:#fff9ec;

  border-radius:12px;

  color:#7c4f00;
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

  background:linear-gradient(
    to bottom,
    rgba(253,252,248,0),
    rgba(253,252,248,1)
  );
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

  border:1px solid #e2e8f0;
  border-radius:12px;

  background:#fff;

  color:#1e40af;

  font-size:.95rem;
  font-weight:600;

  cursor:pointer;

  transition:.2s;
}

.btn-read-more:hover{
  background:#f8fafc;
  border-color:#cbd5e1;
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
