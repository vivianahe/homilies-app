<template>

  <Header />

  <section class="contact-section">

    <div class="contact-container">

      <div class="contact-header">

        <h1>
          Estamos para escucharte
        </h1>

        <p>
          Si necesitas orientación familiar, espiritual o deseas compartir
          una intención de oración, puedes enviarnos un mensaje.
          Estaremos felices de acompañarte.
        </p>

      </div>
      <div class="contact-layout">

        <div class="contact-info-card">

          <img
            src="/img/fotourl.jpg"
            alt="Padre Uriel"
            class="contact-image"
          >

          <h2>
            Padre Uriel Franco
          </h2>

          <p class="contact-description">
            Acompañamiento espiritual, orientación familiar y escucha pastoral
            para quienes necesitan una palabra de esperanza.
          </p>

          <div class="contact-features">

            <div>
              <i class="fa-solid fa-envelope"></i>
              <span>Atención personalizada</span>
            </div>

            <div>
              <i class="fa-solid fa-heart"></i>
              <span>Orientación familiar</span>
            </div>

            <div>
              <i class="fa-solid fa-hands-praying"></i>
              <span>Peticiones de oración</span>
            </div>

          </div>
        </div>


        <div class="contact-form-card">

          <h2>
            Contáctanos
          </h2>

          <form @submit.prevent="submitForm">

            <div class="form-group">

              <label>
                Nombre completo
              </label>

              <input
                type="text"
                class="modern-input"
                v-model="formData.name"
                required
              >

            </div>

            <div class="form-group">

              <label>
                Correo electrónico
              </label>

              <input
                type="email"
                class="modern-input"
                v-model="formData.email"
                required
              >

            </div>

            <div class="form-group">

              <label>
                Teléfono
              </label>

              <input
                type="text"
                class="modern-input"
                v-model="formData.phone"
                required
              >

            </div>

            <div class="form-group">

              <label>
                Mensaje
              </label>

              <textarea
                class="modern-textarea"
                v-model="formData.message"
                required
              ></textarea>

            </div>

            <button
              v-if="loader"
              type="submit"
              class="submit-btn"
            >
              <i class="fa-solid fa-paper-plane"></i>
              Enviar mensaje
            </button>

            <button
              v-else
              disabled
              type="button"
              class="submit-btn"
            >

              <div class="spinner"></div>

              Enviando...
            </button>
          </form>

        </div>

      </div>

    </div>
    <transition name="toast">

    <div
        v-if="showSuccessToast"
        class="success-toast"
    >

        <div class="success-icon">

        <i class="fa-solid fa-paper-plane"></i>

        </div>

        <div class="success-content">

        <strong>
            Mensaje enviado
        </strong>

        <p>
            Gracias por comunicarte con nosotros.
            Pronto nos pondremos en contacto contigo.
        </p>

        </div>

    </div>

    </transition>
  </section>
  <Footer />
</template>

<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import { ref,onMounted } from "vue";
import axios from "axios";
import { initFlowbite } from "flowbite";
onMounted(() => {
  initFlowbite();
});
const loader = ref(true);
const showSuccessToast = ref(false);

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
            loader.value = true;

            showSuccessToast.value = true;

            setTimeout(() => {

            showSuccessToast.value = false;

            }, 5000);
        })
        .catch((error) => {
            console.error(error);
        });
};
</script>
<style scoped>

.contact-section{
  background:linear-gradient(
    180deg,
    #f8fbff 0%,
    #ffffff 100%
  );

  padding:80px 40px 100px;
}

.contact-container{
  width:100%;
  max-width:1700px;
  margin:0 auto;
}

.contact-header{
  text-align:center;
  margin-bottom:60px;
}

.contact-header h1{
  font-size:4rem;
  font-weight:800;

  color:#0f172a;

  margin-bottom:18px;

  line-height:1.1;
}

.contact-header p{
  max-width:850px;

  margin:auto;

  color:#64748b;

  line-height:1.8;

  font-size:1.08rem;
}

.contact-layout{

  display:grid;

  grid-template-columns:
    minmax(420px,520px)
    minmax(0,1fr);

  gap:40px;

  align-items:start;
}

.contact-info-card,
.contact-form-card{

  padding:40px;
}

.contact-info-card{
  position:sticky;
  top:100px;
}

.contact-image{

  width:100%;

  height:520px;

  object-fit:cover;

  border-radius:24px;

  margin-bottom:28px;
}

