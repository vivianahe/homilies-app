<template>
  <Header />

  <section class="relative py-10 md:py-14 overflow-hidden">
    <!-- Background blurred blobs -->
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
      <div class="absolute -top-40 -right-16 h-96 w-96 rounded-full bg-indigo-400/25 blur-3xl"></div>
      <div class="absolute -bottom-40 -left-20 h-[28rem] w-[28rem] rounded-full bg-slate-600/20 blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[36rem] w-[36rem] rounded-full bg-blue-400/10 blur-[110px]"></div>
    </div>

    <div class="relative w-full mx-auto max-w-screen-xl px-4 sm:px-6">
      <div class="text-center mb-8 md:mb-10">
        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900 drop-shadow-sm">
          Para Ti es mi música Señor (Salmo 100)
        </h2>
        <p class="text-sm md:text-base font-medium text-gray-700/90 mt-2">
          <em>Canta y ora&nbsp;para&nbsp;Dios</em>
        </p>
      </div>

      <!-- Error state -->
      <div v-if="error" class="mb-6 rounded-xl border border-red-200/60 bg-red-50/70 p-4 text-red-800">
        {{ error }}
      </div>

      <!-- Search -->
      <div v-if="!isLoading" class="mb-6">
        <label for="chant-search" class="sr-only">Buscar cantos</label>
        <div class="relative">
          <input
            id="chant-search"
            v-model.trim="searchQuery"
            type="search"
            autocomplete="off"
            placeholder="Buscar por título o descripción..."
            class="w-full rounded-xl border border-slate-200/70 bg-white/70 py-2.5 pl-10 pr-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/60"
          />
          <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">🔎</span>
        </div>
      </div>

      <!-- Loading skeletons -->
      <div v-if="isLoading" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="n in 6" :key="n" class="animate-pulse rounded-2xl border border-white/40 bg-white/60 backdrop-blur-xl p-6 shadow-xl">
          <div class="h-5 w-2/3 bg-slate-200/80 rounded"></div>
          <div class="mt-3 h-4 w-5/6 bg-slate-200/70 rounded"></div>
          <div class="mt-6 h-12 w-full bg-slate-200/60 rounded-lg"></div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else-if="!filteredChants.length" class="mx-auto max-w-xl">
        <div class="rounded-2xl border border-white/40 bg-white/60 backdrop-blur-xl p-8 shadow-xl text-center">
          <div class="mx-auto mb-3 h-10 w-10 rounded-full bg-indigo-500/10 ring-1 ring-indigo-400/30 flex items-center justify-center">
            <span class="text-indigo-600 text-xl">♪</span>
          </div>
          <p class="font-semibold text-gray-800">No se encontraron cantos</p>
          <p class="mt-1 text-gray-600 text-sm">Intenta con otro término de búsqueda.</p>
        </div>
      </div>

      <!-- Content grid -->
      <div v-else class="grid gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="chant in paginatedChants"
          :key="chant.id"
          class="group w-full overflow-hidden rounded-2xl border border-white/40 bg-white/60 backdrop-blur-xl p-4 sm:p-6 shadow-xl transition-transform duration-200 hover:-translate-y-0.5 hover:shadow-2xl"
        >
          <h3 class="font-semibold text-base sm:text-lg text-gray-900 tracking-tight">{{ chant.title }}</h3>
          <div v-if="chant.description" class="mt-2">
            <p class="text-gray-700/90 break-all sm:break-words">
              <em>{{ isExpanded(chant.id) ? chant.description : truncate(chant.description, collapseLimit) }}</em>
            </p>
            <button
              v-if="chant.description && chant.description.length > collapseLimit"
              @click="toggleExpanded(chant.id)"
              class="mt-1 text-indigo-600 hover:text-indigo-700 font-medium text-sm"
              type="button"
            >
              {{ isExpanded(chant.id) ? 'Ver menos' : 'Ver más' }}
            </button>
          </div>
          <audio
            controls
            class="w-full max-w-full rounded-lg shadow-inner bg-white/50 ring-1 ring-inset ring-slate-200/70 mt-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500/60 [&::-webkit-media-controls-panel]:bg-white/60"
          >
            <source :src="'/support/audioChant/' + chant.audio" type="audio/mp3" />
            Tu navegador no soporta la etiqueta de audio.
          </audio>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="mt-6 flex items-center justify-center gap-2 select-none">
        <button
          type="button"
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-slate-200/70 bg-white/70 hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Anterior
        </button>
        <button
          v-for="p in pages"
          :key="p"
          type="button"
          @click="goToPage(p)"
          class="px-3 py-2 rounded-lg text-sm font-semibold ring-1 ring-slate-200/70"
          :class="p === currentPage ? 'bg-indigo-600 text-white ring-indigo-600' : 'bg-white/70 hover:bg-white text-slate-700'"
        >
          {{ p }}
        </button>
        <button
          type="button"
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-3 py-2 rounded-lg text-sm font-medium ring-1 ring-slate-200/70 bg-white/70 hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Siguiente
        </button>
      </div>
    </div>
  </section>

  <Footer />
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import { initFlowbite } from "flowbite";

const chants = ref([]);
const isLoading = ref(true);
const error = ref('');
const expandedDescriptions = ref(new Set());
// límite adaptativo para móviles/desktop
const collapseLimit = computed(() => (window.innerWidth < 640 ? 80 : 180));

// search
const searchQuery = ref('');
const normalized = (s) => (s || '').toString().toLowerCase();
const filteredChants = computed(() => {
  const q = normalized(searchQuery.value);
  if (!q) return chants.value;
  return chants.value.filter((c) =>
    normalized(c.title).includes(q) || normalized(c.description).includes(q)
  );
});

// pagination state
const currentPage = ref(1);
const pageSize = 6;
const totalPages = computed(() => {
  return Math.max(1, Math.ceil(filteredChants.value.length / pageSize));
});
const paginatedChants = computed(() => {
  const start = (currentPage.value - 1) * pageSize;
  return filteredChants.value.slice(start, start + pageSize);
});
const pages = computed(() => Array.from({ length: totalPages.value }, (_, i) => i + 1));
const goToPage = (p) => {
  if (p < 1) p = 1;
  if (p > totalPages.value) p = totalPages.value;
  currentPage.value = p;
};
const nextPage = () => goToPage(currentPage.value + 1);
const prevPage = () => goToPage(currentPage.value - 1);

const isExpanded = (id) => expandedDescriptions.value.has(id);
const toggleExpanded = (id) => {
  const set = expandedDescriptions.value;
  if (set.has(id)) {
    set.delete(id);
  } else {
    set.add(id);
  }
  // force reactivity for Set changes
  expandedDescriptions.value = new Set(set);
};

const truncate = (text, max = 180) => {
  if (!text) return '';
  if (text.length <= max) return text;
  return text.slice(0, max).trimEnd() + '…';
};

const fetchChants = async () => {
  isLoading.value = true;
  error.value = '';
  try {
    const { data } = await axios.get('/chants');
    chants.value = data;
    currentPage.value = 1;
  } catch (e) {
    error.value = 'No se pudieron cargar los cantos. Intenta nuevamente.';
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchChants();
  initFlowbite();
});
</script>


