<template>
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen">

        <div class="flex justify-between items-center mt-16 mb-6">

            <button
                @click="volver"
                class="bg-white shadow-sm border border-gray-200 hover:bg-gray-100 rounded-xl p-3 transition">

                <svg class="w-5 h-5 text-gray-700"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 448 512">

                    <path
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                </svg>

            </button>

            <div class="text-center">

                <h1 class="text-2xl font-bold text-gray-800">
                    Detalle Homilía
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Visualización completa de la homilía
                </p>

            </div>

            <div></div>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
            <div
                v-if="homilia.img"
                class="relative bg-gray-100">
                <div class="relative group">

                    <img
                        :src="homilia.img"
                        @click="showImageModal = true"
                        class="w-full max-h-[520px] object-cover cursor-zoom-in transition duration-300 group-hover:scale-[1.01]" />

                    <div class="absolute top-5 right-5 flex gap-3">
                        <button
                            @click="showImageModal = true"
                            class="w-12 h-12 rounded-2xl bg-white/90 backdrop-blur shadow-lg hover:bg-white transition flex items-center justify-center">

                            <i class="fa-solid fa-expand text-gray-700"></i>

                        </button>
                        <button
                            @click="descargarImagen"
                            class="w-12 h-12 rounded-2xl bg-white/90 backdrop-blur shadow-lg hover:bg-white transition flex items-center justify-center">

                            <i class="fa-solid fa-download text-gray-700"></i>

                        </button>

                    </div>

                </div>

            </div>
            <div class="p-8">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">

                    <div>

                        <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">

                            <i class="fa-solid fa-calendar-days"></i>

                            {{ homilia.date }}

                        </span>

                    </div>

                    <div
                        v-if="homilia.citation"
                        class="text-sm font-semibold text-gray-500">

                        {{ homilia.citation }}

                    </div>

                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ homilia.title }}
                </h1>
                <p class="text-lg text-gray-500 mb-8">
                    {{ homilia.reading }}
                </p>
                <div
                    v-if="homilia.description && homilia.description !== 'null'"
                    class="mb-8">

                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">

                        <p class="text-sm font-semibold text-blue-700 mb-2 uppercase tracking-wide">
                            Descripción
                        </p>

                        <p class="text-gray-700 leading-relaxed">
                            {{ homilia.description }}
                        </p>

                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-10">
                    <div
                        v-if="homilia.cycle"
                        class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                            Ciclo
                        </p>

                        <p class="text-lg font-bold text-gray-800">
                            {{ homilia.cycle }}
                        </p>

                    </div>
                    <div
                        v-if="homilia.week_number"
                        class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                            Semana
                        </p>

                        <p class="text-lg font-bold text-gray-800">
                            {{ homilia.week_number }}
                        </p>

                    </div>
                    <div
                        v-if="homilia.celebration_type"
                        class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                            Tipo celebración
                        </p>

                        <p class="text-lg font-bold text-gray-800">
                            {{ homilia.celebration_type }}
                        </p>

                    </div>
                    <div
                        v-if="homilia.gospel_name"
                        class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                            Evangelista
                        </p>

                        <p class="text-lg font-bold text-gray-800">
                            {{ homilia.gospel_name }}
                        </p>

                    </div>

                </div>
                <div
                     v-if="homilia.solemnity_name && homilia.solemnity_name !== 'null'"
                    class="mb-10">

                    <div class="inline-flex items-center gap-3 bg-purple-100 text-purple-800 px-5 py-3 rounded-2xl font-semibold">

                        <i class="fa-solid fa-church"></i>

                        {{ homilia.solemnity_name }}

                    </div>

                </div>
                <div class="mb-10">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="bg-amber-100 text-amber-700 p-3 rounded-xl">
                            <i class="fa-solid fa-book-bible"></i>
                        </div>

                        <div>

                            <h2 class="text-xl font-bold text-gray-800">
                                Evangelio
                            </h2>

                            <p class="text-sm text-gray-500">
                                Lectura completa del día
                            </p>

                        </div>

                    </div>

                    <div
                        class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-gray-50 border border-gray-100 rounded-2xl p-6"
                        v-html="homilia.gospel">
                    </div>

                </div>
                <div
                    v-if="homilia.messag && homilia.messag !== 'null'"
                    class="mb-10">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="bg-pink-100 text-pink-700 p-3 rounded-xl">
                            <i class="fa-solid fa-heart"></i>
                        </div>

                        <div>

                            <h2 class="text-xl font-bold text-gray-800">
                                Mensaje del día
                            </h2>

                            <p class="text-sm text-gray-500">
                                Reflexión destacada
                            </p>

                        </div>

                    </div>

                    <div
                        class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-pink-50 border border-pink-100 rounded-2xl p-6"
                        v-html="homilia.messag">
                    </div>

                </div>

                <div
                    v-if="homilia.audio"
                    class="bg-gray-50 border border-gray-200 rounded-3xl p-5">

                    <div class="flex items-center gap-4 w-full">

                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center">

                            <i class="fa-solid fa-headphones text-indigo-600 text-xl"></i>

                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-gray-700 mb-2">
                                Audio de la homilía
                            </p>

                            <div class="flex items-center gap-4">

                                <audio controls class="flex-1 h-[52px] rounded-xl">

                                    <source :src="homilia.audio" type="audio/mp3" />

                                    Tu navegador no admite audio.

                                </audio>
                                <button
                                    @click="descargarAudioArchivo"
                                    class="min-w-[48px] h-[48px] mt-1 rounded-2xl bg-indigo-100 hover:bg-indigo-200 transition flex items-center justify-center shadow-sm border border-indigo-100">

                                    <i class="fa-solid fa-download text-indigo-700 text-lg"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="flex justify-end mt-6 pb-10">

            <button
                @click="volver"
                class="uppercase text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 font-semibold rounded-xl text-sm px-6 py-3 transition">

                Volver

            </button>

        </div>

    </div>

    <div
        v-if="showImageModal"
        class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-6">
        <button
            @click="showImageModal = false"
            class="absolute top-6 right-6 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 text-white text-xl transition">

            <i class="fa-solid fa-xmark"></i>

        </button>
        <button
            @click="descargarImagen"
            class="absolute top-6 right-24 w-14 h-14 rounded-2xl bg-white/10 hover:bg-white/20 text-white text-xl transition">

            <i class="fa-solid fa-download"></i>

        </button>
        <img
            :src="homilia.img"
            class="max-w-full max-h-full rounded-3xl shadow-2xl object-contain" />

    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";

