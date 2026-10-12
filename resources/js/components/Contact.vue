<template>
  <section class="family-section">
    <div class="family-container">

      <!-- =========================
           IMAGEN / LADO IZQUIERDO
      ========================== -->
      <div class="family-visual">

        <!-- Decoraciones -->
        <div class="shape shape-top"></div>
        <div class="shape shape-back"></div>

        <div class="dots">
          <span v-for="n in 20" :key="n"></span>
        </div>

        <!-- Imagen -->
        <div class="photo-wrapper">
          <img
            src="/img/fotourl.jpg"
            alt="Sacerdote Uriel"
            class="family-photo"
          />
        </div>

        <!-- Frase -->
        <div class="quote-card">
          <div class="quote-icon">“</div>

          <p>
            Acompañar a<br />
            las familias también<br />
            es una forma de<br />
            servir a Dios.
          </p>

          <div class="quote-line"></div>
        </div>

        <!-- Icono familias -->
        <div class="family-icon">
          <i class="fas fa-users"></i>
        </div>

      </div>

      <!-- =========================
           FORMULARIO / LADO DERECHO
      ========================== -->
      <div class="family-content">

        <div class="section-label">
          <span>ASESORÍAS DE FAMILIA</span>
          <div class="label-line"></div>
        </div>

        <h2 class="family-title">
          Contáctanos
        </h2>

        <p class="family-description">
          Si deseas una orientación o acompañamiento en temas de familia,
          puedes escribirnos. Estaremos felices de escucharte.
        </p>

        <form @submit.prevent="submitForm" class="family-form">

          <!-- Nombre + correo -->
          <div class="form-row">

            <div class="input-group">
              <i class="fas fa-user"></i>

              <input
                type="text"
                placeholder="Nombre completo"
                v-model="formData.name"
                required
              />
            </div>

            <div class="input-group">
              <i class="fas fa-envelope"></i>

              <input
                type="email"
                placeholder="Correo electrónico"
                v-model="formData.email"
                required
              />
            </div>

          </div>

          <!-- Teléfono -->
          <div class="input-group">
            <i class="fas fa-phone"></i>

            <input
              type="text"
              placeholder="Teléfono"
              v-model="formData.phone"
              required
            />
          </div>

          <!-- Mensaje -->
          <div class="input-group textarea-group">
            <i class="fas fa-comment-dots"></i>

            <textarea
              rows="4"
              placeholder="Mensaje"
              v-model="formData.message"
              required
            ></textarea>
          </div>

          <!-- Botón -->
          <button
            v-if="loader"
            type="submit"
            class="submit-button"
          >
            <i class="fas fa-paper-plane"></i>
            <span>Enviar mensaje</span>
          </button>

          <button
            v-else
            type="button"
            disabled
            class="submit-button loading-button"
          >
            <svg
              aria-hidden="true"
              role="status"
              class="spinner"
              viewBox="0 0 100 101"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.4013 9.08144 50.5908Z"
                fill="rgba(255,255,255,.35)"
              />
              <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentColor"
              />
            </svg>

            <span>Enviando...</span>
          </button>

        </form>

      </div>

    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

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
    .post("/contact", formData.value)
    .then((response) => {
      formData.value.name = "";
      formData.value.email = "";
      formData.value.phone = "";
      formData.value.message = "";

      loader.value = true;

      Swal.fire(
        "Correcto!",
        "¡La información se ha enviado correctamente! Pronto te contactaremos.",
        "success"
      );
    })
    .catch((error) => {
      console.error(error);
      loader.value = true;
    });
};
</script>

<style scoped>

/* =========================================================
   SECCIÓN
========================================================= */

.family-section {
  position: relative;
  width: 100%;
  padding: 80px 24px;
  overflow: hidden;
  background:
    var(--public-surface);
}

.family-container {
  max-width: 1200px;
  margin: 0 auto;

  display: grid;
  grid-template-columns: 1fr 1.08fr;
  align-items: center;

  gap: 100px;
}


/* =========================================================
   IMAGEN
========================================================= */

.family-visual {
  position: relative;

  width: 100%;
  max-width: 510px;
  height: 470px;

  margin: 0 auto;
}

.photo-wrapper {
  position: absolute;

  width: 380px;
  height: 340px;

  top: 48px;
  left: 70px;

  border-radius: 18px;
  overflow: hidden;

  z-index: 4;

  box-shadow:
    0 22px 55px rgba(var(--public-heading-rgb), 0.13);
}

