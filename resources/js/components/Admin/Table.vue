<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="py-6 px-4 bg-gray-900 w-full" v-if="busqueda">
      <label for="table-search" class="sr-only">Buscar</label>
      <div class="relative mt-1">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="text" id="table-search"
          class="block p-2 pl-10 text-sm border rounded-lg w-80 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="Buscar" v-model="searchTerm" />
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto text-sm text-left text-gray-300">
        <thead class="text-sm uppercase bg-gray-700">
          <tr>
            <th class="px-4 py-3 w-12 text-center">#</th>
            <th v-for="column in columns" :key="column.key" scope="col" class="px-6 py-3">
              {{ column.label }}
            </th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr v-for="(dataHomi, index) in visibleData" :key="dataHomi.id"
            class="bg-white hover-bg-gray-200 border border-b-gray-200">

            <td class="px-4 py-4 text-center text-sm font-semibold text-gray-500 w-12">
              {{ startIndex + index + 1 }}
            </td>
            
            <td v-for="column in columns" :key="column.key" class="px-4 py-4">
              <template v-if="column.key === 'options'">
                
                <div class="py-1 flex items-center gap-2 flex-wrap">

                  <button type="button"
                    @click="$emit('datelle', dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-md transition">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Ver detalle
                  </button>

                  <button type="button"
                    @click="$emit('editar', dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-md transition">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Editar
                  </button>

                  <button type="button"
                    @click="confirmarDescarga(dataHomi)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 rounded-md transition">
                    <i class="fa-solid fa-download mr-1"></i>
                    Audio
                  </button>

                  <button type="button"
                    @click="confirmarEliminar(dataHomi.id)"
                    class="flex items-center text-white text-xs px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md transition">
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

    <nav class="flex items-center justify-between mt-5 p-4" aria-label="Table navigation">
      <span class="text-md font-normal">
        Mostrando
        <span class="font-semibold text-gray-900">{{ startIndex + 1 }}-{{ endIndex > totalItems ?
          totalItems : endIndex }}</span>
        de
        <span class="font-semibold text-gray-900">{{ totalItems }}</span>
      </span>
      <ul class="flex items-center gap-1 text-sm">
        <li>
          <a href="#"
            class="px-3 py-1.5 bg-gray-200 rounded-md hover:bg-gray-300"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoToPreviousPage }"
            @click.prevent="goToPreviousPage">
            ←
          </a>
        </li>
        <li v-for="(page, index) in visiblePages" :key="index">
          <span v-if="page === '...'" class="px-2 text-gray-400">...</span>
          <a v-else href="#"
            class="px-3 py-1.5 rounded-md bg-gray-800 text-gray-300 hover:text-white"
            :class="{ 'bg-blue-600 text-white': page === currentPage }"
            @click.prevent="currentPage = page">
            {{ page }}
          </a>
        </li>
        <li>
          <a href="#"
            class="px-3 py-1.5 bg-gray-200 rounded-md hover:bg-gray-300"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoToNextPage }"
            @click.prevent="goToNextPage">
            →
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
  }
});

const currentPage = ref(1);
const emit = defineEmits(["editar", "datelle", "eliminar", "descargar"]);
const itemsPerPage = 10;

const searchTerm = ref('');

const totalItems = computed(() => {
  const filteredData = searchTerm.value
    ? performSearch()
    : props.dataHomilies;
  return filteredData.length;
});

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage);
const endIndex = computed(() => Math.min(startIndex.value + itemsPerPage, totalItems.value));

const visibleData = computed(() => {
  const filteredData = searchTerm.value
    ? performSearch()
    : props.dataHomilies;
  return filteredData.slice(startIndex.value, endIndex.value);
});

const canGoToPreviousPage = computed(() => currentPage.value > 1);
const canGoToNextPage = computed(() => endIndex.value < totalItems.value);

const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

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

const performSearch = (includeDate) => {
  if (props.dataHomilies && props.dataHomilies.length > 0) {
    return props.dataHomilies.filter((homily) => {
      if (homily && homily.title && homily.citation && homily.reading) {
        const matchesTitle = homily.title.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesCitation = homily.citation.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesReading = homily.reading.toLowerCase().includes(searchTerm.value.toLowerCase());
        
        return matchesTitle || matchesCitation || matchesReading;
      } else {
        // Manejar casos en los que falta una propiedad en el objeto homily
        return false;
      }
    });
  }
};

watch(searchTerm, () => {
  currentPage.value = 1; 
});

const confirmarEliminar = (id) => {
  Swal.fire({
    title: '¿Seguro?',
    text: "No podrás revertirlo.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, bórralo!',
    cancelButtonText: 'Cancelar',
    buttonsStyling: false,
    customClass: {
      actions: 'flex items-center justify-end gap-2 mt-4',
      confirmButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
      cancelButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300'
    },
    background: '#ffffff'
  }).then((result) => {
    if (result.isConfirmed) {
      emit('eliminar', id);
    }
  })
}
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
      confirmButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500',
      cancelButton: 'inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300'
    },
    background: '#ffffff'
  }).then((result) => {
    if (result.isConfirmed) {
      emit('descargar', dataHomi);
    }
  });
};
</script>
