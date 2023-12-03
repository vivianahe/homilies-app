<template>
  <div class="p-4 sm:ml-64 mt-14">
    <div class="flex justify-between p-4">
      <div class="text-start">
        <p class="font-semibold text-xl">Oración de la mañana</p>
      </div>
      <div class="text-end">
        <button class="bg-sky-500 hover:bg-sky-600 text-gray-800 py-2 px-4 rounded inline-flex items-center"
          data-modal-target="defaultModal" data-modal-toggle="defaultModal" @click="agregar">
          <i class="fa-solid fa-circle-plus text-white"></i>
          <span class="text-white"> Agregar</span>
        </button>
        <button ref="openModal" class="hideen" data-modal-target="defaultModal" data-modal-toggle="defaultModal"></button>
      </div>
    </div>
 
  <Table :dataHomilies="dataPrayerDesc" @editar="editar" @datelle="datelle" @eliminar="eliminar" :columns="columnConfig"
    :busqueda="false" />
  </div>
  <ModalVue :dataForm="dataForm" @getData="getPrayerDesc" />
</template>

<script setup>
import { onMounted, ref, reactive, markRaw } from "vue";
import { initFlowbite } from "flowbite";
import Table from "../../Admin/Table.vue";
import ModalVue from "../../Admin/Modal.vue";
import axios from "axios";
import FrmAgregar from "@/components/Admin/Oracion/FrmAgregar.vue";
import FrmEditar from "@/components/Admin/Oracion/FrmEditar.vue";
import FrmDetalle from "@/components/Admin/Oracion/FrmDetalle.vue";

const openModal = ref(null);
const columnConfig = ref([
  { key: "date", label: "Fecha oración" },
  { key: "link", label: "Link" },
  { key: "options", label: "Opciones" },
]);
const dataForm = reactive({});
const agregar = () => {
  dataForm.componet = markRaw(FrmAgregar); // Marcar el nuevo componente como no reactivo
  dataForm.nameModal = "Agregar oración del día";
};
const editar = async (id = null) => {
  openModal.value.click();
  const { data } = await axios.get('/prayers/' + id);
  if (data) {
    dataForm.componet = markRaw(FrmEditar);
    dataForm.nameModal = "Editar oración del día";
    dataForm.data = data;
  }
};
const datelle = async (id = null) => {
  openModal.value.click();
  const { data } = await axios.get('/prayers/' + id);
  if (data) {
    dataForm.componet = markRaw(FrmDetalle);
    dataForm.nameModal = "Detalle oración del día";
    dataForm.data = data;
  }
};


const eliminar = async (id) => {
  const { data } = await axios.delete('/prayers/' + id);
  if (data) {
    if (data.data === "ok") {
      Swal.fire("Correcto!", data.message, "success");
      getPrayerDesc();
    } else {
      Swal.fire("Atención!", response.data.message, "warning");
    }
  }
};


// Componente padre
const dataPrayerDesc = ref([]);
const getPrayerDesc = async () => {
  const { data } = await axios.get('/prayers');
  dataPrayerDesc.value = data;
};
onMounted(() => {
  initFlowbite();
  getPrayerDesc();
});

</script>