.family-photo {
  width: 100%;
  height: 100%;

  object-fit: cover;
  object-position: center;

  display: block;
}


/* =========================================================
   FORMAS DECORATIVAS
========================================================= */

.shape {
  position: absolute;
  border-radius: 16px;
}

.shape-top {
  width: 265px;
  height: 150px;

  top: 12px;
  left: 125px;

  background: var(--public-primary);

  transform: rotate(-4deg);

  z-index: 1;
}

.shape-back {
  width: 230px;
  height: 220px;

  right: 5px;
  bottom: 25px;

  background: var(--public-soft);

  transform: rotate(4deg);

  z-index: 1;
}


/* =========================================================
   PUNTOS
========================================================= */

.dots {
  position: absolute;

  top: 145px;
  left: 0;

  width: 95px;

  display: grid;
  grid-template-columns: repeat(4, 7px);
  gap: 14px;

  z-index: 2;
}

.dots span {
  width: 7px;
  height: 7px;

  border-radius: 50%;

  background: var(--public-primary);
  opacity: 0.25;
}


/* =========================================================
   FRASE
========================================================= */

.quote-card {
  position: absolute;

  left: -25px;
  bottom: 0;

  width: 225px;
  min-height: 195px;

  padding: 24px 27px;

  background: #ffffff;

  border-radius: 17px;

  box-shadow:
    0 18px 50px rgba(var(--public-heading-rgb), 0.12);

  z-index: 6;
}

.quote-icon {
  height: 39px;

  color: var(--public-primary);

  font-family: Georgia, serif;
  font-size: 55px;
  font-weight: 700;
  line-height: 1;
}

.quote-card p {
  margin: 4px 0 20px;

  color: var(--public-heading);

  font-size: 16px;
  font-weight: 700;
  line-height: 1.35;
}

.quote-line {
  width: 58px;
  height: 3px;

  border-radius: 10px;

  background: var(--public-primary);
}


/* =========================================================
   ICONO FAMILIA
========================================================= */

.family-icon {
  position: absolute;

  right: 4px;
  bottom: 22px;

  width: 88px;
  height: 88px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 50%;

  background: #ffffff;

  color: var(--public-primary);

  font-size: 35px;

  box-shadow:
    0 15px 40px rgba(var(--public-heading-rgb), 0.13);

  z-index: 7;
}


/* =========================================================
   CONTENIDO
========================================================= */

.family-content {
  width: 100%;
  max-width: 590px;
}

.section-label {
  display: flex;
  align-items: center;

  gap: 16px;

  margin-bottom: 8px;
}

.section-label span {
  color: var(--public-primary);

  font-size: 13px;
  font-weight: 800;

  letter-spacing: 2px;
}

.label-line {
  width: 48px;
  height: 2px;

  background: var(--public-primary);
}

.family-title {
  margin: 0 0 7px;

  color: var(--public-heading);

  font-size: 44px;
  font-weight: 800;
  line-height: 1.1;

  letter-spacing: -1px;
}

.family-description {
  max-width: 570px;

  margin: 0 0 25px;

  color: var(--public-heading);

  font-size: 16px;
  line-height: 1.6;
}


/* =========================================================
   FORMULARIO
========================================================= */

.family-form {
  display: flex;
  flex-direction: column;

  gap: 14px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;

  gap: 14px;
}

.input-group {
  position: relative;

  display: flex;
  align-items: center;

  width: 100%;

  background: #ffffff;

  border: 1px solid rgba(var(--public-heading-rgb), 0.09);
  border-radius: 11px;

  box-shadow:
    0 7px 22px rgba(var(--public-heading-rgb), 0.07);

  transition:
    border-color 0.2s ease,
    box-shadow 0.2s ease,
    transform 0.2s ease;
}

.input-group:focus-within {
  border-color: rgba(var(--public-primary-rgb), 0.45);

  box-shadow:
    0 8px 25px rgba(var(--public-primary-rgb), 0.12);
}

.input-group i {
  width: 49px;

  flex-shrink: 0;

  text-align: center;

  color: var(--public-primary);

  font-size: 16px;
}

.input-group input,
.input-group textarea {
  width: 100%;

  padding: 14px 16px 14px 0;

  border: 0;
  outline: 0;

  background: transparent;

  color: var(--public-heading);

  font-family: inherit;
  font-size: 14px;
}

.input-group input {
  height: 49px;
}

