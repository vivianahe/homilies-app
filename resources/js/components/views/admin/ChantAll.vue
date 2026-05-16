<template>
  <div class="p-4 sm:ml-64 mt-14">
    <div class="flex justify-between p-4">
      <div class="text-start">
        <p class="font-semibold text-xl">Canta y ora</p>
      </div>
      <div class="text-end">
        <button
          class="bg-sky-500 hover:bg-sky-600 text-gray-800 py-2 px-4 rounded inline-flex items-center"
          data-modal-target="defaultModal"
          data-modal-toggle="defaultModal"
          @click="agregar"
        >
          <i class="fa-solid fa-circle-plus text-white"></i>
          <span class="text-white">Agregar</span>
        </button>

        <button
          ref="openModal"
          class="hideen"
          data-modal-target="defaultModal"
          data-modal-toggle="defaultModal"
        ></button>
      </div>
    </div>

    <div
      v-if="loadingPage"
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
        :dataHomilies="chants"
        :columns="columnConfig"

        :filterFields="['title', 'description', 'audio']"

        :filterLabels="{
          search: 'Buscar',
          citation: 'Audio',
          searchPlaceholder: 'Título o descripción...',
          citationPlaceholder: 'Nombre del audio...'
        }"

        :showDateFilters="false"

        @descargar="descargarAudio"
        @editar="editar"
        @datelle="datelle"
        @eliminar="eliminar"
      />

    </div>
  </div>
  <ModalVue :dataForm="dataForm" @getData="getChants" />
</template>

<script setup>
import { onMounted, ref, reactive, markRaw } from "vue";
import { initFlowbite } from "flowbite";
import Table from "../../Admin/Table.vue";
import ModalVue from "../../Admin/Modal.vue";
import axios from "axios";

const loadingPage = ref(false);

const openModal = ref(null);
const columnConfig = ref([
  { key: "title", label: "Título" },
  { key: "description", label: "Descripción" },
  { key: "audio", label: "Audio" },
  { key: "options", label: "Opciones" },
]);
const dataForm = reactive({});

const FrmAgregar = markRaw({
  emits: ["closeMod"],
  data() {
    return {
      form: {
        title: "",
        description: "",
        audio: null
      },
      loading: false
    };
  },
  methods: {
    async submit() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append('title', this.form.title);
        fd.append('description', this.form.description ?? '');

        if (this.form.audio) {
          fd.append('audio', this.form.audio);
        }

        const { data } = await axios.post('/chants', fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        if (data) {
          Swal.fire("Correcto!", data.message, "success");

          this.form = {
            title: "",
            description: "",
            audio: null
          };

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

        <input
          v-model="form.title"
          class="w-full border rounded p-2"
        />
      </div>

      <div>
        <label class="block text-sm font-medium">Descripción</label>

        <textarea
          v-model="form.description"
          class="w-full border rounded p-2"
        ></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium">
          Archivo de audio
        </label>

        <input
          type="file"
          accept="audio/mp3"
          @change="e => form.audio = e.target.files[0]"
          class="w-full border rounded p-2"
        />
      </div>

      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">

        <button
          type="button"
          @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center"
        >
          Cancelar
        </button>

        <button
          v-if="!loading"
          type="button"
          @click="submit"
          class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
        >
          Guardar
        </button>

        <button
          v-else
          disabled
          type="button"
          class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
        >
          <svg
            aria-hidden="true"
            role="status"
            class="inline w-4 h-4 mr-3 text-white animate-spin"
            viewBox="0 0 100 101"
            fill="none"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908Z"
              fill="#E5E7EB"
            />
          </svg>
          Guardando...
        </button>
      </div>
    </div>
  `
});

const FrmEditar = markRaw({
  props: {
    data: Object
  },

  emits: ["closeMod"],

  data() {
    return {
      form: {
        ...this.data,
        audioFile: null
      },
      loading: false
    };
  },
  methods: {
    async submit() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append('title', this.form.title);
        fd.append('description', this.form.description ?? '');

        if (this.form.audioFile) {
          fd.append('audio', this.form.audioFile);
        }

        const { data } = await axios.post(
          '/chants/' + this.form.id + '?_method=PUT',
          fd,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        );

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

        <input
          v-model="form.title"
          class="w-full border rounded p-2"
        />
      </div>

      <div>
        <label class="block text-sm font-medium">Descripción</label>

        <textarea
          v-model="form.description"
          class="w-full border rounded p-2"
        ></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">
          Reemplazar audio (opcional)
        </label>

        <input
          type="file"
          accept="audio/*"
          @change="e => form.audioFile = e.target.files[0]"
          class="w-full border rounded p-2"
        />

        <p class="text-xs text-gray-500 mt-1">
          Actual: {{ form.audio }}
        </p>
      </div>

      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">

        <button
          type="button"
          @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 font-bold rounded-lg text-sm px-5 py-2.5 text-center"
        >
          Cancelar
        </button>

        <button
          @click="submit"
          :disabled="loading"
          class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
        >
          Actualizar
        </button>
      </div>
    </div>
  `
});

const FrmDetalle = markRaw({
  props: {
    data: Object
  },

  emits: ["closeMod"],

  template: `
    <div class="space-y-3">

      <p>
        <strong>Título:</strong>
        {{ data.title }}
      </p>

      <p>
        <strong>Descripción:</strong>
        {{ data.description }}
      </p>

      <p>
        <strong>Audio:</strong>
        {{ data.audio }}
      </p>

      <audio
        class="w-full"
        controls
        :src="'/support/audioChant/' + data.audio"
      ></audio>

      <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b justify-end">

        <button
          data-modal-hide="defaultModal"
          type="button"
          @click="$emit('closeMod')"
          class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 font-bold rounded-lg text-sm px-5 py-2.5 text-center"
        >
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

const descargarAudio = (homilia) => {
  if (!homilia.audio) {
    Swal.fire("Atención", "Este canto no tiene audio", "warning");
    return;
  }

  const url =
    window.location.origin +
    '/support/audioChant/' +
    homilia.audio;

  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', homilia.audio);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const chants = ref([]);
const getChants = async () => {

  loadingPage.value = true;

  try {

    const { data } = await axios.get('/chants');
    chants.value = data;

  } catch (error) {

    console.error("Error al obtener los cantos:", error);

  } finally {

    loadingPage.value = false;

  }
};
onMounted(() => {
  initFlowbite();
  getChants();
});
</script>



