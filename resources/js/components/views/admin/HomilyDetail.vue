<template>
    <div class="p-4 sm:ml-64 mt-16">
        <div class="flex justify-between">
            <div class="cursor-pointer">
                <svg @click="volver" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                </svg>
            </div>
            <div>
                <p class="text-xl mb-3 font-semibold">Detalle Homilía</p>
            </div>
            <div></div>
        </div>

        <section class="bg-gray-500">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-left lg:py-16">
                <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none md:text-3xl lg:text-2xl text-white">{{
                    homilia.title }}</h1>
                <div class="flex justify-between">
                    <p class="text-lg font-normal text-gray-200">{{ homilia.reading }} </p>
                    <p class="text-lg text-gray-300 font-extrabold">{{ homilia.date }}</p>
                </div>
                <p class="mb-8 text-lg text-gray-300 font-extrabold">{{ homilia.citation }}</p>
                <p class="mb-8 text-lg font-normal text-gray-200" v-html="homilia.gospel"></p>
                <div class="py-4 flex justify-center">
                    <audio controls class="text-center">
                        <source v-if="homilia.audio" :src="homilia.audio"
                            type="audio/mp3, audio/mp4" />
                        Tu navegador no admite el elemento de audio.
                    </audio>
                </div>

                <div class="w-3/4 mx-auto">
                    <img :src="homilia.img" alt="" class="w-full">
                </div>
            </div>
        </section>

        <hr>
        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
            <button type="button" @click="volver"
                class="cursor-pointer uppercase text-gray-800 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
                Cancelar
            </button>
        </div>
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
    reading: "",
    gospel: "",
    img: null,
    audio: null,
    user_id: user_id ? user_id : null,
});


const volver = () => {
    router.push({ name: 'homilyAllAdm' });
}

const getData = () => {
    axios
        .get('/getHomeliasId/'+HomilyId)
        .then((response) => {
            homilia.value.id = response.data.id;
            homilia.value.date = response.data.date;
            homilia.value.citation = response.data.citation;
            homilia.value.title = response.data.title;
            homilia.value.reading = response.data.reading;
            homilia.value.gospel = response.data.gospel;
            homilia.value.img = "/support/imgHomily/" + response.data.img;
            homilia.value.audio = "/support/audioHomily/" + response.data.audio;
        })
        .catch((error) => {
            console.error(error);
        });
}
onMounted(() => {
    getData();
})
</script>