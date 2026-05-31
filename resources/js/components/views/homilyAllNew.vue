<template>

  <Header />

  <div class="homily-page">

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

    <!-- SIDEBAR -->
    <div class="desktop-sidebar">

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
        class="flex justify-center items-center gap-4 py-8">

        <button
          @click="changePage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-4 py-2 border rounded-xl disabled:opacity-50">

          Anterior

        </button>

        <div class="font-semibold text-gray-700">

          Página {{ currentPage }}
          de
          {{ pagination.last_page }}

        </div>

        <button
          @click="changePage(currentPage + 1)"
          :disabled="
            currentPage === pagination.last_page
          "
          class="px-4 py-2 border rounded-xl disabled:opacity-50">

          Siguiente

        </button>

      </div>

    </div>

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

/*
|--------------------------------------------------------------------------
| STATES
|--------------------------------------------------------------------------
*/
const showFiltersMobile = ref(false);

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

    console.log("URL:", "/homiliesNew");
    console.log("PARAMS:", params);
    console.log("sort:", `[${sort}]`);
    console.log(
      "season:",
      `[${selectedSeason.value}]`
    );
    console.log(
      "gospel:",
      `[${selectedGospel.value}]`
    );

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

    console.log("RESPONSE:", data);

    const records = data.data || [];

    pagination.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      total: data.total
    };

    currentPage.value = page;

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

  console.log("ORDEN:", sort);

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
  grid-template-columns: 270px minmax(0, 1fr);
  gap: 26px;
  align-items: start;
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

  box-shadow:
    0 12px 30px rgba(37,99,235,.35);
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

  .homily-page{
    padding: 16px;
  }

  .homily-content{
    gap: 24px;
  }

}

</style>