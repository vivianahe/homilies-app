<template>
    <div class="p-4 sm:ml-64 bg-gray-50 min-h-screen">

        <!-- HEADER -->
        <div class="flex justify-between items-center mt-16 mb-6">
            <div>
                <button
                    @click="volver"
                    class="bg-white shadow-sm border border-gray-200 hover:bg-gray-100 rounded-xl p-3 transition">

                    <svg class="w-5 h-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 448 512">
                        <path
                            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                    </svg>
                </button>
            </div>

            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    Agregar Homilía
                </h1>

            <p class="text-sm text-gray-500 mt-1">

                {{
                    homilia.cycle && homilia.week_number
                    ? `Ciclo ${homilia.cycle} · Semana ${homilia.week_number}`
                    : 'Gestión litúrgica y contenido multimedia'
                }}

            </p>
            </div>
            <div></div>
        </div>

        <form @submit.prevent="submit">

            <Alerta v-if="alerta.mensaje" :alerta="alerta" />

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <div class="flex items-center gap-3 mb-5">

                    <div class="bg-blue-100 text-blue-700 p-3 rounded-xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Información general
                        </h2>

                        <p class="text-sm text-gray-500">
                            Datos principales de la homilía
                        </p>
                    </div>

                </div>

                <div class="flex flex-wrap -mx-3 mb-4">

                    <div class="w-full md:w-1/2 px-3 mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Fecha Homilía
                        </label>

                        <input
                            type="date"
                            v-model="homilia.date"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            required />
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Cita Bíblica
                        </label>

                        <input
                            type="text"
                            v-model="homilia.citation"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            required />
                    </div>

                </div>

                <div class="flex flex-wrap -mx-3">

                    <div class="w-full md:w-1/2 px-3 mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Título
                        </label>

                        <input
                            type="text"
                            v-model="homilia.title"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            required />
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Lectura
                        </label>

                        <input
                            type="text"
                            v-model="homilia.reading"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            required />
                    </div>

                    <div class="w-full px-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Descripción corta
                        </label>

                        <textarea
                            rows="3"
                            v-model="homilia.description"
                            placeholder="Ej: Este domingo se celebra dentro del tiempo litúrgico..."
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3"></textarea>
                    </div>

                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <div class="flex items-center gap-3 mb-5">

                    <div class="bg-amber-100 text-amber-700 p-3 rounded-xl">
                        <i class="fa-solid fa-book-bible"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Evangelio
                        </h2>

                        <p class="text-sm text-gray-500">
                            Texto completo del evangelio del día
                        </p>
                    </div>

                </div>

                <Editor @editor-data="editorData" />
            </div>

            <div class="bg-white border border-gray-200 rounded-3xl p-6 mb-8 shadow-sm">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <i class="fa-solid fa-photo-film text-emerald-600 text-xl"></i>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Multimedia
                        </h2>

                        <p class="text-sm text-gray-500">
                            Imagen principal y audio de la homilía
                        </p>
                    </div>

                </div>

                <div class="mb-8">

                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Imagen principal
                    </label>

                    <div
                        v-if="selectedImage"
                        class="relative overflow-hidden rounded-3xl border border-gray-200 shadow-sm bg-gray-50 p-4">

                        <div
                            class="cursor-zoom-in"
                            @click="openImagePreview = true">

                            <img
                                :src="selectedImage"
                                class="w-full max-h-[520px] object-contain rounded-2xl bg-gray-100"
                            />

                        </div>

                        <div class="absolute top-6 right-6 flex flex-col items-center gap-3">

                            <button
                                type="button"
                                @click="openImagePreview = true"
                                class="w-12 h-12 rounded-2xl bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-600 hover:text-blue-600 shadow-sm transition-all duration-200 flex items-center justify-center">

                                <i class="fa-solid fa-expand"></i>

                            </button>

                            <a
                                :href="selectedImage"
                                download
                                target="_blank"
                                class="w-12 h-12 rounded-2xl bg-white border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 text-gray-600 hover:text-indigo-600 shadow-sm transition-all duration-200 flex items-center justify-center">

                                <i class="fa-solid fa-download"></i>

                            </a>

                            <button
                                type="button"
                                @click="closeImg"
                                class="w-12 h-12 rounded-2xl bg-red-50 hover:bg-red-500 border border-red-100 hover:border-red-500 text-red-500 hover:text-white shadow-sm transition-all duration-200 flex items-center justify-center">

                                <i class="fa-solid fa-xmark"></i>

                            </button>

                        </div>

                    </div>

                    <label
                        v-else
                        for="dropzone-file"
                        class="group flex flex-col items-center justify-center w-full h-72 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-all duration-300">

                        <div class="flex flex-col items-center">

                            <div class="w-20 h-20 rounded-full bg-white shadow-sm flex items-center justify-center mb-4 group-hover:scale-105 transition">

                                <i class="fa-solid fa-cloud-arrow-up text-4xl text-blue-500"></i>

                            </div>

                            <p class="text-lg font-semibold text-gray-700">
                                Subir imagen
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                PNG, JPG, JPEG
                            </p>

                        </div>

                        <input
                            id="dropzone-file"
                            type="file"
                            class="hidden"
                            @change="handleFileChange"
                            accept=".svg, .png, .jpg, .gif, .jpeg"
                        />

                    </label>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Audio
                    </label>

                    <div
                        v-if="shouldShowAudio"
                        class="flex items-center gap-4 bg-gray-50 border border-gray-200 rounded-3xl p-5">

                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center">

                            <i class="fa-solid fa-headphones text-indigo-600 text-xl"></i>

                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-gray-700 mb-2">
                                Audio cargado correctamente
                            </p>

                            <audio
                                ref="audioPlayer"
                                controls
                                class="w-full rounded-xl">
                            </audio>

                        </div>

                    <div class="flex flex-col items-center justify-center gap-3 min-w-[52px]">

                        <a
                            :href="audioDownloadUrl"
                            download
                            target="_blank"
                            class="w-12 h-12 rounded-2xl bg-white border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 text-gray-600 hover:text-indigo-600 shadow-sm transition-all duration-200 flex items-center justify-center">

                            <i class="fa-solid fa-download text-sm"></i>

                        </a>

                        <button
                            type="button"
                            @click="closeAudio"
                            class="w-12 h-12 rounded-2xl bg-red-50 hover:bg-red-500 border border-red-100 hover:border-red-500 text-red-500 hover:text-white shadow-sm transition-all duration-200 flex items-center justify-center">

                            <i class="fa-solid fa-xmark text-sm"></i>

                        </button>

                    </div>

                    </div>

                    <label
                        v-else
                        for="button2"
                        class="group flex items-center justify-center gap-5 w-full h-32 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-400 transition-all duration-300">

                        <div class="w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center group-hover:scale-105 transition">

                            <i class="fa-solid fa-upload text-2xl text-indigo-600"></i>

                        </div>

                        <div>

                            <p class="text-lg font-semibold text-gray-700">
                                Subir audio
                            </p>

                            <p class="text-sm text-gray-500">
                                MP3 máximo 15MB
                            </p>

                        </div>

                        <input
                            hidden
                            type="file"
                            id="button2"
                            @change="handleAudioChange"
                            accept="audio/mp3"
                        />

                    </label>

                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <div class="flex items-center gap-3 mb-5">

                    <div class="bg-purple-100 text-purple-700 p-3 rounded-xl">
                        <i class="fa-solid fa-church"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Configuración litúrgica
                        </h2>

                        <p class="text-sm text-gray-500">
                            Clasificación litúrgica del domingo
                        </p>
                    </div>

                </div>

                <div class="flex flex-wrap -mx-3">

                    <div class="w-full md:w-1/5 px-3 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Tiempo litúrgico
                        </label>

                        <select
                            v-model="homilia.liturgical_time_id"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">

                            <option value="">Seleccione</option>

                            <option
                                v-for="item in liturgicalTimes"
                                :key="item.id"
                                :value="item.id">

                                {{ item.name }}

                            </option>

                        </select>

                    </div>

                    <div class="w-full md:w-1/5 px-3 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Evangelista
                        </label>

                        <select
                            v-model="homilia.gospel_id"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">

                            <option value="">Seleccione</option>

                            <option
                                v-for="item in gospels"
                                :key="item.id"
                                :value="item.id">

                                {{ item.name }}

                            </option>

                        </select>

                    </div>

                    <div class="w-full md:w-1/5 px-3 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Ciclo
                        </label>

                        <select
                            v-model="homilia.cycle"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">

                            <option value="">Seleccione</option>
                            <option value="A">Ciclo A</option>
                            <option value="B">Ciclo B</option>
                            <option value="C">Ciclo C</option>
                            <option value="P">Par</option>
                            <option value="I">Impar</option>
                        </select>

                    </div>

                    <div class="w-full md:w-1/5 px-3 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Semana
                        </label>

                        <input
                            type="number"
                            v-model.number="homilia.week_number"
                            placeholder="Ej: 6"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3" />

                    </div>

                    <div class="w-full md:w-1/5 px-3 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Tipo celebración
                        </label>

                        <select
                            v-model="homilia.celebration_type"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">

                            <option value="">Seleccione</option>

                            <option value="Domingo">Domingo</option>
                            <option value="Solemnidad">Solemnidad</option>
                            <option value="Fiesta">Fiesta</option>
                            <option value="Memoria">Memoria</option>

                        </select>

                    </div>

                </div>

                <div class="mt-2">

                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Solemnidad / Celebración especial
                    </label>

                    <div
                        id="searching_div"
                        class="bg-gray-50 border border-gray-300 rounded-2xl p-3">

                        <div class="input-box">
                            <div class="row-icon">
                                <i class="fas fa-search icon-searching"></i>
                            </div>

                            <div class="div-search">

                                <input
                                    type="text"
                                    id="input_search"
                                    v-model="solemnity"
                                    @keyup="searchSolemnity"
                                    placeholder="Buscar solemnidad..."
                                    class="bg-transparent" />

                            </div>

                        </div>

                        <div
                            v-if="solemnitys.length > 0"
                            class="mt-3 border-t border-gray-200 pt-2">

                            <div
                                v-for="(element, index) in solemnitys"
                                :key="index"
                                class="row_searching elements rounded-xl">

                                <div
                                    class="result_row py-2"
                                    v-text="element.name"
                                    @click="getSolemnityId(element.id, element.name)">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div
                        v-if="solemnity"
                        class="mt-3 inline-flex items-center gap-2 bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">

                        <i class="fa-solid fa-church"></i>

                        {{ solemnity }}

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <div class="flex items-center gap-3 mb-5">

                    <div class="bg-pink-100 text-pink-700 p-3 rounded-xl">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Mensaje del día
                        </h2>

                        <p class="text-sm text-gray-500">
                            Reflexión corta para destacar
                        </p>
                    </div>
                </div>

                <Editor @editor-data="editorDataTips" />

            </div>

            <div class="flex items-center justify-end gap-4 pb-10">

                <button
                    type="button"
                    @click="clearFrm()"
                    class="uppercase text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 font-semibold rounded-xl text-sm px-6 py-3 transition">

                    Cancelar

                </button>

                <button
                    v-if="loader"
                    type="submit"
                    class="uppercase text-white bg-blue-700 hover:bg-blue-800 font-semibold rounded-xl text-sm px-6 py-3 transition shadow-sm">

                    Guardar Homilía

                </button>

                <button
                    v-else
                    disabled
                    type="button"
                    class="text-white bg-blue-700 rounded-xl text-sm px-6 py-3 inline-flex items-center">

                    <svg aria-hidden="true" role="status"
                        class="inline w-4 h-4 mr-3 text-white animate-spin"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908Z"
                            fill="#E5E7EB" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor" />
                    </svg>
                    Guardando...
                </button>

            </div>

        </form>

    </div>

    <div
        v-if="openImagePreview"
        class="fixed inset-0 z-[9999] bg-black/80 backdrop-blur-sm flex items-center justify-center p-8">

        <button
            type="button"
            @click="openImagePreview = false"
            class="absolute top-6 right-6 w-14 h-14 rounded-2xl bg-white/10 hover:bg-red-500 text-white transition flex items-center justify-center">

            <i class="fa-solid fa-xmark text-xl"></i>

        </button>

        <img
            :src="selectedImage"
            class="max-w-full max-h-full object-contain rounded-3xl shadow-2xl"
        />

    </div>
