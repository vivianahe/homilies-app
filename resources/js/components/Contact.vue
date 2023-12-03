<template>
  <section class="bg-custom-blue-li">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
      <div class="grid md:grid-cols-2 gap-8">
        <div
          class="bg-custom-blue-li border-gray-200 rounded-lg p-8 md:p-12 justify-center items-center text-center relative mx-auto">
          <figure class="max-w-sm relative z-10">
            <img class="h-auto w-full rounded-lg mx-auto" src="/img/fotourl.jpg" alt="Sacerdote Uriel" />
          </figure>

          <div class="absolute bottom-16 left-0 bg-gray-200 rounded-lg w-1/2 h-1/2 cuadro_gris">
            <!-- Contenido del cuadro gris (#F2F3F4) -->
          </div>

          <div class="absolute top-0 right-48 bg-custom-blue rounded-lg w-1/2 h-1/2 cuadro_azul">
            <!-- Contenido del cuadro azul (#0072AE) -->
          </div>
        </div>

        <div class="bg-custom-blue-li border-gray-200 rounded-lg p-8 md:p-12">
          <h2 class="text-3xl font-bold mb-2 text-custom-text">Asesorías de familia</h2>
          <h2 class="text-2xl font-semibold mb-2 text-custom-text">Contáctanos</h2>

          <form @submit.prevent="submitForm">
            <div class="mb-6">
              <input type="text" id="name"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Nombre completo" v-model="formData.name" required />
            </div>
            <div class="mb-6">
              <input type="email" id="email"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Correo electrónico" v-model="formData.email" required />
            </div>
            <div class="mb-6">
              <input type="text" id="name"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Teléfono" v-model="formData.phone" required />
            </div>
            <div class="flex items-start mb-6">
              <textarea
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                rows="4" placeholder="Mensaje" required v-model="formData.message"></textarea>
            </div>
            <button v-if="loader" type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
              Enviar
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
              Enviando...
            </button>

            <div v-if="showAlert" class="bg-gray-800 text-white p-4 fixed top-0 left-0 right-0">
              <p>
                ¡La información se ha enviado correctamente! Pronto nos
                contactaremos
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
const showAlert = ref(false);
const loader = ref(true);

const formData = ref({
  name: "",
  email: "",
  phone: "",
  message: "",
});

const submitForm = () => {
  loader.value = false;
  axios
    .post('/contact', formData.value)
    .then((response) => {
      formData.value.name = "";
      formData.value.email = "";
      formData.value.phone = "";
      formData.value.message = "";
      showAlert.value = true;
      loader.value = true;

      // Oculta automáticamente la alerta después de 5 segundos
      setTimeout(() => {
        showAlert.value = false;
        loader.value = true;
      }, 5000);
    })
    .catch((error) => {
      console.error(error);
    });
};
</script>

<style scoped>
@media (min-width: 1101px) {
  .cuadro_gris {
    left: 10px !important;
    bottom: 50px !important;
    width: 60% !important;
    height: 50% !important;
  }

  .cuadro_azul {
    top: -10px !important;
    right: 100px !important;
    width: 60% !important;
    height: 50% !important;
  }
}

@media (max-width: 1100px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 50px !important;
    width: 60% !important;
    height: 50% !important;
  }

  .cuadro_azul {
    top: -10px !important;
    right: 100px !important;
    width: 60% !important;
    height: 50% !important;
  }
}

@media (max-width: 1000px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 50px !important;
    width: 60% !important;
    height: 40% !important;
  }

  .cuadro_azul {
    top: -10px !important;
    right: 70px !important;
    width: 60% !important;
    height: 40% !important;
  }
}

@media (max-width: 950px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 100px !important;
    width: 60% !important;
    height: 40% !important;
  }

  .cuadro_azul {
    top: -10px !important;
    right: 70px !important;
    width: 60% !important;
    height: 40% !important;
  }
}

@media (max-width: 900px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 120px !important;
    width: 60% !important;
    height: 45% !important;
  }

  .cuadro_azul {
    top: 0px !important;
    right: 70px !important;
    width: 60% !important;
    height: 40% !important;
  }
}

@media (max-width: 850px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 140px !important;
    width: 60% !important;
    height: 45% !important;
  }

  .cuadro_azul {
    top: 0px !important;
    right: 70px !important;
    width: 60% !important;
    height: 40% !important;
  }
}

@media (max-width: 800px) {

  .cuadro_gris {
    left: 10px !important;
    bottom: 170px !important;
    width: 60% !important;
    height: 45% !important;
  }

  .cuadro_azul {
    top: 5px !important;
    right: 70px !important;
    width: 60% !important;
    height: 40% !important;
  }
}

@media (max-width: 767px) {

  .cuadro_gris {
    left: -20px !important;
    bottom: -25px !important;
    width: 70% !important;
    height: 60% !important;
  }

  .cuadro_azul {
    top: -10px !important;
    right: 60px !important;
    width: 70% !important;
    height: 60% !important;
  }
}

@media (max-width: 500px) {
  .cuadro_gris {
    display: none;
  }

  .cuadro_azul {
    display: none;
  }
}</style>