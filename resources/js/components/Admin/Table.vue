<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div
      v-if="busqueda"
      class="bg-gradient-to-r from-gray-900 to-gray-800 p-5 rounded-t-lg"
    >

      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>

        <label class="block text-sm text-white font-semibold mb-2">
          {{ props.filterLabels.search }}
        </label>

          <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>

            <input
              type="text"
              v-model="searchTerm"
              :placeholder="props.filterLabels.searchPlaceholder"
              class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-600 bg-gray-700 text-white placeholder-gray-400 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
            />
          </div>
        </div>

        <div v-if="props.showDateFilters">
          <label class="block text-sm text-white font-semibold mb-2">
            Fecha Inicial
          </label>

          <input
            type="date"
            v-model="startDate"
            class="w-full px-4 py-2 rounded-xl border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
          />
        </div>

        <div v-if="props.showDateFilters">
          <label class="block text-sm text-white font-semibold mb-2">
            Fecha Final
          </label>

          <input
            type="date"
            v-model="endDate"
            class="w-full px-4 py-2 rounded-xl border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
          />
        </div>
        <div>
          <label class="block text-sm text-white font-semibold mb-2">
            {{ props.filterLabels.citation }}
          </label>

          <input
            type="text"
            v-model="citationFilter"
            :placeholder="props.filterLabels.citationPlaceholder"
            class="w-full px-4 py-2 rounded-xl border border-gray-600 bg-gray-700 text-white placeholder-gray-400 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
          />
        </div>

      </div>

      <div class="flex justify-end mt-4">
        <button
          @click="limpiarFiltros"
          class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-xl transition"
        >
          <i class="fa-solid fa-rotate-left mr-2"></i>
          Limpiar filtros
        </button>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto text-sm text-left text-gray-300">
        <thead class="text-sm uppercase bg-gray-700">
          <tr>
            <th class="px-4 py-3 w-12 text-center">#</th>

            <th
              v-for="column in columns"
              :key="column.key"
              scope="col"
              class="px-6 py-3"
            >
              {{ column.label }}
            </th>
          </tr>
        </thead>
        <tbody class="text-gray-700">

          <tr
            v-for="(dataHomi, index) in visibleData"
            :key="dataHomi.id"
            class="bg-white border border-b-gray-200 hover:bg-gray-50"
          >

            <td class="px-4 py-4 text-center text-sm font-semibold text-gray-500 w-12">
              {{ startIndex + index + 1 }}
            </td>

            <td
              v-for="column in columns"
              :key="column.key"
              class="px-4 py-4"
            >

              <template v-if="column.key === 'options'">

                <div class="py-1 flex items-center gap-2 flex-wrap">

                  <button
                    type="button"
                    @click="$emit('datelle', dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-md transition"
                  >
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Ver detalle
                  </button>

                  <button
                    type="button"
                    @click="$emit('editar', dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-md transition"
                  >
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Editar
                  </button>

                  <button
                    v-if="props.mostrarDescarga"
                    type="button"
                    @click="confirmarDescarga(dataHomi)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 rounded-md transition"
                  >
                    <i class="fa-solid fa-download mr-1"></i>
                    Audio
                  </button>

                  <button
                    type="button"
                    @click="confirmarEliminar(dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md transition"
                  >
                    <i class="fa-solid fa-trash-can mr-1"></i>
                    Eliminar
                  </button>
                </div>
              </template>
              <template v-else>
                {{ dataHomi[column.key] }}
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <nav
      class="flex items-center justify-between mt-5 p-4"
      aria-label="Table navigation"
    >

<div class="flex items-center gap-4 flex-wrap">

  <span class="text-md font-normal">
    Mostrando
    <span class="font-semibold text-gray-900">
      {{ startIndex + 1 }}-{{ endIndex > totalItems ? totalItems : endIndex }}
    </span>
    de
    <span class="font-semibold text-gray-900">
      {{ totalItems }}
    </span>
  </span>

    <div class="flex items-center gap-2">

        <span class="text-sm text-gray-600">
          Ver
        </span>

        <select
          v-model="itemsPerPage"
          class="border border-gray-300 rounded-lg px-3 py-1.5 bg-white text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"
        >
          <option :value="10">10</option>
          <option :value="30">30</option>
          <option :value="60">60</option>
          <option :value="100">100</option>
        </select>

        <span class="text-sm text-gray-600">
          registros
        </span>

      </div>

    </div>
      <ul class="flex items-center gap-1 text-sm">
        <li>
          <a
            href="#"
            class="min-w-[40px] h-10 flex items-center justify-center rounded-xl bg-gray-200 hover:bg-gray-300 transition-all"

            :class="{ 
              'opacity-50 cursor-not-allowed': !canGoToPreviousPage 
            }"

            @click.prevent="goToPreviousPage"
          >
            <i class="fa-solid fa-chevron-left text-sm"></i>
          </a>
        </li>
        <li v-for="(page, index) in visiblePages" :key="index">

          <span v-if="page === '...'" class="px-2 text-gray-400">
            ...
          </span>

          <a
            v-else
            href="#"
            class="min-w-[40px] h-10 flex items-center justify-center px-3 rounded-xl font-semibold transition-all duration-200 shadow-sm"

            :class="page === currentPage
              ? 'bg-sky-500 text-white shadow-lg scale-105 ring-2 ring-sky-300'
              : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white'"
              
            @click.prevent="currentPage = page"
          >
            {{ page }}
          </a>
        </li>
        <li>
          <a
            href="#"
            class="min-w-[40px] h-10 flex items-center justify-center rounded-xl bg-gray-200 hover:bg-gray-300 transition-all"

            :class="{ 
              'opacity-50 cursor-not-allowed': !canGoToNextPage 
            }"

            @click.prevent="goToNextPage"
          >
            <i class="fa-solid fa-chevron-right text-sm"></i>
          </a>  
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  dataHomilies: Array,
  columns: Array,
  busqueda: {
    type: Boolean,
    default: true
  },

  mostrarDescarga: {
    type: Boolean,
    default: true
  },

  filterFields: {
    type: Array,
    default: () => ['title', 'reading']
  },

  filterDateField: {
    type: String,
    default: 'date'
  },

  showDateFilters: {
    type: Boolean,
    default: true
  },

  filterLabels: {
    type: Object,
    default: () => ({
      search: 'Buscar',
      citation: 'Cita Bíblica',
      searchPlaceholder: 'Título o lectura...',
      citationPlaceholder: 'Ej: Juan 16'
    })
  }
});

