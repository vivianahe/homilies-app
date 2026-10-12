<template>

  <Header />

  <div
    class="homily-page"
    :class="{
      expanded: !showDesktopSidebar
    }"
  >

    <div
      v-if="loading"
      class="fixed inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-50">

      <div class="text-center">

        <div
          class="w-14 h-14 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto">
        </div>

        <p class="mt-4 text-gray-600 font-medium">
          Cargando homilías...
        </p>

      </div>

    </div>

    <!-- BOTÓN FILTROS MOBILE -->
    <button
      class="mobile-filter-button"
      @click="showFiltersMobile = true"
    >

      <i class="fa-solid fa-sliders"></i>

    </button>

    <!-- SIDEBAR DESKTOP -->
    <div
      v-if="showDesktopSidebar"
      class="desktop-sidebar"
    >

      <div class="sidebar-header">

        <button
          class="desktop-filter-toggle"
          @click="showDesktopSidebar = false"
        >
          <i class="fa-solid fa-bars"></i>
        </button>

      </div>

      <HomilySidebar
        :selectedDate="selectedDate"
        :selectedSeason="selectedSeason"
        :selectedGospel="selectedGospel"
        @select-date="handleSelectDate"
        @select-season="handleSelectSeason"
        @select-gospel="handleSelectGospel"
      />

    </div>

    <transition name="fade">

      <div
        v-if="showFiltersMobile"
        class="mobile-filters-overlay"
        @click.self="showFiltersMobile = false"
      >

        <div class="mobile-filters-panel">

          <div class="mobile-filters-header">

            <h3>
              Filtros
            </h3>

            <button
              @click="showFiltersMobile = false"
            >
              <i class="fa-solid fa-xmark"></i>
            </button>

          </div>

          <HomilySidebar
            :selectedDate="selectedDate"
            :selectedSeason="selectedSeason"
            :selectedGospel="selectedGospel"
            @select-date="handleSelectDate"
            @select-season="handleSelectSeason"
            @select-gospel="handleSelectGospel"
          />

        </div>

      </div>

    </transition>

    <!-- CONTENIDO -->
    <div class="homily-content">

      <div
        v-if="!showDesktopSidebar"
        class="content-toolbar"
      >
        <button
          class="desktop-filter-toggle"
          @click="showDesktopSidebar = true"
        >
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>

      <!-- HERO -->
      <HomilyHero
        :homilyData="featuredHomily"
      />

      <!-- FILTROS -->
      <HomilyFilters
        :activeFilter="activeFilter"
        :sortBy="sortBy"
        @change-filter="handleFilter"
        @change-sort="handleSort"
      />

      <!-- TIMELINE -->
      <HomilyTimeline
        :homilies="displayedHomilies"
      />

      <!-- PAGINACIÓN -->
      <nav
        v-if="!isDateFilter && activeFilter !== 'recent' && pagination.last_page > 1"
        class="pagination-wrapper" aria-label="Paginación de homilías"
      >
        <button type="button" class="pagination-button" aria-label="Página anterior"
          :disabled="currentPage === 1 || loading" @click="changePage(currentPage - 1)">
          <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          <span>Anterior</span>
        </button>

        <div class="pagination-pages">
          <template v-for="(page, index) in visiblePages" :key="index">
            <span v-if="page === '…'" class="pagination-gap" aria-hidden="true">…</span>
            <button v-else type="button" class="pagination-number"
              :class="{ active: page === currentPage }"
              :aria-label="`Página ${page}`" :aria-current="page === currentPage ? 'page' : undefined"
              :disabled="loading" @click="changePage(page)">
              {{ page }}
            </button>
          </template>
        </div>

        <button type="button" class="pagination-button" aria-label="Página siguiente"
          :disabled="currentPage === pagination.last_page || loading" @click="changePage(currentPage + 1)">
          <span>Siguiente</span>
          <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </button>
        <p class="pagination-summary" aria-live="polite">
          Página <strong>{{ currentPage }}</strong> de {{ pagination.last_page }}
        </p>
      </nav>
    </div>
      <BackToTop />
    </div>
    <Footer />
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { initFlowbite } from "flowbite";
import Header from "../Header.vue";
import Footer from "../Footer.vue";

/*
|--------------------------------------------------------------------------
| COMPONENTES
|--------------------------------------------------------------------------
*/

import HomilySidebar from "../homilies/HomilySidebar.vue";
import HomilyHero from "../homilies/HomilyHero.vue";
import HomilyFilters from "../homilies/HomilyFilters.vue";
import HomilyTimeline from "../homilies/HomilyTimeline.vue";
import BackToTop from "../homilies/BackToTop.vue";

