<template>
  <section class="bg-white dark:bg-gray-900">
    <div class="pb-10">
      <p class="font-bold text-lg text-gray-900 py-4">
        Nombre: <span class="font-normal">{{ data.name }}</span>
      </p>
      <p class="font-bold text-lg text-gray-900 py-4">
        Correo electrónico: <span class="font-normal">{{ data.email }}</span>
      </p>
      <p class="font-bold text-lg text-gray-900 py-4">
        Fecha creación: <span class="font-normal">{{ data.created_at.substr(0,10) }}</span>
      </p>
    </div>
    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
      <button data-modal-hide="defaultModal" type="button" @click="$emit('closeMod')"
        class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
        Cancelar
      </button>
    </div>
  </section>
</template>

<script setup>
const user_id = localStorage.getItem("user_id");

const emit = defineEmits(["closeMod"]);
const { data } = defineProps({
  data: {
    Object: true,
  },
});

</script>
