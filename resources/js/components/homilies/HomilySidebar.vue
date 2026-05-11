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

/*
|--------------------------------------------------------------------------
| METHODS
|--------------------------------------------------------------------------
*/

const emitSelectDate = (date) => {

  emit("select-date", date);

};
</script>

<style scoped>

.homily-sidebar{
  display: flex;
  flex-direction: column;

  gap: 24px;

  position: sticky;

  top: 20px;
}

/*
|--------------------------------------------------------------------------
| CARD
|--------------------------------------------------------------------------
*/

.sidebar-card{
  background: #ffffff;

  border: 1px solid #e5e7eb;

  border-radius: 24px;

  padding: 24px;
}

/*
|--------------------------------------------------------------------------
| TITLE
|--------------------------------------------------------------------------
*/

.sidebar-title{
  font-size: 20px;

  font-weight: 800;

  color: #0f172a;

  margin-bottom: 22px;
}

/*
|--------------------------------------------------------------------------
| MENU
|--------------------------------------------------------------------------
*/

.sidebar-menu{
  display: flex;
  flex-direction: column;

  gap: 10px;
}

.sidebar-item{
  list-style: none;
}

/*
|--------------------------------------------------------------------------
| LINK
|--------------------------------------------------------------------------
*/

.sidebar-link{
  width: 100%;

  display: flex;

  align-items: flex-start;

  gap: 14px;

  padding: 14px 16px;

  border-radius: 14px;

  transition: all 0.2s ease;

  color: #334155;

  font-size: 15px;

  font-weight: 500;

  text-align: left;
}

.sidebar-link:hover{
  background: #f8fafc;

  transform: translateX(2px);
}

/*
|--------------------------------------------------------------------------
| ICON
|--------------------------------------------------------------------------
*/

.sidebar-link i{
  width: 18px;

  min-width: 18px;

  margin-top: 3px;

  font-size: 14px;
}

/*
|--------------------------------------------------------------------------
| TEXT
|--------------------------------------------------------------------------
*/

.sidebar-link span{
  flex: 1;

  line-height: 1.45;

  word-break: break-word;
}

/*
|--------------------------------------------------------------------------
| ACTIVE
|--------------------------------------------------------------------------
*/

.sidebar-link.active{
  background: #eef2ff;

  color: #4f46e5;

  font-weight: 700;
}

/*
|--------------------------------------------------------------------------
| BUTTON
|--------------------------------------------------------------------------
*/

.calendar-button{
  width: 100%;

  margin-top: 20px;

  background: #1d4ed8;

  color: white;

  padding: 15px 18px;

  border-radius: 16px;

  font-weight: 700;

  transition: all 0.2s ease;
}

.calendar-button:hover{
  opacity: 0.92;

  transform: translateY(-1px);
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 1200px){

  .homily-sidebar{
    position: relative;

    top: 0;
  }

}

</style>