/*
|--------------------------------------------------------------------------
| STATES
|--------------------------------------------------------------------------
*/
const showFiltersMobile = ref(false);

const showDesktopSidebar = ref(true);

const homilies = ref([]);

const loading = ref(false);

const activeFilter = ref("all");

const selectedDate = ref("");

const selectedSeason = ref("");

const selectedGospel = ref("");

const sortBy = ref("recent");

const currentPage = ref(1);


const isDateFilter = ref(false);

const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0
});

/*
|--------------------------------------------------------------------------
| COMPUTED
|--------------------------------------------------------------------------
*/

const visiblePages = computed(() => {
  const total = pagination.value.last_page;
  const current = currentPage.value;
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
  if (current <= 4) return [1, 2, 3, 4, 5, '…', total];
  if (current >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
  return [1, '…', current - 1, current, current + 1, '…', total];
});

const featuredHomily = computed(() => {

  return displayedHomilies.value.length > 0
    ? displayedHomilies.value[0]
    : null;

});

const displayedHomilies = computed(() => {

  return homilies.value;

});


const getHomilies = async (
  date = "",
  page = 1,
  sort = sortBy.value,
  perPage = 10
) => {

  try {

    loading.value = true;

    const { data } = await axios.get(
      "/homiliesNew",
      {
        params: {
          page: Number(page),

          sort: String(sort || "")
            .trim(),

          season: String(
            selectedSeason.value || ""
          ).trim(),

          gospel: String(
            selectedGospel.value || ""
          ).trim(),

          date: date || "",

          per_page: Number(perPage)
        }
      }
    );

    const records = data.data || [];

    pagination.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      total: data.total
    };

    currentPage.value = page;

    homilies.value = records;

    return records;
  } catch (error) {

    console.error(
      "ERROR GET HOMILIES:",
      error
    );

    if (error.response) {

      console.error(
        "RESPONSE:",
        error.response.data
      );

    }

    return [];
  } finally {

    loading.value = false;

  }

};

const cargarUltimaHomiliaDisponible = async () => {

  const hoy = new Date();

  let fechaBusqueda = new Date(
    hoy.getFullYear(),
    hoy.getMonth(),
    hoy.getDate()
  );

  for (let i = 0; i < 3650; i++) {

    const year = fechaBusqueda.getFullYear();

    const month = String(
      fechaBusqueda.getMonth() + 1
    ).padStart(2, "0");

    const day = String(
      fechaBusqueda.getDate()
    ).padStart(2, "0");

    const fecha = `${year}-${month}-${day}`;
    const records = await getHomilies(
      fecha,
      1,
      "recent",
      10
    );

    if (records.length > 0) {
      selectedDate.value = fecha;
      isDateFilter.value = true;
      return;
    }

    fechaBusqueda.setDate(
      fechaBusqueda.getDate() - 1
    );
  }
  homilies.value = [];
};

const handleSelectGospel = (gospel) => {

  selectedGospel.value = gospel;

  getHomilies(

      selectedDate.value,

      1,

      sortBy.value,

      activeFilter.value === "recent"
          ? 5
          : 10

  );

  if (window.innerWidth <= 1200) {
    showFiltersMobile.value = false;
  }

};

const handleFilter = (filter) => {

  activeFilter.value = filter;

  currentPage.value = 1;

  /*
  |--------------------------------------------------------------------------
  | TODAS LAS HOMILÍAS
  |--------------------------------------------------------------------------
  */

  if (filter === "all") {

      selectedDate.value = "";

      isDateFilter.value = false;

      sortBy.value = "recent";

      getHomilies(
          "",
          1,
          "recent"
      );

      return;

  }

  /*
  |--------------------------------------------------------------------------
  | RECIENTES
  |--------------------------------------------------------------------------
  */

  if (filter === "recent") {

    sortBy.value = "recent";

    getHomilies(
      "",
      1,
      "recent",
      5
    );

    return;

  }

};

const handleSort = (sort) => {

  sortBy.value = sort;

  currentPage.value = 1;

  getHomilies(
    selectedDate.value,
    1,
    sort
  );

};

const handleSelectDate = (date) => {

  selectedDate.value = date;

  isDateFilter.value = true;

  getHomilies(
      date,
      1,
      sortBy.value,
      activeFilter.value === "recent"
          ? 5
          : 10
  );

  if (window.innerWidth <= 1200) {
    showFiltersMobile.value = false;
  }

};

