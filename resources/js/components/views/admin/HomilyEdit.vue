<template>
    <div v-if="loading" class="fixed inset-0 flex justify-center items-center z-50">
        <LoaderVue :isLoading="loading" class="mx-auto"></LoaderVue>
    </div>
    <div class="p-4 sm:ml-64 mt-16">
        <div class="flex justify-between">
            <div>
                <svg @click="volver" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                </svg>
            </div>
            <div>
                <p class="text-xl mb-3 font-semibold">Editar Homilía</p>
            </div>
            <div></div>
        </div>
        <hr>
        <form class="mt-4" @submit.prevent="submit">
            <Alerta v-if="alerta.mensaje" :alerta="alerta" />
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Fecha Homilía</label>
                    <input type="date" id="date"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required v-model="homilia.date" />
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label for="citation" class="block mb-2 text-sm font-medium text-gray-900">Cita Bíblica</label>
                    <input type="text" id="citation"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required v-model="homilia.citation" />
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Título</label>
                    <input type="text" id="title"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required v-model="homilia.title" />
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label for="reading" class="block mb-2 text-sm font-medium text-gray-900">Lectura</label>
                    <input type="text" id="reading"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required v-model="homilia.reading" />
                </div>
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Evangelio</label>
                <Editor @editor-data="editorData" :dataUpdate="homilia.gospel" @activeLoader="activeLoader" />
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Imagen</label>
                <div v-if="selectedImage" class="relative">
                    <button class="absolute top-4 right-4 bg-red-500 text-white px-3 py-2 rounded-full" @click="closeImg">
                        X
                    </button>
                    <img :src="selectedImage" alt="Imagen seleccionada"
                        class="max-w-full h-auto rounded border bg-white p-1 object-cover" />
                </div>

                <label v-else for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x text-gray-500"></i>
                        <p class="text-xs text-gray-500 mt-2">SVG, PNG, JPG, JPEG</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" v-on:change="handleFileChange"
                        accept=".svg, .png, .jpg, .gif, .jpeg" />
                </label>
            </div>
            <div class="mb-6">
                <label for="audio" class="block mb-2 text-sm font-medium text-gray-900">Audio</label>
                <div v-if="shouldShowAudio" class="flex items-center">
                    <audio controls class="text-center">
                        <source :src="'/support/audioHomily/' + homilia.audio" type="audio/mp4" />
                        Tu navegador no admite el elemento de audio.
                    </audio>
                    <button class="bg-red-500 text-white px-3 py-2 rounded-full ml-2" @click="closeAudio">
                        X
                    </button>
                </div>
                <div v-else class="relative">
                    <label title="Click to upload" for="button2"
                        class="cursor-pointer flex items-center gap-4 px-6 py-4 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed">
                        <div class="w-max relative">
                            <i class="fa-solid fa-upload fa-2x text-gray-700"></i>
                        </div>
                        <div class="relative">
                            <span class="block text-base font-semibold relative text-gray-700">
                                Subir audio
                            </span>
                        </div>
                    </label>
                    <input hidden="" type="file" name="button2" id="button2" v-on:change="handleAudioChange"
                        accept="audio/*" />
                </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                <button v-if="loader" type="submit"
                    class="uppercase text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
                    Agregar
                </button>
                <button v-else disabled type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="#E5E7EB" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor" />
                    </svg>
                    Guardando...
                </button>
                <button type="button" @click="clearFrm"
                    class="uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
                    Cancelar
                </button>
            </div>
        </form>

    </div>
</template>

<script setup>
import Editor from "../../Admin/Editor.vue";
import LoaderVue from '../../Admin/Loader.vue';
import { ref, reactive, computed, onMounted } from "vue";
import Alerta from "../../Admin/Alerta.vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";

const user_id = localStorage.getItem("user_id");
const emit = defineEmits(["getData"]);
const selectedImage = ref(null);
const audioFile = ref(null);
const audioPlayer = ref(null);
const loader = ref(true);
const loading = ref(false);


