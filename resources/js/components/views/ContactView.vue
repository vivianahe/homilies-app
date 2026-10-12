<template>
  <Header />
  <main class="contact-page">
    <div class="contact-container">
      <header class="contact-heading">
        <span class="contact-eyebrow">ESTAMOS PARA ESCUCHARTE</span>
        <h1>Conversemos</h1>
        <p>Comparte tu intención de oración o escríbenos para recibir orientación espiritual y familiar.</p>
      </header>

      <div class="contact-layout">
        <section class="contact-form-card" aria-labelledby="contact-form-title">
          <div class="form-heading">
            <span class="heading-icon"><i class="fa-regular fa-envelope" aria-hidden="true"></i></span>
            <div>
              <h2 id="contact-form-title">Envíanos un mensaje</h2>
              <p>Completa los campos para ponernos en contacto contigo.</p>
            </div>
          </div>

          <form @submit.prevent="submitForm" :aria-busy="sending">
            <fieldset :disabled="sending">
              <div class="form-grid">
                <div class="form-field full-width">
                  <label for="contact-name">Nombre completo</label>
                  <input id="contact-name" v-model="formData.name" type="text" autocomplete="name"
                    placeholder="Tu nombre y apellido" required />
                </div>
                <div class="form-field">
                  <label for="contact-email">Correo electrónico</label>
                  <input id="contact-email" v-model="formData.email" type="email" autocomplete="email"
                    placeholder="nombre@correo.com" required />
                </div>
                <div class="form-field">
                  <label for="contact-phone">Teléfono</label>
                  <input id="contact-phone" v-model="formData.phone" type="tel" autocomplete="tel"
                    placeholder="Tu número de contacto" required />
                </div>
                <div class="form-field full-width">
                  <label for="contact-message">¿Cómo podemos acompañarte?</label>
                  <textarea id="contact-message" v-model="formData.message" rows="5"
                    placeholder="Escribe aquí tu mensaje o intención de oración…" required></textarea>
                </div>
              </div>
              <div class="form-actions">
                <span>Todos los campos son obligatorios.</span>
                <button type="submit" class="send-button">
                  <i :class="sending ? 'fa-solid fa-spinner fa-spin' : 'fa-regular fa-paper-plane'" aria-hidden="true"></i>
                  {{ sending ? 'Enviando mensaje…' : 'Enviar mensaje' }}
                </button>
              </div>
            </fieldset>
            <div v-if="success" class="form-feedback success" role="status">
              <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
              <p><strong>Mensaje enviado.</strong> Gracias por escribirnos. Nos pondremos en contacto contigo.</p>
            </div>
            <div v-if="error" class="form-feedback error" role="alert">
              <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
              <p>{{ error }}</p>
            </div>
          </form>
        </section>

        <aside class="contact-info" aria-label="Acompañamiento pastoral">
          <div class="priest-profile">
            <img src="/img/fotourl.jpg" alt="Padre Uriel Franco" width="76" height="76" />
            <div><span>UN ESPACIO DE ESCUCHA</span><h2>Padre Uriel Franco</h2></div>
          </div>
          <p class="info-description">Una palabra de esperanza y acompañamiento para tu vida y la de tu familia.</p>
          <div class="contact-services">
            <div class="service">
              <i class="fa-solid fa-hands-praying" aria-hidden="true"></i>
              <div><h3>Intenciones de oración</h3><p>Comparte aquello que deseas poner en manos de Dios.</p></div>
            </div>
            <div class="service">
              <i class="fa-regular fa-heart" aria-hidden="true"></i>
              <div><h3>Orientación familiar</h3><p>Un espacio para conversar sobre los desafíos de tu familia.</p></div>
            </div>
            <div class="service">
              <i class="fa-regular fa-comments" aria-hidden="true"></i>
              <div><h3>Acompañamiento espiritual</h3><p>Encuentra escucha y orientación en tu camino de fe.</p></div>
            </div>
          </div>
          <a href="https://wa.link/w0acfb" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
            También puedes escribir por WhatsApp
            <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          </a>
        </aside>
      </div>
    </div>
  </main>
  <Footer />
</template>

<script setup>
import Header from '../Header.vue';
import Footer from '../Footer.vue';
import { ref } from 'vue';
import axios from 'axios';

const sending = ref(false);
const success = ref(false);
const error = ref('');
const formData = ref({ name: '', email: '', phone: '', message: '' });

const submitForm = async () => {
  if (sending.value) return;
  sending.value = true;
  success.value = false;
  error.value = '';
  try {
    const { data } = await axios.post('/contact', { ...formData.value });
    if (data.success === false) throw new Error('Contact request failed');
    formData.value = { name: '', email: '', phone: '', message: '' };
    success.value = true;
  } catch {
    error.value = 'No pudimos enviar tu mensaje. Tus datos se han conservado; inténtalo de nuevo.';
  } finally {
    sending.value = false;
  }
};
</script>

