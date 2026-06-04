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
          class="w-14 h-14 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto">
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
      <div
        v-if="
          !isDateFilter &&
          activeFilter !== 'recent' &&
          pagination.last_page > 1
        "
        class="pagination-wrapper"
      >

        <button
          @click="changePage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="pagination-button secondary"
        >
          <i class="fa-solid fa-chevron-left"></i>
          <span>Anterior</span>
        </button>

        <div class="pagination-status">

          <span class="pagination-label">
            Página
          </span>

          <!-- AQUÍ VA -->
          <div class="pagination-select-wrapper">

            <select
              v-model="selectedPage"
              class="pagination-select"
              @change="changePage(Number(selectedPage))"
            >

              <option
                v-for="page in pagination.last_page"
                :key="page"
                :value="page"
              >
                {{ page }}
              </option>

            </select>

            <i class="fa-solid fa-chevron-down"></i>

          </div>

          <span class="pagination-separator">
            de
          </span>

          <span class="pagination-total">
            {{ pagination.last_page }}
          </span>

        </div>

        <button
          @click="changePage(currentPage + 1)"
          :disabled="
            currentPage === pagination.last_page
          "
          class="pagination-button primary"
        >
          <span>Siguiente</span>
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
      <BackToTop />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { initFlowbite } from "flowbite";
import Header from "../Header.vue";

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

const selectedPage = ref(1);

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

    const params = {
      page,
      sort: sort?.trim?.() || "recent",
      season: selectedSeason.value?.trim?.() || "",
      gospel: selectedGospel.value?.trim?.() || "",
      date: date || "",
      per_page: perPage
    };

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
    selectedPage.value = page;

    homilies.value = records;

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

  } finally {

    loading.value = false;

  }

};

const handleSelectGospel = (gospel) => {

  selectedGospel.value = gospel;

  getHomilies();

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
    "",
    1,
    sort
  );

};

const handleSelectDate = (date) => {

  selectedDate.value = date;

  isDateFilter.value = true;

  getHomilies(date);

  if (window.innerWidth <= 1200) {
    showFiltersMobile.value = false;
  }

};

const handleSelectSeason = (season) => {

  selectedSeason.value = season;

  currentPage.value = 1;

  getHomilies(
    "",
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
  selectedPage.value = page;

  getHomilies(
    "",
    page,
    sortBy.value
  );

};


onMounted(() => {

  getHomilies();

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
  bottom: 24px;
  right: 24px;

  width: 58px;
  height: 58px;

  border-radius: 999px;

  background: #2563eb;
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

  border-bottom: 1px solid #e5e7eb;
}

.mobile-filters-header h3{
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
}

.mobile-filters-header button{
  width: 36px;
  height: 36px;

  border-radius: 999px;

  border: none;

  background: #f1f5f9;

  color: #475569;
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

  color: #475569;

  border: 1px solid #e2e8f0;

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

.pagination-wrapper{
  display: flex;

  align-items: center;
  justify-content: center;

  gap: 20px;

  margin-top: 10px;
  padding: 24px 0;
}

.pagination-status{
  display: flex;

  align-items: center;

  gap: 10px;

  padding: 12px 18px;

  border-radius: 16px;

  background: white;

  border: 1px solid #e2e8f0;

  box-shadow:
    0 8px 20px rgba(15,23,42,.04);
}

.pagination-label{
  color: #64748b;

  font-size: 14px;
}

.pagination-current{
  width: 34px;
  height: 34px;

  border-radius: 10px;

  background: #2563eb;

  color: white;

  display: flex;
  align-items: center;
  justify-content: center;

  font-weight: 700;
}

.pagination-select{

  height: 34px;

  min-width: 70px;

  padding: 0 12px;

  border: 1px solid #dbe2ea;

  border-radius: 10px;

  background: #2563eb;

  color: white;

  font-weight: 700;

  cursor: pointer;

  outline: none;

  appearance: none;

  text-align: center;
}

.pagination-select:hover{

  background: #1d4ed8;
}

.pagination-select:focus{

  box-shadow:
    0 0 0 4px rgba(37,99,235,.15);
}

.pagination-separator{
  color: #94a3b8;
}

.pagination-total{
  font-weight: 700;

  color: #0f172a;
}

.pagination-button{
  height: 48px;

  padding: 0 20px;

  border-radius: 14px;

  display: flex;

  align-items: center;

  gap: 10px;

  font-weight: 600;

  transition: all .25s ease;
}

.pagination-button:disabled{
  opacity: .45;

  cursor: not-allowed;
}

.pagination-button.primary{
  background: #2563eb;

  color: white;

  box-shadow:
    0 10px 25px rgba(37,99,235,.25);
}

.pagination-button.primary:hover:not(:disabled){
  transform: translateY(-2px);
}

.pagination-button.secondary{
  background: white;

  color: #334155;

  border: 1px solid #e2e8f0;
}

.pagination-button.secondary:hover:not(:disabled){
  background: #f8fafc;
}

.pagination-select-wrapper{
  position: relative;
}

.pagination-select{

  height: 34px;

  min-width: 70px;

  padding: 0 30px 0 12px;

  border: 1px solid #dbe2ea;

  border-radius: 10px;

  background: #2563eb;

  color: white;

  font-weight: 700;

  cursor: pointer;

  appearance: none;

  outline: none;

  text-align: center;
}

.pagination-select-wrapper i{

  position: absolute;

  right: 10px;
  top: 50%;

  transform: translateY(-50%);

  color: white;

  font-size: 10px;

  pointer-events: none;
}

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

@media (max-width: 768px){

  .pagination-wrapper{
    display: flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    width: 100%;

    padding: 8px 0;
  }

  .pagination-status{
    padding: 8px 10px;

    gap: 4px;

    border-radius: 10px;

    min-width: auto;

    flex: 0 0 auto;
  }

  .pagination-label{
    font-size: 12px;
  }

  .pagination-current{
    width: 24px;
    height: 24px;

    border-radius: 7px;

    font-size: 12px;
  }

  .pagination-separator,
  .pagination-total{
    font-size: 12px;
  }

  .pagination-button{
    height: 36px;

    padding: 0 12px;

    border-radius: 10px;

    font-size: 12px;

    gap: 6px;

    flex-shrink: 0;
  }

  .pagination-button i{
    font-size: 10px;
  }

}

/* MÓVIL */
@media (max-width: 768px) {

  .pagination-wrapper {
    margin-bottom: 90px;
  }

  .floating-filter-button {
    bottom: 100px;
    right: 16px;
  }

}

</style>