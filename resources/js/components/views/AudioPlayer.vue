<template>
    <HomilyAudio :source="src" heading="Escuchar canto" subtitle="" compact exclusive />
</template>

<script setup>
import HomilyAudio from '../detailHomilies/HomilyAudio.vue';
defineProps({ src: { type: String, default: '' } });
</script>
