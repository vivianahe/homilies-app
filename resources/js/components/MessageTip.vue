<template>
    <div
        class="message-section"
        v-if="dataHomilyDesc.message"
    >
        <div class="message-card">

            <!-- ÍCONO -->
            <div class="message-icon">
                <i class="fas fa-comment-dots"></i>
            </div>

            <!-- CONTENIDO -->
            <div class="message-content">

                <div class="message-header">

                    <h2 class="message-title">
                        Mensaje del día
                    </h2>

                    <!-- FECHA DEL ÚLTIMO REGISTRO DE BD -->
                    <span
                        class="message-date"
                        v-if="dataHomilyDesc.date"
                    >
                        {{ formatDate(dataHomilyDesc.date) }}
                    </span>

                </div>

                <!-- MENSAJE DEL ÚLTIMO REGISTRO DE BD -->
                <div
                    class="message-text"
                    v-html="dataHomilyDesc.message"
                ></div>

            </div>

            <!-- FRASE DECORATIVA -->
            <div class="message-quote">

                <span>
                    Confía,
                </span>

                <strong>
                    Él guía tus pasos<br>
                    todos los días.
                </strong>

                <div class="quote-line"></div>

            </div>

        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const dataHomilyDesc = ref({
    message: null,
    date: null,
    phrase: null
});


const getHomilyDesc = async () => {

    try {

        const response = await axios.get('/homilies_desc');

        console.log(
            'Respuesta /homilies_desc:',
            response.data
        );

        dataHomilyDesc.value = response.data;

    } catch (error) {

        console.error(
            "Error fetching homilies description:",
            error
        );

    }

};


/*
|--------------------------------------------------------------------------
| FORMATEAR FECHA QUE VIENE DE LA BD
|--------------------------------------------------------------------------
|
| Ejemplo:
| 2026-09-06
|
| Resultado:
| 6 de septiembre de 2026
|
*/

const formatDate = (dateValue) => {

    if (!dateValue) {
        return '';
    }

    /*
     * Separamos la fecha para evitar problemas
     * de zona horaria con new Date("2026-09-06")
     */
    const datePart = String(dateValue).split('T')[0];

    const parts = datePart.split('-');

    if (parts.length !== 3) {
        return dateValue;
    }

    const year = Number(parts[0]);
    const month = Number(parts[1]);
    const day = Number(parts[2]);

    const date = new Date(
        year,
        month - 1,
        day
    );

    return new Intl.DateTimeFormat(
        'es-ES',
        {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }
    ).format(date);

};


onMounted(() => {
    getHomilyDesc();
});
</script>
<style scoped>
*,
*::before,
*::after {
    box-sizing: border-box;
}

/* =========================================================
   CONTENEDOR GENERAL
========================================================= */

.message-section {
    width: 100%;
    max-width: 1380px;
    margin: 35px auto;
    padding: 0 20px;
}


/* =========================================================
   TARJETA PRINCIPAL
========================================================= */

.message-card {
    position: relative;

    display: flex;
    align-items: flex-start;

    width: 100%;
    min-height: 145px;

    padding: 25px 32px;

    overflow: hidden;

    background: linear-gradient(
        110deg,
        #f3f9ff 0%,
        #edf6ff 55%,
        #e8f3ff 100%
    );

    border-radius: 15px;

    box-shadow:
        0 8px 25px rgba(53, 105, 180, 0.08);

    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.message-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 12px 30px rgba(53, 105, 180, 0.12);
}


/* =========================================================
   ÍCONO
========================================================= */

.message-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    width: 70px;
    height: 70px;

    margin-right: 24px;

    color: #ffffff;

    font-size: 30px;

    border-radius: 14px;

    background: linear-gradient(
        145deg,
        #4930f2 0%,
        #661cff 55%,
        #3e1ee8 100%
    );

    box-shadow:
        0 7px 18px rgba(81, 46, 238, 0.20);
}

.message-icon i {
    line-height: 1;
}


/* =========================================================
   CONTENIDO CENTRAL
========================================================= */