const router = useRouter();
const route = useRoute();
const HomilyId = route.params.id;

const homilia = ref({
    id: null,
    date: "",
    citation: "",
    title: "",
    reading: "",
    gospel: "",
    img: null,
    audio: null,
    user_id: user_id ? user_id : null,
});
const alerta = reactive({
    tipo: "",
    mensaje: "",
});
const handleFileChange = (event) => {
    // Cuando se selecciona un archivo, actualiza la propiedad 'img' con el objeto File
    homilia.value.img = event.target.files[0];
    const file = event.target.files[0];
    if (file) {
        // Crear una URL temporal para la imagen seleccionada
        selectedImage.value = URL.createObjectURL(file);
    }
};
const handleAudioChange = (event) => {
    homilia.value.audio = event.target.files[0];
    audioFile.value = event.target.files[0];
    playAudio();
};

const playAudio = () => {
    if (audioFile.value && audioPlayer.value) {
        audioPlayer.value.src = URL.createObjectURL(audioFile.value);
        audioPlayer.value.play(); // Iniciar la reproducción
    }
};
const shouldShowAudio = computed(() => !!audioFile.value);

const editorData = (text = "") => {
    //Texto del editor
    homilia.value.gospel = text;
};

const activeLoader = (active) => {
    loading.value = active;
}

const submit = () => {
    // Crear un objeto FormData para manejar la solicitud
    const formData = new FormData();
    formData.append("id", HomilyId);
    formData.append("date", homilia.value.date);
    formData.append("citation", homilia.value.citation);
    formData.append("title", homilia.value.title);
    formData.append("reading", homilia.value.reading);
    formData.append("gospel", homilia.value.gospel);
    formData.append("user_id", homilia.value.user_id);
    formData.append("img", homilia.value.img);
    formData.append("audio", homilia.value.audio);

    // Configurar las cabeceras de la solicitud
    const config = {
        headers: {
            "content-type": "multipart/form-data"
        },
    };
    if (
        homilia.value.gospel !== "" &&
        homilia.value.img !== null &&
        homilia.value.audio !== null
    ) {
        loader.value = false;
        axios
            .post('/updateHomilia', formData, config)
            .then((response) => {
                if (response.data.data === false) {
                    Swal.fire("Correcto!", response.data.message, "success");
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
                console.error(error);
            });
    } else {
        loader.value = true;
        Swal.fire(
            "Atención!",
            "Todos los campos deben se diligenciados!",
            "warning"
        );
    }
};
const volver = () => {
    router.push({ name: 'homilyAllAdm' });
}
const closeAudio = () => {
    // Actualiza audioFile.value para que shouldShowAudio sea false
    audioFile.value = false;
    homilia.value.audio = null;
};
const closeImg = () => {
    homilia.value.img = null;
    selectedImage.value = null;
};

const clearFrm = () => {
    router.push({ name: 'homilyAllAdm' });
};

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
            homilia.value.img = response.data.img;
            emit('editor-data', response.data.gospel);
            selectedImage.value = "/support/imgHomily/" + response.data.img;
            homilia.value.audio = response.data.audio;
            audioFile.value = "/support/audioHomily/" + response.data.audio;
        })
        .catch((error) => {
            console.error(error);
        });
}
onMounted(() => {
    getData();
})
</script>

<style scoped>
.loader {
    width: 50px;
    padding: 8px;
    aspect-ratio: 1;
    border-radius: 50%;
    background: #25b09b;
    --_m:
        conic-gradient(#0000 10%, #000),
        linear-gradient(#000 0 0) content-box;
    -webkit-mask: var(--_m);
    mask: var(--_m);
    -webkit-mask-composite: source-out;
    mask-composite: subtract;
    animation: l3 1s infinite linear;
}

@keyframes l3 {
    to {
        transform: rotate(1turn)
    }
}
</style>