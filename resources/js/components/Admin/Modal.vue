<script setup>
import { ref } from 'vue'

const closeModal = ref(null);


const emit = defineEmits(['getData']);
const closeMod = ()=>{
  emit('getData');
  closeModal.value.click();
}

const props = defineProps({
  dataForm: {
    type: Object,
    required: true
  }
});

</script>

<template>
  <!-- Main modal -->
  <div id="defaultModal" tabindex="-1" data-modal-backdrop="static" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow ">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b rounded-t ">
          <h3 class="text-xl font-semibold text-gray-900 ">
            {{ dataForm.nameModal }}
          </h3>
        </div>
        <!-- Modal body -->
        <div class="p-6 space-y-6">
          <component :is="dataForm.componet" @closeMod="closeMod" :data="dataForm.data" />
        </div>
      <button
        ref="closeModal"
        data-modal-hide="defaultModal"
        type="button"
        class="hidden"
      >
      </button>
      </div>
    </div>
  </div>
</template>
