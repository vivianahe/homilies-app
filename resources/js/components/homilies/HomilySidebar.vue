<template>

  <aside class="homily-sidebar">

    <!-- EVANGELIOS -->
    <div class="sidebar-card">

      <h3 class="sidebar-title">
        Explorar por Evangelio
      </h3>

      <ul class="sidebar-menu">

        <li
          v-for="gospel in gospels"
          :key="gospel.id"
          class="sidebar-item"
        >
          <button class="sidebar-link">

            <i class="fa-solid fa-book-open"></i>

            <span>
              {{ gospel.name }}
            </span>

          </button>
        </li>

      </ul>

    </div>

    <!-- TIEMPO LITÚRGICO -->
    <div class="sidebar-card">

      <h3 class="sidebar-title">
        Tiempo Litúrgico
      </h3>

      <ul class="sidebar-menu">

        <li
          v-for="season in liturgicalSeasons"
          :key="season.id"
          class="sidebar-item"
        >
          <button
            class="sidebar-link"
            :class="{
              active: season.active
            }"
          >

            <i :class="season.icon"></i>

            <span>
              {{ season.name }}
            </span>

          </button>
        </li>

      </ul>

    </div>

    <!-- CALENDARIO -->
    <div class="sidebar-card">

      <h3 class="sidebar-title">
        Ir a una fecha específica
      </h3>

      <Calendar
        :selectedDate="selectedDate"
        @select-date="emitSelectDate"
      />

      <button class="calendar-button">
        Ver homilías de esta fecha
      </button>

    </div>

  </aside>

</template>

<script setup>
import { ref } from "vue";

import Calendar from "../Calendar.vue";

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
});

/*
|--------------------------------------------------------------------------
| EMITS
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
  "select-date",
]);

/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const gospels = ref([
  {
    id: 1,
    name: "Mateo",
  },
  {
    id: 2,
    name: "Marcos",
  },
  {
    id: 3,
    name: "Lucas",
  },
  {
    id: 4,
    name: "Juan",
  },
  {
    id: 5,
    name: "Hechos de los Apóstoles",
  },
  {
    id: 6,
    name: "Cartas de San Pablo",
  },
  {
    id: 7,
    name: "Apocalipsis",
  },
]);

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

  padding: 18px;

  box-shadow:
    0 2px 10px rgba(15, 23, 42, 0.02);
}

.sidebar-title{
  font-size: 16px;

  font-weight: 800;

  color: #0f172a;

  line-height: 1.3;

  margin-bottom: 16px;
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

  margin-top: 16px;

  background: #1d4ed8;

  color: white;

  height: 46px;

  border-radius: 14px;

  font-size: 14px;

  font-weight: 700;

  transition: all 0.2s ease;

  box-shadow:
    0 8px 18px rgba(37, 99, 235, 0.15);
}

.calendar-button:hover{
  transform: translateY(-1px);

  background: #1e40af;
}

:deep(.calendar-container){
  border: none !important;

  padding: 0 !important;

  box-shadow: none !important;
}

:deep(.vc-container){
  width: 100% !important;

  border: none !important;

  background: transparent !important;

  font-family: inherit !important;
}

:deep(.vc-header){
  margin-bottom: 8px;
}

:deep(.vc-title){
  font-size: 15px !important;

  font-weight: 700 !important;

  color: #0f172a !important;
}

:deep(.vc-weekday){
  font-size: 11px !important;

  color: #64748b !important;

  font-weight: 600 !important;
}

:deep(.vc-day-content){
  width: 34px !important;

  height: 34px !important;

  font-size: 13px !important;

  border-radius: 10px !important;
}

:deep(.vc-highlight){
  background: #4f46e5 !important;
}

@media (max-width: 1200px){

  .homily-sidebar{
    position: relative;

    top: 0;
  }

}

</style>