const currentPage = ref(1);
const itemsPerPage = ref(10);

const emit = defineEmits([
  "editar",
  "datelle",
  "eliminar",
  "descargar"
]);


const searchTerm = ref('');
const startDate = ref('');
const endDate = ref('');
const citationFilter = ref('');

const filteredData = computed(() => {

  return props.dataHomilies.filter((item) => {

    const matchesSearch =
      !searchTerm.value ||
      props.filterFields.some(field =>
        item[field]
          ?.toLowerCase()
          .includes(searchTerm.value.toLowerCase())
      );

      const matchesCitation =
        !citationFilter.value ||
        (
          item.audio ||
          item.citation ||
          ''
        )
          .toLowerCase()
          .includes(citationFilter.value.toLowerCase());

      let matchesStartDate = true;
      let matchesEndDate = true;

      if (props.showDateFilters) {

        const itemDate = item.date
          ? new Date(item.date)
          : null;

        matchesStartDate =
          !startDate.value ||
          (
            itemDate &&
            itemDate >= new Date(startDate.value)
          );

        matchesEndDate =
          !endDate.value ||
          (
            itemDate &&
            itemDate <= new Date(endDate.value)
          );
      }

    return (
      matchesSearch &&
      matchesCitation &&
      matchesStartDate &&
      matchesEndDate
    );

  });

});

const totalItems = computed(() => filteredData.value.length);

const startIndex = computed(() =>
  (currentPage.value - 1) * itemsPerPage.value
);

const endIndex = computed(() =>
  Math.min(startIndex.value + itemsPerPage.value, totalItems.value)
);

const visibleData = computed(() => {

  return filteredData.value.slice(
    startIndex.value,
    startIndex.value + itemsPerPage.value
  );

});

const canGoToPreviousPage = computed(() =>
  currentPage.value > 1
);

const canGoToNextPage = computed(() =>
  endIndex.value < totalItems.value
);

const totalPages = computed(() =>
  Math.ceil(totalItems.value / itemsPerPage.value)
);

const visiblePages = computed(() => {
  const pages = [];
  const current = currentPage.value;
  const total = totalPages.value;

  const delta = 2;

  let start = Math.max(2, current - delta);
  let end = Math.min(total - 1, current + delta);

  pages.push(1);

  if (start > 2) {
    pages.push('...');
  }

  for (let i = start; i <= end; i++) {
    pages.push(i);
  }

  if (end < total - 1) {
    pages.push('...');
  }

  if (total > 1) {
    pages.push(total);
  }

  return pages;
});

const goToPreviousPage = () => {
  if (canGoToPreviousPage.value) {
    currentPage.value--;
  }
};

const goToNextPage = () => {
  if (canGoToNextPage.value) {
    currentPage.value++;
  }
};

const limpiarFiltros = () => {
  searchTerm.value = '';
  startDate.value = '';
  endDate.value = '';
  citationFilter.value = '';
};

watch(
  [searchTerm, startDate, endDate, citationFilter],
  () => {
    currentPage.value = 1;
  }
);

watch(itemsPerPage, () => {
  currentPage.value = 1;
});

const confirmarEliminar = (id) => {
  Swal.fire({
    title: '¿Seguro?',
    text: "No podrás revertirlo.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, bórralo!',
    cancelButtonText: 'Cancelar',
    buttonsStyling: false,
    customClass: {
      actions: 'flex items-center justify-end gap-2 mt-4',
      confirmButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600',
      cancelButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200'
    },
    background: '#ffffff'
  }).then((result) => {
    if (result.isConfirmed) {
      emit('eliminar', id);
    }

  });

};

const confirmarDescarga = (dataHomi) => {
  Swal.fire({
    title: '¿Descargar audio?',
    text: `Se descargará el audio: ${dataHomi.title}`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, descargar',
    cancelButtonText: 'Cancelar',
    buttonsStyling: false,
    customClass: {
      actions: 'flex items-center justify-end gap-2 mt-4',
      confirmButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600',
      cancelButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200'
    },
    background: '#ffffff'
  }).then((result) => {
    if (result.isConfirmed) {
      emit('descargar', dataHomi);
    }
  });
};
</script>
