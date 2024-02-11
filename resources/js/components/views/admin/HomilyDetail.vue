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
                
                <div v-if="homilia.messag !== null">
                    <p class="text-lg font-bold text-gray-200">Mensaje del día:  </p>
                    <div class="mb-8 text-lg font-normal text-gray-200 ul_tet" v-html="homilia.messag"></div>
                </div>
                <div class="py-4 flex justify-center">
                    <audio controls class="text-center">
                        <source v-if="homilia.audio" :src="homilia.audio" type="audio/mp3" />
                        Tu navegador no admite el elemento de audio.
                    </audio>
                </div>

                <div class="w-3/4 mx-auto">
                    <img :src="homilia.img" alt="" class="w-full h-full object-cover">
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
    messag: "",
    user_id: user_id ? user_id : null,
});


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
            homilia.value.messag = response.data.message;
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
<style scoped>
*,
*::before,
*::after {
    box-sizing: border-box;
}

.main {
    max-width: 1000px;
    margin: 30px auto;
}

.cardst {
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.cardst_item {
    display: flex;
    align-content: center;
    justify-content: center;
}


.card {
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    background-color: #2A8EB8;
    border-radius: 5px 25px 5px 50px;
    transition: transform 0.1s linear, box-shadow 0.2s;

}

.card_text:focus,
.card:focus {
    outline: 2px dashed transparent;
}

.card:focus,
.card:hover {
    transform: scale(1.01);
    box-shadow: 0 10px 5px -5px rgba(0, 0, 0, 0.2);
}

.card_content {
    padding: 0.5rem 1rem 1rem;
    color: #FFF;
    width: 100%;
}

.card_title {
    position: absolute;
    top: 0;
    right: 0;
    left: 18px;
    width: 100%;
    height: auto;
    color: #0072ae;
    padding: 0.5rem;
    border-radius: 5px 0 0 5px;
    transform: rotate(-3.3deg);
    transform-origin: left top;
    font-weight: 600;
    font-size: 1.325rem;
    position: relative;
    overflow: hidden;
    z-index: 1;
    background-color: #e6f4f1;
}

.card_text {
    padding: 0 1rem;
    margin-top: 10px;
}

.card_text p:first-of-type:first-letter {
    font-size: 1.325rem;
    margin-right: 0.05em;
    margin-top: 30px;
    ;
}

.p {
    margin-top: 20px;
}

@media (min-width: 480px) {
    .card_text {
        overflow: auto;
        max-height: 20rem;
        scrollbar-width: thin;
        scrollbar-color: #b4fee7 #0072ae;
    }

    .card_text::-webkit-scrollbar {
        width: 12px;
    }

    .card_text::-webkit-scrollbar-track {
        background: #0072ae;
    }

    .card_text::-webkit-scrollbar-thumb {
        background-color: #b4fee7;
    }
}

.card_text strong {
    color: #b4fee7;
}

@keyframes fly-in {
    0% {
        top: 0;
        right: 0;
        font-size: 1.325rem;
    }

    25% {
        top: 0;
        right: -200%;
        font-size: 1.325rem;
    }

    26% {
        font-size: 2rem;
    }

    100% {
        top: 2rem;
        right: 0;
        font-size: 2rem;
    }
}

@keyframes fly-out {
    0% {
        top: 2rem;
        right: 0;
        font-size: 2rem;
    }

    50% {
        top: 0;
        right: -200%;
        font-size: 1.325rem;
    }

    100% {
        top: 0;
        right: 0;
        font-size: 1.325rem;
    }
}</style>