<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/40 p-4"
            role="status" aria-live="polite">
            <div class="rounded-2xl bg-white p-8 text-center shadow-xl">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-blue-600" aria-hidden="true"></i>
                <p class="mt-4 font-semibold text-gray-800">Guardando homilía...</p>
                <p class="mt-2 text-sm text-gray-600">Espera mientras se guardan los archivos. No cierres esta página.</p>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

let appElement;
let wasInert;
let previousFocus;

onMounted(() => {
    appElement = document.getElementById('app');
    previousFocus = document.activeElement;
    if (appElement) {
        wasInert = appElement.inert;
        // Bloquea también el teclado, los editores y la navegación del panel.
        appElement.inert = true;
    }
});

onBeforeUnmount(() => {
    if (appElement) {
        appElement.inert = wasInert;
    }
    if (previousFocus?.isConnected) {
        previousFocus.focus();
    }
});
</script>