.message-content {
    flex: 1;

    min-width: 0;

    padding-top: 1px;

    /*
     * Dejamos este espacio reservado para
     * la frase manuscrita de la derecha.
     */
    padding-right: 220px;
}


/* =========================================================
   ENCABEZADO
========================================================= */

.message-header {
    margin-bottom: 10px;
}

.message-title {
    margin: 0;

    color: #1c0c69;

    font-size: 22px;
    font-weight: 800;
    line-height: 1.2;
}

.message-date {
    display: block;

    margin-top: 5px;

    color: #3458df;

    font-size: 13px;
    font-weight: 500;
    line-height: 1.3;
}


/* =========================================================
   MENSAJE
========================================================= */

.message-text {
    max-width: 900px;

    color: #191451;

    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
}

.message-text :deep(p) {
    margin: 0;
}

.message-text :deep(p + p) {
    margin-top: 5px;
}

.message-text :deep(strong) {
    color: #1c0c69;

    font-weight: 700;
}


/* =========================================================
   FRASE MANUSCRITA DERECHA
========================================================= */

.message-quote {
    position: absolute;

    top: 50%;
    right: 42px;

    width: 180px;

    /*
     * La frase completa queda ligeramente inclinada,
     * igual al diseño de referencia.
     */
    transform:
        translateY(-50%)
        rotate(-5deg);

    transform-origin: center;

    text-align: center;

    color: #26139c;

    pointer-events: none;
}


/* ---------------------------------------------------------
   "Confía,"
--------------------------------------------------------- */

.message-quote span {
    display: block;

    /*
     * Brush Script da un efecto escrito a mano.
     * Segoe Script funciona como respaldo.
     */
    font-family:
        "Brush Script MT",
        "Segoe Script",
        "URW Chancery L",
        cursive;

    font-size: 25px;
    font-weight: 400;
    line-height: 0.95;

    margin: 0 0 2px 0;

    /*
     * Le damos una inclinación independiente
     * para que no se vea demasiado perfecta.
     */
    transform:
        rotate(3deg)
        translateX(5px);

    transform-origin: center;

    letter-spacing: 0;
}


/* ---------------------------------------------------------
   "Él guía tus pasos / todos los días."
--------------------------------------------------------- */

.message-quote strong {
    display: block;

    font-family:
        "Brush Script MT",
        "Segoe Script",
        "URW Chancery L",
        cursive;

    font-size: 24px;
    font-weight: 500;
    line-height: 1.02;

    letter-spacing: 0;

    /*
     * Inclinación ligeramente diferente a "Confía"
     * para conseguir el efecto manuscrito del boceto.
     */
    transform: rotate(-1deg);

    transform-origin: center;
}


/* =========================================================
   LÍNEA MANUSCRITA
========================================================= */

.quote-line {
    position: relative;

    width: 72px;
    height: 3px;

    margin: 10px auto 0;

    background: #3045f4;

    border-radius: 100%;

    /*
     * La línea también queda inclinada,
     * como si estuviera dibujada a mano.
     */
    transform:
        rotate(-6deg)
        translateX(4px);
}


/*
 * Segunda línea muy sutil para evitar
 * que el subrayado se vea completamente geométrico.
 */
.quote-line::after {
    content: "";

    position: absolute;

    left: 7px;
    bottom: -2px;

    width: 56px;
    height: 1px;

    background: rgba(48, 69, 244, 0.45);

    border-radius: 100%;

    transform: rotate(2deg);
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .message-section {
        padding: 0 18px;
    }

    .message-card {
        min-height: 140px;

        padding: 22px 25px;
    }


    /* ICONO */

    .message-icon {
        width: 62px;
        height: 62px;

        margin-right: 18px;

        font-size: 26px;

        border-radius: 13px;
    }


    /* CONTENIDO */

    .message-content {
        padding-right: 175px;
    }


    /* TITULO */

    .message-title {
        font-size: 20px;
    }

    .message-date {
        font-size: 12px;
    }


    /* MENSAJE */

    .message-text {
        font-size: 14px;
        line-height: 1.5;
    }


    /* FRASE */

    .message-quote {
        right: 22px;

        width: 150px;

        transform:
            translateY(-50%)
            rotate(-5deg);
    }

    .message-quote span {
        font-size: 22px;

        transform:
            rotate(3deg)
            translateX(4px);
    }

    .message-quote strong {
        font-size: 20px;
        line-height: 1.03;
    }

    .quote-line {
        width: 62px;
        height: 3px;

        margin-top: 8px;
    }

    .quote-line::after {
        width: 48px;
    }
}


