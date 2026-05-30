<template>

  <div class="homily-filters">

    <!-- LEFT -->
    <div class="filters-left">

      <button
        v-for="filter in filters"
        :key="filter.value"
        class="filter-button"
        :class="{
          active: activeFilter === filter.value
        }"
        @click="changeFilter(filter.value)"
      >

        <i :class="filter.icon"></i>

        <span>
          {{ filter.label }}
        </span>

      </button>

    </div>

    <!-- RIGHT -->
    <div class="filters-right">

      <button class="sort-button">

        <span>
          Más recientes primero
        </span>

        <i class="fa-solid fa-chevron-down"></i>

      </button>

    </div>

  </div>

</template>

<script setup>
import { ref } from "vue";

/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

defineProps({
  activeFilter: {
    type: String,
    default: "all",
  },
});

/*
|--------------------------------------------------------------------------
| EMITS
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
  "change-filter",
]);

/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const filters = ref([
  {
    label: "Todas",
    value: "all",
    icon: "fa-solid fa-layer-group",
  },
  {
    label: "Recientes",
    value: "recent",
    icon: "fa-solid fa-clock",
  },
]);

/*
|--------------------------------------------------------------------------
| METHODS
|--------------------------------------------------------------------------
*/

const changeFilter = (filter) => {

  emit("change-filter", filter);

};
</script>

<style scoped>

.homily-filters{
  display: flex;

  justify-content: space-between;

  align-items: center;

  gap: 20px;

  flex-wrap: wrap;
}

/*
|--------------------------------------------------------------------------
| LEFT
|--------------------------------------------------------------------------
*/

.filters-left{
  display: flex;

  align-items: center;

  gap: 14px;

  flex-wrap: wrap;
}

/*
|--------------------------------------------------------------------------
| BUTTONS
|--------------------------------------------------------------------------
*/

.filter-button{
  height: 48px;

  padding: 0 22px;

  border-radius: 14px;

  border: 1px solid #dbe2ea;

  background: white;

  display: flex;

  align-items: center;

  gap: 10px;

  font-size: 15px;

  font-weight: 600;

  color: #334155;

  transition: all 0.2s ease;
}

.filter-button:hover{
  border-color: #c7d2fe;

  background: #f8fafc;
}

.filter-button.active{
  background: #1d4ed8;

  border-color: #1d4ed8;

  color: white;

  box-shadow: 0 10px 24px rgba(29, 78, 216, 0.15);
}

/*
|--------------------------------------------------------------------------
| SORT
|--------------------------------------------------------------------------
*/

.sort-button{
  height: 48px;

  padding: 0 18px;

  border-radius: 14px;

  border: 1px solid #dbe2ea;

  background: white;

  display: flex;

  align-items: center;

  gap: 12px;

  font-size: 15px;

  font-weight: 600;

  color: #334155;

  transition: all 0.2s ease;
}

.sort-button:hover{
  background: #f8fafc;
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media (max-width: 768px){

  .homily-filters{
    flex-direction: column;

    align-items: stretch;
  }

  .filters-left{
    width: 100%;
  }

  .filter-button{
    flex: 1;

    justify-content: center;
  }

  .sort-button{
    width: 100%;

    justify-content: center;
  }

}

</style>