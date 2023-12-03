<template>
  <div id="app">
    <ckeditor :editor="editor" v-model="editorData" @ready="onReady" @input="onChange" />
  </div>
</template>

<script setup>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { ref, onMounted } from 'vue';

const editor = ClassicEditor;
const editorData = ref('');

const emit = defineEmits(['editor-data', 'activeLoader']);
const props = defineProps({
  dataUpdate: {}
})

const onReady = () => {
  editorData.value = props.dataUpdate;
};
onMounted(() => {
  emit('activeLoader', true);
  setTimeout(() => {
    onReady();
    emit('activeLoader', false);
  }, 2000);
})

const onChange = () => {
  emit('editor-data', editorData.value);
};

</script>
