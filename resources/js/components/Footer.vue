<template> 
    <footer class="bg-custom-blue-li shadow">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
        <span class="text-sm text-gray-500 sm:text-center">© {{ currentYear }} Homilías Uriel. All Rights Reserved. </span>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>
