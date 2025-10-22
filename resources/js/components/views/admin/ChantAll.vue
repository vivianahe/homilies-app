<template>
  <div class="p-4 sm:ml-64 mt-14">
    <div class="flex justify-between p-4">
      <div class="text-start">
        <p class="font-semibold text-xl">Canta y ora</p>
      </div>
      <div class="text-end">
        <button class="bg-sky-500 hover:bg-sky-600 text-gray-800 py-2 px-4 rounded inline-flex items-center"
          data-modal-target="defaultModal" data-modal-toggle="defaultModal" @click="agregar">
          <i class="fa-solid fa-circle-plus text-white"></i>
          <span class="text-white">Agregar</span>
        </button>
        <button ref="openModal" class="hideen" data-modal-target="defaultModal" data-modal-toggle="defaultModal"></button>
      </div>
    </div>

    <Table :dataHomilies="chants" @editar="editar" @datelle="datelle" @eliminar="eliminar" :columns="columnConfig"
      :busqueda="false" />
  </div>
  <ModalVue :dataForm="dataForm" @getData="getChants" />
</template>

<script setup>
import { onMounted, ref, reactive, markRaw } from "vue";
import { initFlowbite } from "flowbite";
import Table from "../../Admin/Table.vue";
import ModalVue from "../../Admin/Modal.vue";
import axios from "axios";

const openModal = ref(null);
const columnConfig = ref([
  { key: "title", label: "Título" },
  { key: "description", label: "Descripción" },
  { key: "audio", label: "Audio" },
  { key: "options", label: "Opciones" },
]);
const dataForm = reactive({});

// Lazy inline forms to keep single-file simplicity
const FrmAgregar = markRaw({
  emits: ["closeMod"],
  data() {
    return { form: { title: "", description: "", audio: null }, loading: false };
  },
  methods: {
    async submit() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append('title', this.form.title);
        fd.append('description', this.form.description ?? '');
        if (this.form.audio) fd.append('audio', this.form.audio);
        const { data } = await axios.post('/chants', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        if (data) {
          Swal.fire("Correcto!", data.message, "success");
          // Reset form so next open is clean
          this.form = { title: "", description: "", audio: null };
          this.$emit('closeMod');
        }
      } finally {
        this.loading = false;
      }
    }
  },
  template: `
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Título</label>
        <input v-model="form.title" class="w-full border rounded p-2" />
      </div>
      <div>
        <label class="block text-sm font-medium">Descripción</label>
        <textarea v-model="form.description" class="w-full border rounded p-2"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Archivo de audio</label>
        <input type="file" accept="audio/mp3" @change="e=> form.audio = e.target.files[0]" class="w-full border rounded p-2" />
      </div>
      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">
        <button type="button" @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
          Cancelar
        </button>
        <button v-if="!loading" type="button" @click="submit"
          class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
          Guardar
        </button>
        <button v-else disabled type="button"
          class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
          <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
          </svg>
          Guardando...
        </button>
      </div>
    </div>
  `
});

const FrmEditar = markRaw({
  props: { data: Object },
  emits: ["closeMod"],
  data() {
    return { form: { ...this.data, audioFile: null }, loading: false };
  },
  methods: {
    async submit() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append('title', this.form.title);
        fd.append('description', this.form.description ?? '');
        if (this.form.audioFile) fd.append('audio', this.form.audioFile);
        const { data } = await axios.post('/chants/' + this.form.id + '?_method=PUT', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        if (data) {
          Swal.fire("Correcto!", data.message, "success");
          this.$emit('closeMod');
        }
      } finally {
        this.loading = false;
      }
    }
  },
  template: `
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Título</label>
        <input v-model="form.title" class="w-full border rounded p-2" />
      </div>
      <div>
        <label class="block text-sm font-medium">Descripción</label>
        <textarea v-model="form.description" class="w-full border rounded p-2"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Reemplazar audio (opcional)</label>
        <input type="file" accept="audio/*" @change="e=> form.audioFile = e.target.files[0]" class="w-full border rounded p-2" />
        <p class="text-xs text-gray-500 mt-1">Actual: {{ form.audio }}</p>
      </div>
      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">
        <button type="button" @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
          Cancelar
        </button>
        <button @click="submit" :disabled="loading" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
          Actualizar
        </button>
      </div>
    </div>
  `
});

const FrmDetalle = markRaw({
  props: { data: Object },
  emits: ["closeMod"],
  template: `
    <div class="space-y-3">
      <p><strong>Título:</strong> {{ data.title }}</p>
      <p><strong>Descripción:</strong> {{ data.description }}</p>
      <p><strong>Audio:</strong> {{ data.audio }}</p>
      <audio class="w-full" controls :src="'/support/audioChant/' + data.audio"></audio>
      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">
        <button data-modal-hide="defaultModal" type="button" @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
          Cancelar
        </button>
      </div>
    </div>
  `
});

const agregar = () => {
  dataForm.componet = FrmAgregar;
  dataForm.nameModal = "Agregar canto";
  dataForm.key = Date.now();
};
const editar = async (id = null) => {
  openModal.value.click();
  const { data } = await axios.get('/chants/' + id);
  if (data) {
    dataForm.componet = FrmEditar;
    dataForm.nameModal = "Editar canto";
    dataForm.data = data;
    dataForm.key = Date.now();
  }
};
const datelle = async (id = null) => {
  openModal.value.click();
  const { data } = await axios.get('/chants/' + id);
  if (data) {
    dataForm.componet = FrmDetalle;
    dataForm.nameModal = "Detalle canto";
    dataForm.data = data;
    dataForm.key = Date.now();
  }
};

const eliminar = async (id) => {
  const { data } = await axios.delete('/chants/' + id);
  if (data) {
    if (data.data === "ok") {
      Swal.fire("Correcto!", data.message, "success");
      getChants();
    } else {
      Swal.fire("Atención!", data.message, "warning");
    }
  }
};

const chants = ref([]);
const getChants = async () => {
  const { data } = await axios.get('/chants');
  chants.value = data;
};
onMounted(() => {
  initFlowbite();
  getChants();
});
</script>