<style scoped>
.contact-page { background: var(--public-surface); padding: 48px 24px 72px; }
.contact-container { max-width: 1180px; margin: 0 auto; }
.contact-heading { max-width: 680px; margin-bottom: 32px; }
.contact-eyebrow { color: var(--public-primary); font-size: 11px; font-weight: 700; letter-spacing: .12em; }
.contact-heading h1 { margin: 10px 0 12px; color: var(--public-heading); font-size: clamp(30px, 4vw, 46px); font-weight: 800; line-height: 1.15; }
.contact-heading p { color: var(--public-text); font-size: 15px; line-height: 1.75; }
.contact-layout { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: 32px; align-items: start; }
.contact-form-card { padding: 32px; background: white; border: 1px solid var(--public-border); border-radius: 24px; box-shadow: 0 8px 32px rgba(var(--public-heading-rgb), .04); min-width: 0; }
.form-heading { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
.heading-icon { display: grid; place-items: center; width: 46px; height: 46px; flex-shrink: 0; background: var(--public-soft); color: var(--public-primary); border-radius: 14px; font-size: 21px; }
.form-heading h2 { font-size: 21px; font-weight: 700; color: var(--public-heading); }
.form-heading p { margin-top: 5px; font-size: 12px; color: var(--public-muted); line-height: 1.6; }
fieldset { margin: 0; padding: 0; border: 0; min-width: 0; }
.form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
.full-width { grid-column: 1 / -1; }
.form-field { min-width: 0; }
.form-field label { display: block; margin-bottom: 8px; color: var(--public-heading); font-size: 13px; font-weight: 600; }
.form-field input, .form-field textarea { display: block; width: 100%; min-width: 0; padding: 13px 14px; border: 1px solid #cbd5e1; border-radius: 12px; background: var(--public-surface); color: var(--public-heading); font-family: inherit; font-size: 16px; line-height: 1.5; transition: border-color .2s, box-shadow .2s; }
.form-field input::placeholder, .form-field textarea::placeholder { color: var(--public-muted); font-size: 14px; opacity: 1; }
.form-field textarea { min-height: 150px; resize: vertical; }
.form-field input:focus, .form-field textarea:focus { outline: none; border-color: var(--public-primary); background: white; box-shadow: 0 0 0 3px rgba(var(--public-primary-rgb), .12); }
.form-actions { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-top: 24px; }
.form-actions > span { font-size: 11px; color: var(--public-muted); }
.send-button { display: inline-flex; align-items: center; justify-content: center; gap: 10px; min-height: 48px; padding: 12px 22px; border-radius: 12px; background: var(--public-primary); color: white; font-size: 14px; font-weight: 600; }
.send-button:hover:not(:disabled) { box-shadow: 0 4px 14px rgba(var(--public-primary-rgb), .25); }
.send-button:focus-visible, .whatsapp-link:focus-visible { outline: 3px solid var(--public-primary); outline-offset: 4px; }
fieldset:disabled { opacity: .65; }
fieldset:disabled button { cursor: wait; }
.contact-info { padding: 24px 0; min-width: 0; }
.priest-profile { display: flex; align-items: center; gap: 16px; }
.priest-profile img { width: 76px; height: 76px; flex-shrink: 0; border-radius: 20px; object-fit: cover; object-position: top; }
.priest-profile span { font-size: 10px; font-weight: 600; letter-spacing: .08em; color: var(--public-primary); }
.priest-profile h2 { margin-top: 5px; font-size: 20px; font-weight: 700; color: var(--public-heading); line-height: 1.4; }
.info-description { margin: 20px 0 26px; color: var(--public-text); font-size: 14px; line-height: 1.8; }
.contact-services { display: grid; gap: 24px; }
.service { display: flex; align-items: flex-start; gap: 12px; }
.service > i { display: grid; place-items: center; width: 40px; height: 40px; flex-shrink: 0; border-radius: 12px; background: var(--public-soft); color: var(--public-primary); }
.service h3 { font-size: 14px; font-weight: 600; color: var(--public-heading); }
.service p { margin-top: 5px; color: var(--public-muted); font-size: 12px; line-height: 1.7; }
.whatsapp-link { display: flex; align-items: center; gap: 10px; margin-top: 28px; padding-top: 22px; border-top: 1px solid var(--public-border); color: var(--public-primary); font-size: 12px; font-weight: 600; line-height: 1.7; }
.whatsapp-link > i:first-child { font-size: 22px; }
.whatsapp-link > i:last-child { font-size: 10px; }
.form-feedback { display: flex; align-items: flex-start; gap: 10px; margin-top: 20px; padding: 14px; border-radius: 12px; font-size: 13px; line-height: 1.6; }
.form-feedback > i { margin-top: 4px; }
.success { background: var(--public-soft); color: var(--public-primary); }
.error { background: #fef2f2; color: #b91c1c; }
@media (max-width: 900px) {
  .contact-layout { grid-template-columns: minmax(0, 1fr); gap: 24px; }
  .contact-info { padding: 16px 8px; }
}
@media (max-width: 540px) {
  .contact-page { padding: 28px 16px 48px; }
  .contact-heading { margin-bottom: 24px; }
  .contact-heading p { font-size: 13px; }
  .contact-form-card { padding: 22px 18px; border-radius: 20px; }
  .form-heading { gap: 10px; margin-bottom: 24px; }
  .form-heading h2 { font-size: 18px; }
  .heading-icon { width: 38px; height: 38px; font-size: 18px; }
  .form-grid { grid-template-columns: minmax(0, 1fr); gap: 18px; }
  .send-button { width: 100%; }
  .form-actions { gap: 12px; }
}
</style>