.input-group textarea {
  min-height: 105px;

  padding-top: 16px;

  resize: vertical;
}

.input-group input::placeholder,
.input-group textarea::placeholder {
  color: var(--public-heading);
  opacity: 0.65;
}

.textarea-group {
  align-items: flex-start;
}

.textarea-group i {
  padding-top: 18px;
}


/* =========================================================
   BOTÓN
========================================================= */

.submit-button {
  width: fit-content;
  min-width: 195px;

  height: 48px;

  display: inline-flex;
  align-items: center;
  justify-content: center;

  gap: 11px;

  margin-top: 1px;

  padding: 0 25px;

  border: 0;
  border-radius: 11px;

  background: var(--public-primary);

  color: #ffffff;

  font-family: inherit;
  font-size: 15px;
  font-weight: 600;

  cursor: pointer;

  box-shadow:
    0 10px 25px rgba(var(--public-primary-rgb), 0.23);

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.submit-button:hover:not(:disabled) {
  transform: translateY(-2px);

  box-shadow:
    0 14px 30px rgba(var(--public-primary-rgb), 0.3);
}

.submit-button:disabled {
  cursor: not-allowed;
  opacity: 0.8;
}

.submit-button i {
  font-size: 15px;
}

.spinner {
  width: 17px;
  height: 17px;

  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1000px) {

  .family-container {
    gap: 45px;
  }

  .family-visual {
    transform: scale(0.9);
    transform-origin: center;
  }

  .family-title {
    font-size: 39px;
  }
}


/* =========================================================
   MÓVIL
========================================================= */

@media (max-width: 767px) {

  .family-section {
    padding: 42px 18px 50px;
  }

  .family-container {
    display: flex;
    flex-direction: column;

    gap: 32px;
  }


  /* IMAGEN */

  .family-visual {
    width: 100%;
    max-width: 390px;

    height: 340px;

    transform: none;
  }

  .photo-wrapper {
    width: 75%;
    height: 235px;

    top: 25px;
    left: 18%;

    border-radius: 14px;
  }

  .shape-top {
    width: 48%;
    height: 100px;

    top: 3px;
    left: 34%;
  }

  .shape-back {
    width: 43%;
    height: 150px;

    right: 0;
    bottom: 25px;
  }

  .dots {
    top: 75px;
    left: 1%;

    gap: 10px;
  }

  .dots span {
    width: 5px;
    height: 5px;
  }


  /* FRASE */

  .quote-card {
    width: 47%;
    min-height: 145px;

    left: 0;
    bottom: 3px;

    padding: 16px 17px;

    border-radius: 13px;
  }

  .quote-icon {
    height: 27px;

    font-size: 41px;
  }

  .quote-card p {
    margin: 3px 0 13px;

    font-size: 12px;
    line-height: 1.3;
  }

  .quote-line {
    width: 40px;
    height: 2px;
  }


  /* ICONO */

  .family-icon {
    width: 64px;
    height: 64px;

    right: 0;
    bottom: 7px;

    font-size: 25px;
  }


  /* CONTENIDO */

  .family-content {
    max-width: 100%;
  }

  .section-label {
    justify-content: center;

    gap: 10px;

    margin-bottom: 8px;
  }

  .section-label span {
    font-size: 10px;
    letter-spacing: 1.5px;
  }

  .label-line {
    width: 35px;
  }

  .family-title {
    text-align: center;

    font-size: 34px;
    letter-spacing: -0.5px;
  }

  .family-description {
    max-width: 420px;

    margin: 0 auto 25px;

    text-align: center;

    font-size: 14px;
    line-height: 1.5;
  }


  /* FORM */

  .family-form {
    gap: 11px;
  }

  .form-row {
    grid-template-columns: 1fr;

    gap: 11px;
  }

  .input-group {
    border-radius: 10px;
  }

  .input-group input {
    height: 48px;
  }

  .input-group textarea {
    min-height: 90px;
  }

  .submit-button {
    width: 100%;

    height: 49px;

    margin-top: 0;
  }
}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 420px) {

  .family-section {
    padding-left: 15px;
    padding-right: 15px;
  }

  .family-visual {
    height: 310px;
  }

  .photo-wrapper {
    height: 215px;
  }

  .quote-card {
    width: 50%;
    min-height: 137px;
  }

  .quote-card p {
    font-size: 11px;
  }

  .family-title {
    font-size: 31px;
  }

  .family-description {
    font-size: 13px;
  }
}

</style>