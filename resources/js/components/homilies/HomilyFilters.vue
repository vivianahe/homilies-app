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

    <div class="sort-wrapper">

      <i class="fa-solid fa-arrow-down-wide-short sort-icon"></i>

      <select
        :value="sortBy"
        class="sort-button"
        @change="changeSort($event.target.value)"
      >

        <option value="recent">
          Más recientes primero
        </option>

        <option value="oldest">
          Más antiguos primero
        </option>

        <option value="title_asc">
          Título A → Z
        </option>

        <option value="title_desc">
          Título Z → A
        </option>

        <option value="domingo">
          Solo domingos
        </option>

      </select>

      <i class="fa-solid fa-chevron-down dropdown-arrow"></i>

    </div>

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

  sortBy: {
    type: String,
    default: "recent",
  },
});

/*
|--------------------------------------------------------------------------
| EMITS
|--------------------------------------------------------------------------
*/

const emit = defineEmits([
  "change-filter",
  "change-sort",
]);

const changeSort = (sort) => {

  emit("change-sort", sort);

};

/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const filters = ref([
  {
    label: "Todas las homilías",
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

.filters-right{
  display: flex;
  align-items: center;
}

.sort-wrapper{
  position: relative;
  display: flex;
  align-items: center;
}

.sort-icon{
  position: absolute;
  left: 16px;

  color: #64748b;

  pointer-events: none;

  z-index: 2;
}

.dropdown-arrow{
  position: absolute;
  right: 16px;

  color: #64748b;

  pointer-events: none;

  z-index: 2;
}

.sort-button{

  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;

  min-width: 260px;

  height: 48px;

  padding-left: 46px;
  padding-right: 42px;

  border-radius: 14px;

  border: 1px solid #dbe2ea;

  background: white;

  font-size: 15px;

  font-weight: 600;

  color: #334155;

  cursor: pointer;

  transition: all 0.2s ease;
}

.sort-button:hover{

  background: #f8fafc;

  border-color: #cbd5e1;
}

.sort-button:focus{

  outline: none;

  border-color: #2563eb;

  box-shadow: 0 0 0 4px rgba(37,99,235,.12);
}

</style>