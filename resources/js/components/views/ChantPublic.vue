<template>
  <Header />
  <main class="chants-page">
    <div class="chants-container">
      <header class="chants-heading">
        <span class="eyebrow">MÚSICA PARA ACOMPAÑAR TU FE</span>
        <h1>Canta y ora</h1>
        <p>Para Ti es mi música, Señor. <span>(Salmo 100)</span></p>
      </header>

      <section class="search-card" aria-label="Buscar cantos">
        <label for="chant-search">Encuentra un canto</label>
        <div class="search-row">
          <div class="search-input">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            <input id="chant-search" ref="searchInput" v-model="searchQuery" type="search"
              placeholder="Buscar por título o descripción…" autocomplete="off" />
            <button v-if="searchQuery" type="button" aria-label="Limpiar búsqueda" @click="clearSearch">
              <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
          </div>
          <span class="result-count" role="status">
            {{ isLoading ? 'Cargando cantos…' : `${filteredChants.length} ${filteredChants.length === 1 ? 'canto' : 'cantos'}` }}
          </span>
        </div>
      </section>

      <div v-if="isLoading" class="chant-grid" role="status" aria-label="Cargando cantos">
        <div v-for="n in 6" :key="n" class="chant-card animate-pulse" aria-hidden="true">
          <div class="h-12 w-12 rounded-xl bg-slate-200"></div>
          <div class="mt-5 h-5 w-3/4 rounded bg-slate-200"></div>
          <div class="mt-3 h-4 w-full rounded bg-slate-100"></div>
          <div class="mt-6 h-32 rounded-xl bg-slate-100"></div>
        </div>
      </div>
      <div v-else-if="error" class="empty-card" role="alert">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
        <h2>No pudimos cargar los cantos</h2><p>{{ error }}</p>
        <button type="button" @click="fetchChants">Intentar de nuevo</button>
      </div>
      <div v-else-if="!filteredChants.length" class="empty-card">
        <i class="fa-solid fa-music" aria-hidden="true"></i>
        <h2>{{ searchQuery ? 'No encontramos ese canto' : 'Pronto habrá cantos disponibles' }}</h2>
        <p>{{ searchQuery ? 'Prueba con otro título o una palabra de la descripción.' : 'Vuelve más adelante para escuchar y orar.' }}</p>
        <button v-if="searchQuery" type="button" @click="clearSearch">Ver todos los cantos</button>
      </div>
      <div v-else class="chant-grid">
        <article v-for="chant in paginatedChants" :key="chant.id" class="chant-card">
          <div class="chant-heading">
            <span class="music-icon"><i class="fa-solid fa-music" aria-hidden="true"></i></span>
            <span class="chant-badge">Canto para oración</span>
          </div>
          <h2>{{ chant.title }}</h2>
          <div v-if="chant.description" class="chant-description">
            <p :class="{ collapsed: !expandedDescriptions.has(chant.id) }">{{ chant.description }}</p>
            <button v-if="chant.description.length > 120" type="button"
              :aria-expanded="expandedDescriptions.has(chant.id)" @click="toggleExpanded(chant.id)">
              {{ expandedDescriptions.has(chant.id) ? 'Ver menos' : 'Leer descripción' }}
            </button>
          </div>
          <div class="chant-audio">
            <AudioPlayer :src="chant.audio ? '/support/audioChant/' + chant.audio : ''" />
          </div>
        </article>
      </div>

      <nav v-if="!isLoading && !error && totalPages > 1" class="pagination-wrapper" aria-label="Paginación de cantos">
        <button type="button" class="pagination-button" :disabled="currentPage === 1" @click="goToPage(currentPage - 1)">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span>Anterior</span>
        </button>
        <div class="pagination-pages">
          <template v-for="(page, index) in visiblePages" :key="index">
            <span v-if="page === '…'" class="pagination-gap" aria-hidden="true">…</span>
            <button v-else type="button" class="pagination-number" :class="{ active: currentPage === page }"
              :aria-label="`Página ${page}`" :aria-current="currentPage === page ? 'page' : undefined" @click="goToPage(page)">{{ page }}</button>
          </template>
        </div>
        <button type="button" class="pagination-button" :disabled="currentPage === totalPages" @click="goToPage(currentPage + 1)">
          <span>Siguiente</span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
        <p class="pagination-summary" aria-live="polite">Página <strong>{{ currentPage }}</strong> de {{ totalPages }}</p>
      </nav>
    </div>
  </main>
  <Footer />
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import axios from 'axios';
import Header from '../Header.vue';
import Footer from '../Footer.vue';
import AudioPlayer from './AudioPlayer.vue';

