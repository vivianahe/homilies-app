<template>
  <div class="p-4 sm:ml-64">
    <div class="flex justify-between p-5 mt-14">
      <div class="text-start">
        <p class="font-semibold text-xl">Homilías</p>
      </div>
      <div class="text-end">
        <RouterLink :to="{ name: 'homilyAddView' }"
          class="bg-sky-500 hover:bg-sky-600 text-gray-800 py-2 px-4 rounded inline-flex items-center" title="Ver más">
          <i class="fa-solid fa-circle-plus text-white"></i>
          <span class="text-white">Agregar</span>
        </RouterLink>
      </div>
    </div>
    <div
      v-if="loading"
      class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50"
    >
      <div class="bg-white p-6 rounded-2xl shadow-xl text-center">
        <div
          class="w-14 h-14 border-4 border-sky-500 border-t-transparent rounded-full animate-spin mx-auto"
        ></div>

        <p class="mt-4 font-semibold text-gray-700">
          Cargando información...
        </p>
      </div>
    </div>

    <div v-else>
      <Table 
        :dataHomilies="dataHomilies" 
        :columns="columnConfig" 
        @descargar="descargarAudio"
        @editar="editar" 
        @datelle="datelle"
        @eliminar="eliminar" 
      />
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, nextTick } from "vue";
import Table from "../../Admin/Table.vue";
import { initFlowbite } from "flowbite";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const dataHomilies = ref([]);

const loading = ref(false);

const getDataHomilies = async () => {

  loading.value = true;
  await nextTick();

  try {
    const { data } = await axios.get('/getHomilies');
    dataHomilies.value = data;
  } catch (error) {
    console.error("Error al obtener los datos de Homilies:", error);

  } finally {

    loading.value = false;

  }
};
const columnConfig = [
  { key: "date", label: "Fecha de evangelio" },
  { key: "citation", label: "Cita Bíblica" },
  { key: "title", label: "Título" },
  { key: "reading", label: "Lectura" },
  { key: "options", label: "Opciones" },
];


const editar = (id) => {
  router.push({ name: 'editHomily', params: { id: id } });
}
const datelle = (id) => {
  router.push({ name: 'detailHomily', params: { id: id } });
}
const eliminar = async (id = null) => {
  const { data } = await axios.delete('/getHomilies/' + id);
  if (data) {
    if (data.data === "ok") {
      Swal.fire("Correcto!", data.message, "success");
      getDataHomilies();
    } else {
      Swal.fire("Atención!", response.data.message, "warning");
    }
  }
};

const descargarAudio = (homilia) => {
  if (!homilia.audio) {
    Swal.fire("Atención", "Esta homilía no tiene audio", "warning");
    return;
  }

  const url = window.location.origin + '/support/audioHomily/' + homilia.audio;

  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', homilia.audio);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

onMounted(() => {
  initFlowbite();
  getDataHomilies();
});
</script>