const user_id = localStorage.getItem("user_id");
const emit = defineEmits(["getData"]);

const router = useRouter();
const route = useRoute();
const HomilyId = route.params.id;

const homilia = ref({
    id: null,
    date: "",
    citation: "",
    title: "",
    description: "",
    reading: "",
    gospel: "",
    img: null,
    audio: null,
    messag: "",

    cycle: "",
    week_number: "",
    celebration_type: "",

    gospel_name: "",
    liturgical_time_name: "",
    solemnity_name: "",

    user_id: user_id ? user_id : null,
});

const showImageModal = ref(false);

const descargarImagen = () => {

    if (!homilia.value.img) return;

    const link = document.createElement('a');

    link.href = homilia.value.img;

    link.setAttribute(
        'download',
        homilia.value.title + '.jpg'
    );

    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);
}

const descargarAudioArchivo = () => {

    if (!homilia.value.audio) return;

    const link = document.createElement('a');

    link.href = homilia.value.audio;

    link.setAttribute(
        'download',
        homilia.value.title + '.mp3'
    );

    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);
}


const volver = () => {
    router.push({ name: 'homilyAllAdm' });
}

const getData = () => {
    axios
        .get('/getHomeliasId/' + HomilyId)
        .then((response) => {
            homilia.value.id = response.data.id;
            homilia.value.date = response.data.date;
            homilia.value.citation = response.data.citation;
            homilia.value.title = response.data.title;
            homilia.value.reading = response.data.reading;
            homilia.value.gospel = response.data.gospel;
            homilia.value.img =
                response.data.img &&
                response.data.img !== 'null'
                    ? "/support/imgHomily/" + response.data.img
                    : null;

            homilia.value.audio =
                response.data.audio &&
                response.data.audio !== 'null'
                    ? "/support/audioHomily/" + response.data.audio
                    : null;
            homilia.value.cycle = response.data.cycle;
            homilia.value.week_number = response.data.week_number;
            homilia.value.celebration_type = response.data.celebration_type;
            homilia.value.gospel_name = response.data.gospel_name;
            homilia.value.liturgical_time_name = response.data.liturgical_time_name;

            homilia.value.description =
                response.data.description &&
                response.data.description !== 'null'
                    ? response.data.description
                    : '';

            homilia.value.messag =
                response.data.message &&
                response.data.message !== 'null'
                    ? response.data.message
                    : '';

            homilia.value.solemnity_name =
                response.data.solemnity_name &&
                response.data.solemnity_name !== 'null'
                    ? response.data.solemnity_name
                    : '';
        })
        .catch((error) => {
            console.error(error);
        });
}
onMounted(() => {
    getData();
})
</script>