const chants = ref([]);
const isLoading = ref(true);
const error = ref('');
const searchInput = ref(null);
const searchQuery = ref('');
const currentPage = ref(1);
const pageSize = 6;
const expandedDescriptions = ref(new Set());
const normalized = value => String(value || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
const filteredChants = computed(() => {
  const query = normalized(searchQuery.value);
  return chants.value.filter(chant => !query || normalized(chant.title).includes(query) || normalized(chant.description).includes(query));
});
const totalPages = computed(() => Math.max(1, Math.ceil(filteredChants.value.length / pageSize)));
const paginatedChants = computed(() => filteredChants.value.slice((currentPage.value - 1) * pageSize, currentPage.value * pageSize));
const visiblePages = computed(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
  if (current <= 4) return [1, 2, 3, 4, 5, '…', total];
  if (current >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
  return [1, '…', current - 1, current, current + 1, '…', total];
});
watch(searchQuery, () => { currentPage.value = 1; });
const goToPage = page => { currentPage.value = Math.max(1, Math.min(page, totalPages.value)); };
const clearSearch = () => { searchQuery.value = ''; searchInput.value?.focus(); };
const toggleExpanded = id => {
  if (expandedDescriptions.value.has(id)) expandedDescriptions.value.delete(id);
  else expandedDescriptions.value.add(id);
};
const fetchChants = async () => {
  isLoading.value = true;
  error.value = '';
  try {
    const { data } = await axios.get('/chants');
    chants.value = data;
    currentPage.value = 1;
  } catch {
    error.value = 'Inténtalo de nuevo en unos momentos.';
  } finally {
    isLoading.value = false;
  }
};
onMounted(fetchChants);
</script>

<style scoped>
.chants-page { padding: 48px 24px 64px; background: var(--public-surface); }
.chants-container { max-width: 1280px; margin: auto; }
.chants-heading { margin-bottom: 32px; }
.eyebrow { font-size: 11px; font-weight: 700; letter-spacing: .12em; color: var(--public-muted); }
.chants-heading h1 { margin: 10px 0; font-size: clamp(32px, 4vw, 48px); font-weight: 800; color: var(--public-heading); }
.chants-heading p { color: var(--public-text); font-size: 15px; }
.chants-heading p span { color: var(--public-muted); font-size: 13px; }
.search-card { padding: 22px; margin-bottom: 28px; background: white; border: 1px solid #e2e8f0; border-radius: 20px; }
.search-card label { display: block; font-size: 13px; font-weight: 600; color: var(--public-heading); margin-bottom: 10px; }
.search-row { display: flex; align-items: center; gap: 20px; }
.search-input { display: flex; align-items: center; flex: 1; min-width: 0; border: 1px solid #cbd5e1; background: var(--public-surface); border-radius: 12px; }
.search-input:focus-within { border-color: var(--public-primary); box-shadow: 0 0 0 3px rgba(var(--public-primary-rgb), .10); }
.search-input > i { margin-left: 16px; color: var(--public-muted); }
.search-input input { width: 100%; min-width: 0; border: 0; background: transparent; padding: 13px 12px; color: var(--public-heading); font-size: 16px; outline: none; box-shadow: none; }
.search-input input::-webkit-search-cancel-button { appearance: none; }
.search-input button { width: 44px; height: 44px; flex-shrink: 0; color: var(--public-muted); }
.result-count { white-space: nowrap; padding: 8px 12px; border-radius: 10px; background: #f1f5f9; color: var(--public-text); font-size: 12px; font-weight: 600; }
.chant-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 22px; }
.chant-card { display: flex; flex-direction: column; min-width: 0; padding: 22px; border: 1px solid #e2e8f0; border-radius: 24px; background: white; box-shadow: 0 4px 16px rgba(var(--public-heading-rgb), .03); }
.chant-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
.music-icon { display: grid; place-items: center; width: 46px; height: 46px; flex-shrink: 0; border-radius: 14px; background: #f1f5f9; color: var(--public-text); font-size: 20px; }
.chant-badge { color: var(--public-muted); font-size: 11px; font-weight: 500; }
.chant-card h2 { color: var(--public-heading); font-size: 20px; line-height: 1.45; font-weight: 700; overflow-wrap: anywhere; }
.chant-description { margin: 12px 0 0; }
.chant-description p { color: var(--public-text); font-size: 13px; line-height: 1.8; overflow-wrap: anywhere; }
.chant-description p.collapsed { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; }
.chant-description button { color: var(--public-primary); font-size: 12px; font-weight: 600; margin-top: 6px; min-height: 32px; }
.chant-audio { margin-top: auto; padding-top: 22px; }
.empty-card { text-align: center; padding: 48px 20px; border-radius: 24px; background: white; border: 1px solid var(--public-border); }
.empty-card > i { font-size: 28px; color: var(--public-primary); }
.empty-card h2 { font-size: 20px; font-weight: 700; margin: 16px 0 8px; color: var(--public-heading); }
.empty-card p { font-size: 14px; color: var(--public-muted); }
.empty-card button { margin-top: 20px; background: var(--public-primary); color: white; padding: 12px 20px; border-radius: 12px; font-weight: 600; font-size: 14px; }
button:focus-visible { outline: 3px solid var(--public-primary); outline-offset: 3px; }
@media (max-width: 1100px) { .chant-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 700px) {
  .chants-page { padding: 28px 16px 48px; }
  .chant-grid { grid-template-columns: minmax(0, 1fr); gap: 18px; }
  .chant-card { padding: 20px; }
  .search-card { padding: 18px; }
  .search-row { flex-wrap: wrap; gap: 12px; }
  .search-input { flex-basis: 100%; }
  .search-input input { font-size: 16px; }
}
.pagination-wrapper {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 12px;
  padding: 24px 0;
}
.pagination-pages { display: flex; align-items: center; gap: 6px; }
.pagination-button, .pagination-number {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 44px;
  border: 1px solid var(--public-soft);
  border-radius: 12px;
  background: white;
  color: var(--public-text);
  font-size: 14px;
  font-weight: 600;
  transition: background .2s, border-color .2s, color .2s;
}
.pagination-button { gap: 10px; padding: 0 16px; }
.pagination-number { min-width: 44px; padding: 0 8px; }
.pagination-button:hover:not(:disabled), .pagination-number:hover:not(.active) {
  background: var(--public-surface);
  border-color: var(--public-border);
  color: var(--public-primary);
}
.pagination-number.active {
  background: var(--public-primary);
  border-color: var(--public-primary);
  color: white;
  box-shadow: 0 4px 10px rgb(37 99 235 / 18%);
}
.pagination-button:disabled { opacity: .4; cursor: not-allowed; }
.pagination-button:focus-visible, .pagination-number:focus-visible {
  outline: 3px solid var(--public-border);
  outline-offset: 3px;
}
.pagination-gap { width: 20px; text-align: center; color: var(--public-primary); }
.pagination-summary { width: 100%; text-align: center; font-size: 13px; color: var(--public-text); }
.pagination-summary strong { color: var(--public-heading); }

@media (max-width: 768px) {
  .pagination-wrapper { gap: 12px; padding: 16px 0; }
  .pagination-pages { order: -1; width: 100%; justify-content: center; gap: 4px; }
  .pagination-number { min-width: 36px; height: 44px; padding: 0 6px; font-size: 13px; }
  .pagination-gap { width: 16px; }
  .pagination-button { flex: 1; max-width: 160px; font-size: 13px; }
}


</style>