.contact-info-card h2{

  font-size:2rem;

  font-weight:800;

  color:#0f172a;

  margin-bottom:14px;
}

.contact-description{

  color:#64748b;

  line-height:1.8;

  margin-bottom:28px;
}


.contact-features{

  display:flex;

  flex-direction:column;

  gap:16px;
}

.contact-features div{

  display:flex;

  align-items:center;

  gap:14px;

  color:#334155;

  font-weight:600;
}

.contact-features i{

  width:42px;

  height:42px;

  display:flex;

  align-items:center;

  justify-content:center;

  border-radius:14px;

  background:#eff6ff;

  color:#2563eb;

  flex-shrink:0;
}

.contact-form-card h2{

  font-size:3rem;

  font-weight:800;

  color:#0f172a;

  margin-bottom:36px;
}

.form-group{

  margin-bottom:24px;
}

.form-group label{

  display:block;

  margin-bottom:8px;

  font-weight:700;

  color:#334155;
}

.modern-input,
.modern-textarea{

  width:100%;

  padding:18px 22px;

  border:1px solid #dbeafe;

  border-radius:18px;

  background:#f8fafc;

  color:#0f172a;

  font-size:1rem;

  transition:all .25s ease;
}

.modern-input:focus,
.modern-textarea:focus{

  outline:none;

  border-color:#2563eb;

  background:white;

  box-shadow:
    0 0 0 4px rgba(37,99,235,.10);
}

.modern-textarea{

  resize:none;

  min-height:220px;
}

.submit-btn{

  height:58px;

  padding:0 30px;

  border:none;

  border-radius:18px;

  background:#2563eb;

  color:white;

  font-size:1rem;

  font-weight:700;

  display:inline-flex;

  align-items:center;

  justify-content:center;

  gap:10px;

  cursor:pointer;

  transition:all .25s ease;
}

.submit-btn:hover{

  transform:translateY(-2px);

  box-shadow:
    0 12px 25px rgba(37,99,235,.25);
}

.submit-btn:disabled{

  opacity:.8;

  cursor:not-allowed;
}

.spinner{

  width:18px;
  height:18px;

  border:2px solid rgba(255,255,255,.4);

  border-top:2px solid #fff;

  border-radius:50%;

  animation:spin .8s linear infinite;
}

@keyframes spin{

  from{
    transform:rotate(0deg);
  }

  to{
    transform:rotate(360deg);
  }

}

.success-toast{

  position:fixed;

  right:24px;
  bottom:24px;

  z-index:9999;

  display:flex;
  align-items:flex-start;
  gap:16px;

  width:420px;
  max-width:calc(100vw - 32px);

  padding:18px;

  background:white;

  border:1px solid #dbeafe;

  border-radius:20px;

  box-shadow:
    0 20px 40px rgba(15,23,42,.12);

  backdrop-filter:blur(10px);
}

.success-icon{

  width:54px;
  height:54px;

  flex-shrink:0;

  border-radius:16px;

  display:flex;
  align-items:center;
  justify-content:center;

  background:#eff6ff;

  color:#2563eb;

  font-size:22px;
}

.success-content{

  flex:1;
}

.success-content strong{

  display:block;

  font-size:1rem;
  font-weight:800;

  color:#0f172a;

  margin-bottom:6px;
}

.success-content p{

  margin:0;

  color:#64748b;

  line-height:1.6;

  font-size:.92rem;
}

.toast-enter-active,
.toast-leave-active{

  transition:all .3s ease;
}

.toast-enter-from,
.toast-leave-to{

  opacity:0;

  transform:
    translateY(20px)
    translateX(20px);
}


@media(max-width:768px){

  .success-toast{

    left:16px;
    right:16px;

    width:auto;

    bottom:16px;
  }

}

@media(max-width:1200px){

  .contact-layout{

    grid-template-columns:1fr;
  }

  .contact-info-card{

    position:relative;

    top:auto;
  }

}

@media(max-width:768px){

  .contact-section{

    padding:50px 16px 70px;
  }

  .contact-header{

    margin-bottom:40px;
  }

  .contact-header h1{

    font-size:2.4rem;
  }

  .contact-header p{

    font-size:.95rem;
  }

  .contact-info-card,
  .contact-form-card{

    padding:24px;
  }

  .contact-image{

    height:320px;
  }

  .contact-info-card h2{

    font-size:1.6rem;
  }

  .contact-form-card h2{

    font-size:2rem;
  }

  .modern-textarea{

    min-height:180px;
  }

}

</style>

