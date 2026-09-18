<template>

    <section class="hero">

        <!-- IMAGEN PRINCIPAL -->
        <img
            src="/img/carousel/banner.png"
            class="hero-image"
            alt="Evangelio del día"
        />

        <!-- DEGRADADO -->
        <div class="hero-overlay"></div>

        <!-- CONTENIDO -->
        <div class="hero-content">

            <div class="hero-information">

                <div class="hero-line"></div>

                <div class="hero-text">

                    <h1>
                        Evangelio del día
                    </h1>

                    <!-- FECHA DE LA ÚLTIMA HOMILÍA -->
                    <p
                        v-if="dataHomilyDesc.date"
                        class="hero-week"
                    >
                        {{ convertirFecha(dataHomilyDesc.date) }}
                    </p>

                    <!-- EVANGELIO DE LA ÚLTIMA HOMILÍA -->
                    <p
                        v-if="sanitizedGospel"
                        class="hero-description"
                        v-html="sanitizedGospel"
                    ></p>

                </div>

            </div>

            <!-- ESCUCHAR ÚLTIMA HOMILÍA -->
            <RouterLink
                v-if="dataHomilyDesc.id"
                :to="{
                    name: 'HomilyDetailNew',
                    params: {
                        id: dataHomilyDesc.id
                    }
                }"
                class="listen-button"
            >

                <span class="listen-icon">
                    <i class="fa-solid fa-play"></i>
                </span>

                <span>
                    Escuchar ahora
                </span>

            </RouterLink>

        </div>

    </section>

</template>

<script setup>

import {
    ref,
    computed,
    onMounted
} from "vue";

import { RouterLink } from "vue-router";

import axios from "axios";

import DOMPurify from "dompurify";


/* =========================================================
   ÚLTIMA HOMILÍA
========================================================= */

const dataHomilyDesc = ref({});


/* =========================================================
   CONSULTAR ÚLTIMA HOMILÍA
========================================================= */

const getHomilyDesc = async () => {

    try {

        const { data } = await axios.get(
            "/homilies_desc"
        );

        /*
         * Tu endpoint anteriormente devolvía directamente
         * el objeto correspondiente a la última homilía.
         */
        dataHomilyDesc.value = data || {};

    } catch (error) {

        console.error(
            "Error al obtener la última homilía:",
            error
        );

        dataHomilyDesc.value = {};

    }

};


/* =========================================================
   CONVERTIR FECHA
========================================================= */

const convertirFecha = (fecha) => {

    if (!fecha) {
        return "";
    }

    const fechaParts = fecha.split("-");

    const year = parseInt(fechaParts[0]);
    const month = parseInt(fechaParts[1]);
    const day = parseInt(fechaParts[2]);


    const meses = [

        "enero",
        "febrero",
        "marzo",
        "abril",
        "mayo",
        "junio",
        "julio",
        "agosto",
        "septiembre",
        "octubre",
        "noviembre",
        "diciembre"

    ];


    return `${day} de ${meses[month - 1]} de ${year}`;

};


/* =========================================================
   EVANGELIO
========================================================= */

const maxLength = 180;


const truncatedGospel = computed(() => {

    const gospel =
        dataHomilyDesc.value?.gospel || "";


    if (!gospel) {
        return "";
    }


    if (gospel.length <= maxLength) {
        return gospel;
    }


    return gospel.slice(
        0,
        maxLength
    ) + "...";

});


/* =========================================================
   SANITIZAR HTML
========================================================= */

const sanitizedGospel = computed(() => {

    return DOMPurify.sanitize(
        truncatedGospel.value
    );

});


/* =========================================================
   CARGAR INFORMACIÓN
========================================================= */

onMounted(() => {

    getHomilyDesc();

});

</script>


<style scoped>

/* =========================================================
   HERO GENERAL
========================================================= */

.hero {
    position: relative;

    width: 100%;
    max-width: none;

    /* Más altura para apreciar mejor el banner */
    height: 380px;

    margin: 0;

    overflow: hidden;

    border-radius: 0;

    background: #f8fafc;
}


/* =========================================================
   IMAGEN PRINCIPAL
========================================================= */

.hero-image {
    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    /* Ajuste del encuadre del banner */
    object-position: center 58%;

    user-select: none;
    pointer-events: none;
}


/* =========================================================
   DEGRADADO DESKTOP
========================================================= */

/* =========================================================
   DEGRADADO DESKTOP - MÁS SUTIL
========================================================= */

.hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;

    pointer-events: none;

    background: linear-gradient(
        90deg,

        /* Blanco fuerte únicamente detrás del texto */
        rgba(255, 255, 255, 0.98) 0%,
        rgba(255, 255, 255, 0.96) 8%,
        rgba(255, 255, 255, 0.90) 16%,

        /* Empieza a desaparecer antes */
        rgba(255, 255, 255, 0.72) 23%,
        rgba(255, 255, 255, 0.42) 30%,
        rgba(255, 255, 255, 0.16) 37%,

        /* Desde aquí prácticamente vemos la imagen original */
        rgba(255, 255, 255, 0.04) 43%,
        rgba(255, 255, 255, 0) 48%
    );
}


/* =========================================================
   CONTENIDO
========================================================= */

.hero-content {
    position: absolute;
    z-index: 2;

    left: 6.5%;
    top: 50%;

    transform: translateY(-50%);

    display: flex;
    align-items: center;

    gap: clamp(55px, 7vw, 120px);
}


/* =========================================================
   INFORMACIÓN
========================================================= */

.hero-information {
    display: flex;

    align-items: stretch;

    gap: 20px;

    width: 390px;
}


/* =========================================================
   LÍNEA AZUL
========================================================= */

.hero-line {
    width: 3px;

    min-height: 120px;

    flex-shrink: 0;

    border-radius: 999px;

    background:
        linear-gradient(
            180deg,
            #2450ff 0%,
            #5537ff 100%
        );
}


/* =========================================================
   TEXTO
========================================================= */

.hero-text {
    width: 100%;
}

.hero-text h1 {
    margin: 0 0 9px;

    color: #071a58;

    font-size: 21px;
    font-weight: 800;

    line-height: 1.2;
}


/* =========================================================
   FECHA
========================================================= */

.hero-week {
    margin: 0 0 18px;

    color: #1646e8;

    font-size: 15px;
    font-weight: 700;

    line-height: 1.4;
}


/* =========================================================
   DESCRIPCIÓN
========================================================= */

.hero-description {
    max-width: 320px;

    margin: 0;

    color: #20355f;

    font-size: 14px;
    font-weight: 400;

    line-height: 1.65;
}

.hero-description :deep(p) {
    margin: 0;
}


/* =========================================================
   BOTÓN ESCUCHAR
========================================================= */

.listen-button {
    min-height: 52px;

    padding: 0 25px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 11px;

    flex-shrink: 0;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #273df2 0%,
            #6636ff 100%
        );

    color: #ffffff;

    font-size: 14px;
    font-weight: 700;

    line-height: 1;

    text-decoration: none;

    box-shadow:
        0 10px 25px rgba(75, 55, 245, .28);

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.listen-button:hover {
    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 14px 30px rgba(75, 55, 245, .35);
}


/* =========================================================
   ICONO PLAY
========================================================= */

.listen-icon {
    width: 21px;
    height: 21px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;

    background: #ffffff;

    color: #4438f5;

    font-size: 8px;
}

.listen-icon i {
    margin-left: 1px;
}


/* =========================================================
   DESKTOP MEDIANO
========================================================= */

@media (min-width: 1600px) {

    .hero {
        height: 400px;
    }

    .hero-content {
        left: 7.5%;
    }

    .hero-information {
        width: 420px;
    }

    .hero-description {
        max-width: 340px;
    }
}



@media (max-width: 1200px) {

    .hero-content {
        left: 6%;

        gap: 45px;
    }

    .hero-information {
        width: 350px;
    }

    .hero-description {
        max-width: 290px;
    }
}


/* =========================================================
   TABLET + MÓVIL
========================================================= */

