<template >
    <div class="main mt-3" v-if="dataHomilyDesc.message !== null">
        <ul class="cardst">
            <li class="cardst_item">
                <div class="card" tabindex="0">
                    <div class="card_content">
                        <h2 class="card_title md:text-2xl">Mensaje del día</h2>
                        <div class="card_text">
                            <p class="text-md text-black-50 ul_tet" v-html="dataHomilyDesc.message"></p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
const dataHomilyDesc = ref([]);
const getHomilyDesc = async () => {
    try {
        const response = await axios.get('/homilies_desc');
        dataHomilyDesc.value = response.data;
    } catch (error) {
        console.error("Error fetching homilies description:", error);
    }
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