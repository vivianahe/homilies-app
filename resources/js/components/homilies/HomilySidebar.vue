<template>

  <aside class="homily-sidebar">

    <!-- EVANGELIOS -->
    <div class="sidebar-card">

      <button
        class="accordion-header"
        @click="showGospels = !showGospels"
      >

        <span>
          Explorar por Evangelio
        </span>

        <i
          class="fa-solid"
          :class="
            showGospels
              ? 'fa-chevron-up'
              : 'fa-chevron-down'
          "
        />

      </button>

      <div
        class="accordion-content"
        :class="{
          open: showGospels
        }"
      >

        <ul class="sidebar-menu">

          <li
            v-for="gospel in gospels"
            :key="gospel.id"
            class="sidebar-item"
          >

            <button
              class="sidebar-link"
              :class="{
                active: selectedGospel === gospel.name
              }"
              @click="selectGospel(gospel.name)"
            >

              <i class="fa-solid fa-book-open"></i>

              <span>
                {{ gospel.name }}
              </span>

            </button>
          </li>

        </ul>

      </div>

    </div>

    <!-- TIEMPO LITÚRGICO -->
    <div class="sidebar-card">

      <button
        class="accordion-header"
        @click="showSeasons = !showSeasons"
      >

        <span>
          Tiempo Litúrgico
        </span>

        <i
          class="fa-solid"
          :class="
            showSeasons
              ? 'fa-chevron-up'
              : 'fa-chevron-down'
          "
        />

      </button>

      <div
        class="accordion-content"
        :class="{
          open: showSeasons
        }"
      >

        <ul class="sidebar-menu">

          <li
            v-for="season in liturgicalSeasons"
            :key="season.id"
            class="sidebar-item"
          >
            <button
              class="sidebar-link"
              :class="{
                active: selectedSeason === season.name
              }"
              @click="selectSeason(season.name)"
            >

              <i :class="season.icon"></i>

              <span>
                {{ season.name }}
              </span>

            </button>
          </li>

        </ul>

      </div>

    </div>

    <!-- CALENDARIO -->
    <div class="sidebar-card">

      <button
        class="accordion-header"
        @click="showCalendar = !showCalendar"
      >

        <span>

          {{
            selectedDate
              ? "Fecha seleccionada"
              : "Ir a una fecha específica"
          }}

        </span>

        <i
          class="fa-solid"
          :class="
            showCalendar
              ? 'fa-chevron-up'
              : 'fa-chevron-down'
          "
        />

      </button>

      <div
        class="accordion-content"
        :class="{
          open: showCalendar
        }"
      >

        <Calendar
          class="homily-calendar"
          :selectedDate="selectedDate"
          @select-date="emitSelectDate"
        />

      </div>

    </div>

  </aside>

</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

import Calendar from "../CalendarNew.vue";

/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

defineProps({
  selectedDate: {
    type: String,
    default: "",
  },

  selectedSeason: {
    type: String,
    default: "",
  },

  selectedGospel: {
    type: String,
    default: "",
  }
});

/*
|--------------------------------------------------------------------------
| EMITS
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
  "select-date",
  "select-season",
  "select-gospel"
]);

/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const gospels = ref([]);

const showGospels = ref(false);

const showSeasons = ref(false);

const showCalendar = ref(false);

const selectGospel = (gospel) => {

  emit(
    "select-gospel",
    gospel
  );

};

const getGospels = async () => {

  try {

    const { data } = await axios.get(
      "/gospels"
    );

    gospels.value = data;

  } catch (error) {

    console.error(error);

  }

};

const liturgicalSeasons = ref([
  {
    id: 1,
    name: "Adviento",
    icon: "fa-regular fa-sun",
    active: false,
  },
  {
    id: 2,
    name: "Navidad",
    icon: "fa-regular fa-star",
    active: false,
  },
  {
    id: 3,
    name: "Cuaresma",
    icon: "fa-solid fa-cross",
    active: false,
  },
  {
    id: 4,
    name: "Pascua",
    icon: "fa-solid fa-church",
    active: true,
  },
  {
    id: 5,
    name: "Tiempo Ordinario",
    icon: "fa-regular fa-calendar",
    active: false,
  },
]);


const emitSelectDate = (date) => {

  emit("select-date", date);

};

const selectSeason = (season) => {

  emit("select-season", season);

};

onMounted(() => {

  getGospels();

});

</script>
<style scoped>

.homily-sidebar{
  display: flex;
  flex-direction: column;

  gap: 14px;

  position: sticky;

  top: 18px;
}

.sidebar-card{
  background: #ffffff;

  border: 1px solid #e9edf5;

  border-radius: 20px;

  padding: 20px;

  overflow: hidden;
}

.sidebar-title{
  font-size: 17px;

  font-weight: 800;

  color: #0f172a;

  line-height: 1.3;

  margin-bottom: 20px;

  padding-bottom: 10px;

  border-bottom: 1px solid #eef2f7;
}

.sidebar-menu{
  display: flex;
  flex-direction: column;

  gap: 4px;
}

.sidebar-item{
  list-style: none;
}

.sidebar-link{
  width: 100%;

  display: flex;

  align-items: center;

  gap: 10px;

  padding: 10px 12px;

  border-radius: 12px;

  transition: all 0.18s ease;

  color: #334155;

  font-size: 14px;

  font-weight: 500;

  text-align: left;
}

.sidebar-link:hover{
  background: #f8fafc;
}

.sidebar-link i{
  width: 14px;

  min-width: 14px;

  font-size: 12px;

  color: #475569;
}

.sidebar-link span{
  flex: 1;

  line-height: 1.3;
}

.sidebar-link.active{
  background: #f3f0ff;

  color: #5b21b6;

  font-weight: 700;
}

.sidebar-link.active i{
  color: #7c3aed;
}

.calendar-button{
  width: 100%;

  margin-top: 14px;

  height: 42px;

  border-radius: 12px;

  background: linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
  );

  color: white;

  font-size: 14px;

  font-weight: 700;

  transition: all .2s ease;
}

.calendar-button:hover{
  transform: translateY(-1px);

  box-shadow:
    0 8px 20px rgba(
      37,
      99,
      235,
      .25
    );
}
.calendar-button:hover{
  transform: translateY(-1px);

  background: #1e40af;
}

@media (max-width: 1200px){

  .homily-sidebar{
    position: relative;

    top: 0;
  }

}

.homily-calendar{
  margin-top: 4px;
}

:deep(.fc-toolbar){
  margin-bottom: 18px !important;
}

:deep(.fc-toolbar-title){
  font-size: 18px !important;
  font-weight: 800 !important;
}

:deep(.fc-daygrid-day-number){
  width: 34px;
  height: 34px;
}

:deep(.fc-daygrid-day-frame){
  min-height: 42px !important;
}
.sidebar-card:last-child{
  background: linear-gradient(
    to bottom,
    #ffffff,
    #fafbff
  );
}

.accordion-header{
  width: 100%;

  display: flex;

  align-items: center;

  justify-content: space-between;

  background: transparent;

  font-size: 16px;

  font-weight: 800;

  color: #0f172a;

  padding: 0;

  margin-bottom: 12px;
}

.accordion-content{
  overflow: hidden;

  transition: all .3s ease;
}

@media (max-width: 1200px){

  .accordion-content{
    max-height: 0;

    opacity: 0;
  }

  .accordion-content.open{
    max-height: 1000px;

    opacity: 1;

    margin-top: 12px;
  }

}

@media (min-width: 1201px){

  .accordion-content{
    max-height: none !important;

    opacity: 1 !important;
  }

  .accordion-header i{
    display: none;
  }

}

</style>