</template>

<script setup>
import Editor from "../../Admin/Editor.vue";
import { ref, reactive, computed, onMounted, nextTick } from "vue";
import Alerta from "../../Admin/Alerta.vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
const user_id = localStorage.getItem("user_id");
const emit = defineEmits(["getData"]);
const selectedImage = ref(null);
const audioFile = ref(null);
const audioPlayer = ref(null);
const loader = ref(true);
const openImagePreview = ref(false);

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
    liturgical_time_id: "",
    gospel_id: "",
    user_id: user_id ? user_id : null,
});
const alerta = reactive({
    tipo: "",
    mensaje: "",
});
const solemnitys = ref([]);
const solemnity = ref('');

const liturgicalTimes = ref([]);
const gospels = ref([]);

const searchSolemnity = () => {
    if (solemnity.value.length > 0) {
        axios
            .get('/getSolemnity/' + solemnity.value)
            .then((response) => {
                if (response.data.length > 0 && solemnity.value.length > 0) {
                    solemnitys.value = response.data;
                } else {
                    solemnitys.value = [];
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }
}

onMounted(() => {
    getLiturgicalTimes();
    getGospels();
});

const getLiturgicalTimes = async () => {
    try {
        const response = await axios.get('/getLiturgicalTimes');
        liturgicalTimes.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const getGospels = async () => {
    try {
        const response = await axios.get('/getGospels');
        gospels.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const getSolemnityId = (id, name) => {
    solemnity.value = name;
    solemnitys.value = [];
}
const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        // Verificar si es una imagen
        if (file.type.startsWith('image/')) {
            // Crear una URL temporal para la imagen seleccionada
            selectedImage.value = URL.createObjectURL(file);

            // Crear un objeto de la clase FileReader para leer el archivo de imagen
            const reader = new FileReader();
            reader.onload = (e) => {
                // Crear una nueva imagen para obtener sus dimensiones
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    // Verificar si la imagen es horizontal (ancho mayor que altura)
                    if (img.width > img.height) {
                        // Asignar el archivo solo si es una imagen horizontal
                        homilia.value.img = file;
                    } else {
                        // Limpiar el campo de entrada y mostrar una alerta
                        event.target.value = null;
                        selectedImage.value = null;
                        solemnity.value = "";
                        solemnitys.value = [];
                        Swal.fire(
                            "Atención!",
                            "La imagen debe ser horizontal (ancho mayor que altura).",
                            "warning"
                        );
                    }
                };
            };

            // Leer el archivo de imagen como una URL de datos
            reader.readAsDataURL(file);
        } else {
            // Limpiar el campo de entrada si no es una imagen
            event.target.value = null;
            Swal.fire(
                "Atención!",
                "Por favor, seleccione un archivo de imagen válido (SVG, PNG, JPG, JPEG, GIF).",
                "warning"
            );
        }
    }
};
const handleAudioChange = async (event) => {

    const maxFileSizeMB = 15;

    const selectedFile = event.target.files[0];

    if (selectedFile) {

        if (selectedFile.size <= maxFileSizeMB * 1024 * 1024) {

            homilia.value.audio = selectedFile;

            audioFile.value = selectedFile;

            await playAudio();

        } else {

            event.target.value = null;

            Swal.fire(
                "Atención!",
                `El tamaño del archivo de audio no debe superar los ${maxFileSizeMB} MB.`,
                "warning"
            );
        }
    }
};

const playAudio = async () => {

    if (!audioFile.value) return;

    await nextTick();

    if (audioPlayer.value) {

        audioPlayer.value.src =
            URL.createObjectURL(audioFile.value);

        audioPlayer.value.load();
    }
};

const shouldShowAudio = computed(() => !!audioFile.value);

const audioDownloadUrl = computed(() => {

    if (!audioFile.value) return '';

    if (typeof audioFile.value === 'string') {

        return audioFile.value;
    }

    return URL.createObjectURL(audioFile.value);
});

const editorData = (text = "") => {
    //Texto del editor
    homilia.value.gospel = text;
};
const editorDataTips = (text = "") => {
    //Texto del editor
    homilia.value.messag = text;
};
const submit = () => {
    // Crear un objeto FormData para manejar la solicitud
    const formData = new FormData();
    formData.append("date", homilia.value.date);
    formData.append("citation", homilia.value.citation);
    formData.append("title", homilia.value.title);
    formData.append("description", homilia.value.description);
    formData.append("cycle", homilia.value.cycle);
    formData.append("week_number", homilia.value.week_number);
    formData.append("celebration_type", homilia.value.celebration_type);
    formData.append("liturgical_time_id", homilia.value.liturgical_time_id);
    formData.append("gospel_id", homilia.value.gospel_id);
    formData.append("reading", homilia.value.reading);
    formData.append("gospel", homilia.value.gospel);
    formData.append("img", homilia.value.img);
    formData.append("audio", homilia.value.audio);
    formData.append("messag", homilia.value.messag);
    formData.append("user_id", homilia.value.user_id);
    formData.append("solemnity", solemnity.value);

    // Configurar las cabeceras de la solicitud
    const config = {
        headers: {
            "content-type": "multipart/form-data"
        },
    };
    if (
        homilia.value.gospel !== "" &&
        homilia.value.img !== null &&
        homilia.value.audio !== null &&
        homilia.value.liturgical_time_id !== "" &&
        homilia.value.gospel_id !== "" &&
        homilia.value.cycle !== ""
    ){
        loader.value = false;
        axios
            .post('/addHomilies', formData, config)
            .then((response) => {
                if (response.data.data !== false) {
                    Swal.fire({
                        title: 'Homilía guardada',
                        text: response.data.message,
                        icon: 'success',
                        background: '#ffffff',
                        color: '#1f2937',
                        confirmButtonText: 'Continuar',
                        confirmButtonColor: '#2563eb',
                        timer: 2200,
                        timerProgressBar: true,
                        showConfirmButton: false,

                        customClass: {
                            popup: 'rounded-3xl shadow-2xl border border-gray-100',
                            title: 'text-2xl font-bold text-gray-800',
                            htmlContainer: 'text-gray-500 text-sm',
                            icon: 'border-emerald-200'
                        }
                    });
                    emit("closeMod");
                    emit("getData");
                    clearFrm();
                    loader.value = true;
                    router.push({ name: 'homilyAllAdm' });
                } else {
                    loader.value = true;
                    Swal.fire(
                        "Atención!",
                        response.data.message + homilia.value.date + "!",
                        "warning"
                    );
                }
            })
            .catch((error) => {
                loader.value = true;

                let mensaje =
                    'No fue posible guardar la homilía.';

                const backendMessage =
                    error.response?.data?.message || '';

                if (
                    backendMessage.includes(
                        'liturgical_days_slug_unique'
                    )
                ) {

                    mensaje =
                        'Ya existe una homilía con ese título y fecha.';

                }

                else if (
                    backendMessage.includes('audio')
                ) {

                    mensaje =
                        'El archivo de audio no es válido.';

                }

                else if (
                    backendMessage.includes('image') ||
                    backendMessage.includes('img')
                ) {

                    mensaje =
                        'La imagen seleccionada no es válida.';

                }

                Swal.fire({
                    title: 'Ocurrió un error',

                    text: mensaje,

                    icon: 'error',
                    background: '#ffffff',
                    color: '#1f2937',

                    confirmButtonText: 'Entendido',

                    confirmButtonColor: '#ef4444',

                    buttonsStyling: false,

                    customClass: {

                        popup:
                            'rounded-[32px] shadow-2xl border border-gray-100 px-8 py-7',

                        title:
                            'text-2xl font-bold text-gray-800 mt-3',

                        htmlContainer:
                            'text-gray-500 text-sm leading-6',

                        confirmButton:
                            '!bg-red-500 hover:!bg-red-600 !text-white rounded-2xl px-6 py-3 font-semibold shadow-sm transition-all duration-200'
                    }
                });

                console.error(error);

            });
    } else {
        Swal.fire({
            title: 'Campos incompletos',
            html: `
                <div class="mt-2">
                    <p class="text-gray-500 text-sm leading-6">
                        Debes completar los campos requeridos para guardar la homilía.
                    </p>

                    <div class="mt-5 bg-amber-50 border border-amber-100 rounded-2xl p-4 text-left">
                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                <i class="fa-solid fa-circle-exclamation text-amber-500"></i>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800 text-sm">
                                    Campos obligatorios
                                </p>

                                <p class="text-xs text-gray-500 mt-1 leading-5">
                                    Verifica evangelio, imagen, audio y configuración litúrgica.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            `,

            icon: 'warning',
            background: '#ffffff',
            color: '#1f2937',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#f59e0b',

            customClass: {

                popup:
                    'rounded-[32px] shadow-2xl border border-gray-100 px-8 py-7',

                title:
                    'text-3xl font-bold text-gray-800 mt-3',

                htmlContainer:
                    'text-gray-500 text-sm',

                confirmButton:
                    '!bg-amber-500 hover:!bg-amber-600 !text-white rounded-2xl px-6 py-3 font-semibold shadow-sm border-0 focus:outline-none'
            }
        });
    }
};
const volver = () => {
    router.push({ name: 'homilyAllAdm' });
}
const closeAudio = () => {
    audioFile.value = false;
    homilia.value.audio = null;
};
const closeImg = () => {
    homilia.value.img = null;
    selectedImage.value = null;
};

const clearFrm = () => {
    router.push({ name: 'homilyAllAdm' });
    homilia.value.date = "";
    homilia.value.citation = "";
    homilia.value.title = "";
    homilia.value.reading = "";
    homilia.value.gospel = "";
    homilia.value.description = "";
    homilia.value.cycle = "";
    homilia.value.week_number = "";
    homilia.value.celebration_type = "";
    homilia.value.liturgical_time_id = "";
    homilia.value.gospel_id = "";
    homilia.value.img = null;
    homilia.value.audio = null;
    audioFile.value = false;
    selectedImage.value = null;
    solemnity.value = "";
    editorData("");
};
</script>

<style>
#searching_div {
    width: 100%;
}

.input-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.row-icon {
    width: 40px;
    min-width: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #9ca3af;
}

.div-search {
    width: 100%;
}

.row_searching {
    display: inline-flex;
    height: auto;
    width: 100%;
}

.elements:hover {
    background-color: #f7f4f4;
    color: black;
    cursor: default;
}

#input_search {
    width: 100%;
    max-width: 100%;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px 0;
}

.icon-searching {
    color: silver;
}

.icon_row {
    color: silver;
    padding-top: 5px;
}

.result_row {
    width: 100%;
    border: none;
    height: auto;
    padding-left: 1em;
}
</style>