/* =========================================================
   MÓVIL
========================================================= */

@media (max-width: 600px) {

    .message-section {
        width: 100%;

        margin: 22px auto;

        padding: 0 14px;
    }


    /* -----------------------------------------------------
       TARJETA
    ----------------------------------------------------- */

    .message-card {
        min-height: 135px;

        padding: 16px 14px;

        border-radius: 12px;

        align-items: flex-start;
    }


    /* -----------------------------------------------------
       ICONO
    ----------------------------------------------------- */

    .message-icon {
        width: 48px;
        height: 48px;

        margin-right: 11px;

        font-size: 21px;

        border-radius: 10px;
    }


    /* -----------------------------------------------------
       CONTENIDO
    ----------------------------------------------------- */

    .message-content {
        padding-top: 0;

        /*
         * Reservamos el costado derecho
         * para la frase manuscrita.
         */
        padding-right: 90px;
    }


    /* -----------------------------------------------------
       TITULO
    ----------------------------------------------------- */

    .message-header {
        margin-bottom: 7px;
    }

    .message-title {
        font-size: 15px;
        line-height: 1.15;
    }

    .message-date {
        margin-top: 3px;

        font-size: 9px;
        line-height: 1.2;
    }


    /* -----------------------------------------------------
       MENSAJE
    ----------------------------------------------------- */

    .message-text {
        max-width: 100%;

        font-size: 10px;
        line-height: 1.4;
    }


    /* -----------------------------------------------------
       FRASE MANUSCRITA
    ----------------------------------------------------- */

    .message-quote {
        top: 52%;
        right: 7px;

        width: 82px;

        transform:
            translateY(-50%)
            rotate(-6deg);
    }

    .message-quote span {
        margin-bottom: 1px;

        font-size: 15px;
        line-height: 0.95;

        transform:
            rotate(3deg)
            translateX(2px);
    }

    .message-quote strong {
        font-size: 13px;
        font-weight: 500;
        line-height: 1.03;

        transform: rotate(-1deg);
    }


    /* -----------------------------------------------------
       SUBRAYADO
    ----------------------------------------------------- */

    .quote-line {
        width: 43px;
        height: 2px;

        margin-top: 6px;

        transform:
            rotate(-7deg)
            translateX(2px);
    }

    .quote-line::after {
        left: 4px;
        bottom: -1px;

        width: 34px;
        height: 1px;
    }
}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 380px) {

    .message-section {
        padding: 0 10px;
    }

    .message-card {
        min-height: 130px;

        padding: 14px 11px;
    }


    /* ICONO */

    .message-icon {
        width: 42px;
        height: 42px;

        margin-right: 9px;

        font-size: 18px;

        border-radius: 9px;
    }


    /* CONTENIDO */

    .message-content {
        padding-right: 72px;
    }


    /* TITULO */

    .message-title {
        font-size: 13px;
    }

    .message-date {
        font-size: 8px;
    }


    /* MENSAJE */

    .message-text {
        font-size: 9px;
        line-height: 1.35;
    }


    /* FRASE */

    .message-quote {
        top: 52%;
        right: 4px;

        width: 67px;

        transform:
            translateY(-50%)
            rotate(-6deg);
    }

    .message-quote span {
        font-size: 12px;

        transform:
            rotate(3deg)
            translateX(1px);
    }

    .message-quote strong {
        font-size: 10.5px;
        line-height: 1.05;
    }


    /* LINEA */

    .quote-line {
        width: 35px;
        height: 2px;

        margin-top: 5px;
    }

    .quote-line::after {
        width: 27px;
    }
}
</style>