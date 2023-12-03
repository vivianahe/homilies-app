<script setup>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import { ref } from "vue";

const emit = defineEmits(['date-calendar'])

const handleDateClick = (arg) => {
  emit('date-calendar',arg.dateStr);
};

const calendarOptions = ref({
  plugins: [dayGridPlugin, interactionPlugin],
  locale: "es",
  initialView: "dayGridMonth",
  dateClick: handleDateClick,
  events: [
    { title: "event 1", date: "2019-04-01" },
    { title: "event 2", date: "2019-04-02" },
  ],
});
</script>

<template>
  <div
    class="relative bg-cover bg-no-repeat bg-center"
    style="background-image: url('/img/rectangle.png')"
  >
    <div class="flex items-center justify-center p-4">
      <p class="text-3xl text-custom-text font-semibold text-center mt-5">
        Homilías
      </p>
    </div>
    <div class="mx-auto max-w-3xl p-4 bg-white">
      <FullCalendar :options="calendarOptions" />
    </div>
  </div>
</template>
