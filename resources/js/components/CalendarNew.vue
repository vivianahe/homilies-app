<script setup>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import esLocale from "@fullcalendar/core/locales/es";
import { ref, computed } from "vue";

const props = defineProps({
  selectedDate: {
    type: String,
    default: ""
  }
});

const emit = defineEmits([
  "select-date"
]);



const handleDateClick = (arg) => {

  emit(
    "select-date",
    arg.dateStr
  );

};

const calendarOptions = computed(() => ({

  plugins: [
    dayGridPlugin,
    interactionPlugin
  ],

  locale: esLocale,

  initialView: "dayGridMonth",

  dateClick: handleDateClick,

  headerToolbar: {
    left: "prev",
    center: "title",
    right: "next"
  },

  events: props.selectedDate
    ? [
        {
          start: props.selectedDate,
          display: "background",
          color: "#4f46e5"
        }
      ]
    : []

}));

</script>

<template>

  <div class="calendar-wrapper">

    <FullCalendar
      :options="calendarOptions"
    />

  </div>

</template>

<style scoped>
.calendar-wrapper{
  width: 100%;
}

/*
|--------------------------------------------------------------------------
| CALENDARIO
|--------------------------------------------------------------------------
*/

:deep(.fc){
  font-size: 12px;
  font-family: inherit;
}

:deep(.fc-toolbar){
  margin-bottom: 12px !important;
}

:deep(.fc-toolbar-title){
  font-size: 17px !important;
  font-weight: 700 !important;
  color: #0f172a;
  text-transform: lowercase;
}

/*
|--------------------------------------------------------------------------
| FLECHAS
|--------------------------------------------------------------------------
*/

:deep(.fc-button){
  width: 30px !important;
  height: 30px !important;

  border-radius: 999px !important;

  background: #f1f5f9 !important;

  border: none !important;

  color: #334155 !important;

  box-shadow: none !important;
}

:deep(.fc-button:hover){
  background: #e2e8f0 !important;
}

:deep(.fc-button-active){
  background: #e2e8f0 !important;
}

/*
|--------------------------------------------------------------------------
| TABLA
|--------------------------------------------------------------------------
*/

:deep(.fc-scrollgrid){
  border: none !important;
}

:deep(.fc-theme-standard td),
:deep(.fc-theme-standard th){
  border: none !important;
}

/*
|--------------------------------------------------------------------------
| DÍAS SEMANA
|--------------------------------------------------------------------------
*/

:deep(.fc-col-header-cell){
  padding-bottom: 6px;
}

:deep(.fc-col-header-cell-cushion){
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  text-transform: lowercase;
  text-decoration: none !important;
}

/*
|--------------------------------------------------------------------------
| DÍAS
|--------------------------------------------------------------------------
*/

:deep(.fc-daygrid-day){
  background: transparent !important;
}

:deep(.fc-daygrid-day-frame){
  min-height: 34px !important;
}

:deep(.fc-daygrid-day-number){
  width: 32px;
  height: 32px;

  display: flex;
  align-items: center;
  justify-content: center;

  margin: auto;

  border-radius: 999px;

  color: #334155;

  font-weight: 500;

  text-decoration: none !important;
}

/*
|--------------------------------------------------------------------------
| HOY
|--------------------------------------------------------------------------
*/

:deep(.fc-day-today){
  background: transparent !important;
}

:deep(.fc-day-today .fc-daygrid-day-number){
  background: #dbeafe;
  color: #2563eb;
  font-weight: 700;
}

/*
|--------------------------------------------------------------------------
| FECHA SELECCIONADA
|--------------------------------------------------------------------------
*/

:deep(.fc-bg-event){
  background: #2563eb !important;
  opacity: .15 !important;
}

:deep(.fc-highlight){
  background: #2563eb !important;
  opacity: .15 !important;
}

:deep(.fc-day-other .fc-daygrid-day-number){
  display: none;
}

</style>