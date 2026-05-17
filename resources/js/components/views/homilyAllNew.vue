<template>
  <Header />
  <div class="homily-page">

    <!-- SIDEBAR -->
    <HomilySidebar
      :selectedDate="selectedDate"
      @select-date="handleSelectDate"
    />

    <!-- CONTENIDO -->
    <div class="homily-content">

      <!-- HERO -->
      <HomilyHero
        :homilyData="featuredHomily"
      />

      <!-- FILTROS -->
      <HomilyFilters
        :activeFilter="activeFilter"
        @change-filter="handleFilter"
      />

      <!-- TIMELINE -->
      <HomilyTimeline
        :homilies="displayedHomilies"
      />

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

const homilies = ref([]);

const loading = ref(false);

const activeFilter = ref("all");

const selectedDate = ref("");

/*
|--------------------------------------------------------------------------
| COMPUTED
|--------------------------------------------------------------------------
*/

const featuredHomily = computed(() => {

  return homilies.value.length > 0
    ? homilies.value[0]
    : null;

});

const displayedHomilies = computed(() => {

  if (activeFilter.value === "audio") {

    return homilies.value.filter(
      item => item.audio
    );
  }

  if (activeFilter.value === "popular") {

    return [...homilies.value]
      .sort((a, b) => b.id - a.id)
      .slice(0, 10);
  }

  if (activeFilter.value === "recent") {

    return [...homilies.value]
      .sort(
        (a, b) =>
          new Date(b.date) -
          new Date(a.date)
      );
  }

  if (activeFilter.value === "domingo") {

    return homilies.value.filter(
      item =>
        item.celebration_type === "Domingo"
    );
  }

  return homilies.value;

});


const getHomilies = async (date = "") => {

  try {

    loading.value = true;

    const { data } = await axios.get("/homiliesNew");

    if (date) {

      const selectedHomily = data.find(
        item => item.date === date
      );

      if (selectedHomily) {

        if (selectedHomily.solemnity_id) {

          homilies.value = data.filter(
            item =>
              item.solemnity_id === selectedHomily.solemnity_id
          );

        } else {

          homilies.value = [selectedHomily];

        }

      } else {

        homilies.value = [];

      }

    } else {

      homilies.value = data;

    }

  } catch (error) {

    console.error(error);

  } finally {

    loading.value = false;

  }

};

const handleFilter = (filter) => {

  activeFilter.value = filter;

};

const handleSelectDate = (date) => {

  selectedDate.value = date;

  getHomilies(date);

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