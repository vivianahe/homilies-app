<template>
  <aside class="sidebar-card">

    <div class="sidebar-header">
      <h2>Homilías relacionadas</h2>
    </div>

    <div class="related-list">

      <router-link
        v-for="homily in homilies"
        :key="homily.id"
        :to="`/HomilyDetailNew/${homily.id}`"
        class="related-item"
      >
        <img
          :src="`/support/imgHomily/${homily.img}`"
          :alt="homily.title"
          class="related-image"
        />

        <div class="related-content">

          <div class="related-meta">

            <span>
              {{ formatDate(homily.date) }}
            </span>

            <span class="badge">
              {{ homily.liturgical_time }}
            </span>

          </div>

          <h3>
            {{ homily.title }}
          </h3>

          <p>
            {{ homily.description }}
          </p>

        </div>

      </router-link>

    </div>

    <button
      class="btn-more"
      @click="goToAllHomilies"
    >
      Ver más homilías
    </button>

  </aside>

</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

defineProps({
  homilies: {
    type: Array,
    default: () => []
  }
});

const goToAllHomilies = () => {
  router.push({
    name: 'homilyAllNew'
  });
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString(
    "es-ES",
    {
      day: "numeric",
      month: "long",
      year: "numeric"
    }
  );
};
</script>


<style scoped>

.related-content{
  flex:1;
  min-width:0;
}

.related-content p{
  color:#64748b;
  line-height:1.5;

  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;

  overflow:hidden;
}

.sidebar-card{
  background:#fff;

  border:1px solid #edf1f7;

  border-radius:24px;
  padding:28px;

  position:sticky;
  top:100px;

  min-height:900px;
}

.sidebar-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:24px;
}

.sidebar-header h2{
  font-size:2.3rem;
  font-weight:800;
  line-height:1.1;
  color:#0f172a;
}

.btn-all{
  padding:10px 16px;
  border:1px solid #dbeafe;
  border-radius:12px;
  background:white;
  color:#2563eb;
}

.related-list{
  display:flex;
  flex-direction:column;
}

.related-item{
  display:flex;
  gap:18px;

  padding:24px 0;

  border-bottom:1px solid #e5e7eb;

  cursor:pointer;

  text-decoration:none;
  color:inherit;

  transition:all .2s ease;
}

.related-item:hover{
  transform:translateY(-2px);
}

.related-image{
  width:150px;
  height:150px;
  object-fit:cover;
  border-radius:18px;
  flex-shrink:0;
}

.related-content h3{
  font-size:1.7rem;
  font-weight:800;
  color:#0f172a;

  margin:10px 0;

  line-height:1.2;

  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}

.related-content p{
  color:#64748b;
  line-height:1.6;
  font-size:.95rem;

  display:-webkit-box;
  -webkit-line-clamp:3;
  -webkit-box-orient:vertical;
  overflow:hidden;
}

.related-meta{
  display:flex;
  gap:8px;
  align-items:center;
  flex-wrap:wrap;
}

.related-meta span:first-child{
  color:#64748b;
  font-size:.85rem;
}

.badge{
  background:#eff6ff;
  color:#2563eb;
  padding:4px 10px;
  border-radius:999px;
  font-size:.75rem;
  font-weight:600;
}

.btn-more{
  width:100%;
  margin-top:24px;
  padding:14px;
  border:1px solid #c7d2fe;
  border-radius:14px;
  background:white;
  color:#2563eb;
  font-weight:600;
}

</style>