@media (max-width: 900px) {

    .hero {
        width: 100%;

        height: 390px;

        margin: 0;

        border-radius: 0;

        background: #eef3f8;
    }


    /* IMAGEN */

    .hero-image {
        width: 100%;
        height: 100%;

        object-fit: cover;

        object-position: 58% center;
    }


    /* OVERLAY */

    .hero-overlay {
        background:
            linear-gradient(
                180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0) 50%,
                rgba(5, 18, 45, .03) 72%,
                rgba(5, 18, 45, .10) 100%
            );
    }


    /* TARJETA */

    .hero-content {
        left: 50%;
        top: auto;
        bottom: 26px;

        width: calc(100% - 76px);
        max-width: 330px;

        transform: translateX(-50%);

        display: flex;
        flex-direction: column;
        align-items: flex-start;

        gap: 0;

        padding: 19px 20px;

        background:
            rgba(255, 255, 255, .96);

        border:
            1px solid
            rgba(255, 255, 255, .90);

        border-radius: 18px;

        box-shadow:
            0 14px 34px rgba(15, 35, 90, .16);

        backdrop-filter: blur(7px);

        -webkit-backdrop-filter: blur(7px);
    }


    /* INFORMACIÓN */

    .hero-information {
        display: block;

        width: 100%;
    }

    .hero-line {
        display: none;
    }

    .hero-text {
        width: 100%;
    }


    /* TÍTULO */

    .hero-text h1 {
        margin: 0 0 5px;

        color: #071a58;

        font-size: 18px;

        font-weight: 800;

        line-height: 1.2;
    }


    /* FECHA */

    .hero-week {
        margin: 0 0 11px;

        color: #1646e8;

        font-size: 12px;

        font-weight: 700;

        line-height: 1.35;
    }


    /* DESCRIPCIÓN */

    .hero-description {
        width: 100%;

        max-width: none;

        margin: 0;

        color: #20355f;

        font-size: 11.5px;

        font-weight: 400;

        line-height: 1.48;
    }

    .hero-description :deep(p) {
        margin: 0;
    }


    /* BOTÓN */

    .listen-button {
        min-height: 42px;

        margin-top: 13px;

        padding: 0 17px;

        gap: 8px;

        border-radius: 11px;

        font-size: 11.5px;

        box-shadow:
            0 8px 20px rgba(75, 55, 245, .25);
    }

    .listen-icon {
        width: 19px;
        height: 19px;

        font-size: 7px;
    }
}


/* =========================================================
   MÓVIL
========================================================= */

@media (max-width: 480px) {

    .hero {
        width: 100%;

        height: 385px;

        margin: 0;

        border-radius: 0;
    }


    /* IMAGEN */

    .hero-image {
        width: 100%;
        height: 100%;

        object-fit: cover;

        object-position: 61% center;
    }


    /* OVERLAY */

    .hero-overlay {
        background:
            linear-gradient(
                180deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0) 55%,
                rgba(5, 18, 45, .03) 75%,
                rgba(5, 18, 45, .09) 100%
            );
    }


    /* TARJETA */

    .hero-content {
        left: 50%;

        top: auto;

        bottom: 24px;

        width: calc(100% - 82px);

        max-width: 310px;

        transform: translateX(-50%);

        padding: 18px 18px 17px;

        border-radius: 17px;

        background:
            rgba(255, 255, 255, .96);

        box-shadow:
            0 12px 30px rgba(15, 35, 90, .17);
    }


    /* INFORMACIÓN */

    .hero-information {
        width: 100%;
    }

    .hero-line {
        display: none;
    }


    /* TÍTULO */

    .hero-text h1 {
        margin: 0 0 5px;

        font-size: 17px;

        line-height: 1.2;
    }


    /* FECHA */

    .hero-week {
        margin: 0 0 10px;

        font-size: 11.5px;

        line-height: 1.35;
    }


    /* DESCRIPCIÓN */

    .hero-description {
        width: 100%;

        max-width: none;

        margin: 0;

        font-size: 11px;

        line-height: 1.48;
    }

    .hero-description :deep(p) {
        margin: 0;
    }


    /* BOTÓN */

    .listen-button {
        min-height: 40px;

        margin-top: 12px;

        padding: 0 15px;

        gap: 8px;

        border-radius: 10px;

        font-size: 11px;
    }

    .listen-icon {
        width: 18px;
        height: 18px;

        font-size: 6.5px;
    }
}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 380px) {

    .hero {
        height: 365px;
    }

    .hero-image {
        object-position: 62% center;
    }

    .hero-content {
        bottom: 22px;

        width: calc(100% - 58px);

        max-width: 300px;

        padding: 16px 17px;

        border-radius: 16px;
    }

    .hero-text h1 {
        font-size: 16px;
    }

    .hero-week {
        margin-bottom: 9px;

        font-size: 11px;
    }

    .hero-description {
        font-size: 10.5px;

        line-height: 1.45;
    }

    .listen-button {
        min-height: 39px;

        margin-top: 11px;

        padding: 0 14px;

        font-size: 10.5px;
    }

    .listen-icon {
        width: 17px;
        height: 17px;
    }
}

</style>