const handleSelectSeason = (season) => {

  selectedSeason.value = season;

  currentPage.value = 1;

  getHomilies(
    selectedDate.value,
    1,
    sortBy.value,
    activeFilter.value === "recent"
      ? 5
      : 10
  );

  if (window.innerWidth <= 1200) {
    showFiltersMobile.value = false;
  }

};

const changePage = (page) => {

  if (
    page < 1 ||
    page > pagination.value.last_page
  ) {
    return;
  }

  currentPage.value = page;

  getHomilies(
    selectedDate.value,
    page,
    sortBy.value
  );

};


onMounted(async () => {

  isDateFilter.value = true;

  await cargarUltimaHomiliaDisponible();

  initFlowbite();

});
</script>

<style scoped>

.homily-page{
  width: 100%;
  max-width: 100%;
  margin: 0 auto;

  padding: 32px 42px;

  display: grid;

  grid-template-columns:
    270px minmax(0,1fr);

  gap: 26px;

  align-items: start;

  transition: all .3s ease;
}

.homily-page.expanded{
  grid-template-columns:
    minmax(0,1fr);
}

.homily-content{
  width: 100%;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 36px;
}

.mobile-filter-button{
  display: none;

  position: fixed;
  bottom: 92px;
  right: 24px;

  width: 58px;
  height: 58px;

  border-radius: 999px;

  background: var(--public-primary);
  color: white;

  border: none;

  z-index: 50;
}

.mobile-filters-overlay{
  position: fixed;

  inset: 0;

  background: rgba(0,0,0,.45);

  z-index: 999;
}

.mobile-filters-panel{
  position: absolute;

  left: 0;

  top: 0;

  width: 280px;

  max-width: 82vw;

  height: 100%;

  background: white;

  overflow-y: auto;

  padding: 20px;

  box-shadow: 0 20px 60px rgba(0,0,0,.15);

}

.mobile-filters-header{
  display: flex;
  justify-content: space-between;
  align-items: center;

  padding-bottom: 16px;

  margin-bottom: 20px;

  border-bottom: 1px solid var(--public-soft);
}

.mobile-filters-header h3{
  font-size: 20px;
  font-weight: 700;
  color: var(--public-heading);
}

.mobile-filters-header button{
  width: 36px;
  height: 36px;

  border-radius: 999px;

  border: none;

  background: var(--public-surface);

  color: var(--public-text);
}
.fade-enter-active,
.fade-leave-active{
  transition: all .25s ease;
}

.fade-enter-from,
.fade-leave-to{
  opacity: 0;
}

.fade-enter-from .mobile-filters-panel,
.fade-leave-to .mobile-filters-panel{
  transform: translateX(-100%);
}

.mobile-filters-panel{
  transition: transform .25s ease;
}

.desktop-sidebar{
  width: 270px;
}

.sidebar-header{
  display: flex;
  justify-content: flex-start;
  margin-bottom: 12px;
}

.content-toolbar{
  display: flex;
  align-items: center;
  margin-bottom: 28px;
}

.desktop-filter-toggle{
  width: 40px;
  height: 40px;

  flex-shrink: 0;

  cursor: pointer;

  border-radius: 10px;

  background: #ffffff;

  color: var(--public-text);

  border: 1px solid var(--public-soft);

  display: flex;
  align-items: center;
  justify-content: center;

  transition: all .25s ease;
}

.desktop-filter-toggle:hover{
  transform: translateY(-2px);
}

.desktop-filter-toggle:hover{
  transform: translateY(-2px);
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

@media (max-width: 1600px){

  .homily-page{
    padding: 28px 32px;
  }

}

@media (max-width: 1400px){

  .homily-page{
    grid-template-columns: 260px minmax(0, 1fr);

    gap: 28px;

    padding: 24px;
  }

}

@media (max-width: 1200px){

  .desktop-filter-toggle{
    display: none;
  }

  .homily-page{
    grid-template-columns: 1fr;
  }

  .desktop-sidebar{
    display: none;
  }

  .mobile-filter-button{
    display: flex;
    align-items: center;
    justify-content: center;
  }

}

@media (max-width: 768px) {
  .pagination-wrapper { gap: 12px; padding: 16px 0; }
  .pagination-pages { order: -1; width: 100%; justify-content: center; gap: 4px; }
  .pagination-number { min-width: 36px; height: 44px; padding: 0 6px; font-size: 13px; }
  .pagination-gap { width: 16px; }
  .pagination-button { flex: 1; max-width: 160px; font-size: 13px; }
}

/* MÓVIL */
@media (max-width: 768px) {

  .pagination-wrapper {
    margin-bottom: 90px;
  }

  .mobile-filter-button {
    bottom: 76px;
    right: 16px;
    width: 48px;
    height: 48px;
  }

}

</style>