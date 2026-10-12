<template>

  <Header />

  <main class="donation-section">

    <div class="donation-container">

      <div class="donation-hero">

        <div class="donation-content">

          <span class="donation-badge">
            <i class="fa-solid fa-heart"></i>
            Apoya esta misión evangelizadora
          </span>

          <h1>
            Tu ayuda <span>transforma vidas</span>
          </h1>

          <p>
            Cada aporte nos permite seguir compartiendo la Palabra de Dios,
            acompañando familias, fortaleciendo la oración y llevando esperanza
            a miles de personas a través de nuestras homilías.
          </p>

          <div class="donation-actions">

            <a
              href="https://wa.link/w0acfb"
              target="_blank"
              rel="noopener noreferrer"
              class="donate-btn"
            >
              <i class="fa-solid fa-hand-holding-heart"></i>
              Realizar donación
            </a>

          </div>

        </div>

        <div class="donation-image-wrapper">



          <img
            src="/img/donate.png"
            alt="Donación"
            class="donation-image"
          >

        </div>

      </div>

      <div class="bank-section">

        <div class="section-title">

          <h2>Información para donar</h2>

          <p>
            Puedes realizar tu aporte mediante transferencia bancaria.
          </p>

        </div>

        <div class="donation-methods">

          <div class="donation-card-info">

            <div class="donation-card-header">

              <i class="fa-solid fa-building-columns"></i>

              <h3>Bancolombia</h3>

            </div>

            <div class="donation-card-body">

              <div class="info-row">
                <span>Titular</span>
                <strong>Uriel Alejandro Franco Sánchez</strong>
              </div>

              <div class="info-row">
                <span>Cédula</span>
                <strong>1.075.221.526</strong>
              </div>

              <div class="info-row">
                <span>Tipo de cuenta</span>
                <strong>Cuenta de ahorros</strong>
              </div>

              <div class="info-row highlight">
                <span>Número de cuenta</span>
                <strong>28458168344</strong>
              </div>

            </div>

          </div>

          <div class="donation-card-info donation-card-alt">

            <div class="donation-card-header">
              <i class="fa-solid fa-mobile-screen"></i>
              <h3>Billeteras digitales</h3>
            </div>

            <div class="donation-card-body">

              <div class="wallet-item">
                  <div class="wallet-name">
                      <i class="fa-solid fa-wallet"></i>
                      <span>Nequi</span>
                  </div>

                  <strong>318 877 2653</strong>
              </div>

              <div class="wallet-item">
                  <div class="wallet-name">
                      <i class="fa-solid fa-money-bill-transfer"></i>
                      <span>Daviplata y Llave</span>
                  </div>

                  <strong>312 575 4229</strong>
              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="impact-section">

        <div class="section-title">

          <h2>Tu aporte hace posible</h2>

        </div>

        <div class="impact-grid">

          <div class="impact-item">

            <i class="fa-solid fa-book-bible"></i>

            <h3>Evangelización</h3>

            <p>
              Difusión diaria de homilías y reflexiones.
            </p>

          </div>

          <div class="impact-item">

            <i class="fa-solid fa-hands-praying"></i>

            <h3>Oración</h3>

            <p>
              Acompañamiento espiritual e intenciones.
            </p>

          </div>

          <div class="impact-item">

            <i class="fa-solid fa-church"></i>

            <h3>Formación</h3>

            <p>
              Recursos para fortalecer la fe.
            </p>

          </div>

          <div class="impact-item">

            <i class="fa-solid fa-people-group"></i>

            <h3>Familias</h3>

            <p>
              Orientación y acompañamiento pastoral.
            </p>

          </div>

        </div>

      </div>

      <div class="verse-section">

        <i class="fa-solid fa-quote-left"></i>

        <p>
          Abraham dio el diezmo a Melquisedec,
          sacerdote del Dios Altísimo.
        </p>

        <span>Génesis 14:20</span>

      </div>

    </div>
  </main>

  <Footer />
</template>

<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";

</script>


<style scoped>
.donation-section { background: white; padding: 40px 24px 64px; }
.donation-container { max-width: 1180px; margin: 0 auto; }
.donation-hero { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, .8fr); gap: 40px; align-items: center; margin-bottom: 48px; padding: 36px; background: var(--public-soft); border: 1px solid var(--public-border); border-radius: 30px; }
.donation-content { min-width: 0; }
.donation-badge { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; color: var(--public-primary); font-size: 11px; font-weight: 700; padding: 8px 12px; background: white; border-radius: 999px; }
.donation-badge i { color: var(--public-primary); }
.donation-content h1 { margin: 0 0 18px; color: var(--public-heading); font-size: clamp(30px, 4vw, 46px); line-height: 1.15; font-weight: 800; }
.donation-content h1 span { color: var(--public-primary); }
.donation-content p { max-width: 600px; margin-bottom: 24px; color: var(--public-text); font-size: 15px; line-height: 1.8; }
.donation-actions { display: flex; }
.donate-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; min-height: 48px; padding: 12px 22px; border-radius: 12px; background: var(--public-primary); color: white; font-size: 14px; font-weight: 600; transition: box-shadow .2s; }
.donate-btn:hover { box-shadow: 0 4px 14px rgba(var(--public-primary-rgb), .2); }
.donate-btn:focus-visible { outline: 3px solid var(--public-primary); outline-offset: 4px; }
.donation-image-wrapper { min-width: 0; }
.donation-image { width: 100%; height: 300px; object-fit: cover; border-radius: 24px; box-shadow: 0 14px 32px rgba(var(--public-heading-rgb), .12); }
.bank-section { margin-bottom: 44px; }
.section-title { margin-bottom: 22px; text-align: left; }
.section-title h2 { margin-bottom: 8px; color: var(--public-heading); font-size: 24px; font-weight: 700; line-height: 1.3; }
.section-title p { color: var(--public-muted); font-size: 14px; line-height: 1.7; }
.donation-methods { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; align-items: stretch; }
.donation-card-info { min-width: 0; overflow: hidden; border: 1px solid #e2e8f0; border-radius: 20px; background: white; box-shadow: 0 8px 24px rgba(var(--public-heading-rgb), .06); border-top: 3px solid var(--public-primary); }
.donation-card-header { display: flex; align-items: center; gap: 12px; padding: 22px 24px; border-bottom: 1px solid #f1f5f9; }
.donation-card-header > i { display: grid; place-items: center; width: 42px; height: 42px; flex-shrink: 0; border-radius: 12px; background: var(--public-soft); color: var(--public-primary); font-size: 18px; }
.donation-card-header h3 { margin: 0; color: var(--public-heading); font-size: 18px; font-weight: 700; }
.donation-card-body { padding: 8px 24px 20px; }
.info-row { display: flex; align-items: baseline; justify-content: space-between; gap: 20px; padding: 16px 0; border-bottom: 1px solid #f1f5f9; }
.info-row:last-child { border-bottom: 0; }
.info-row span { flex-shrink: 0; color: var(--public-muted); font-size: 12px; }
.info-row strong { color: var(--public-heading); font-size: 14px; font-weight: 600; text-align: right; overflow-wrap: anywhere; }
.info-row.highlight { margin-top: 10px; padding: 16px; border: 1px solid #e2e8f0; border-radius: 12px; background: var(--public-soft); }
.highlight strong { color: var(--public-primary); font-size: 18px; letter-spacing: .03em; font-variant-numeric: tabular-nums; }
.wallet-item { display: flex; flex-direction: column; gap: 12px; padding: 20px 0; border-bottom: 1px solid #f1f5f9; }
.wallet-item:last-child { border-bottom: 0; }
.wallet-name { display: flex; align-items: center; gap: 10px; }
.wallet-name i { color: var(--public-muted); font-size: 15px; }
.wallet-name span { color: var(--public-text); font-size: 13px; font-weight: 600; }
.wallet-item strong { display: block; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; background: var(--public-soft); color: var(--public-heading); font-size: 20px; font-weight: 600; letter-spacing: .04em; font-variant-numeric: tabular-nums; }
.impact-section { margin-bottom: 40px; padding: 28px; background: var(--public-surface); border-radius: 24px; }
.impact-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; }
.impact-item { padding: 22px; border: 1px solid #e2e8f0; border-radius: 18px; background: white; }
.impact-item i { display: grid; place-items: center; width: 36px; height: 36px; margin-bottom: 14px; border-radius: 10px; background: var(--public-soft); color: var(--public-primary); font-size: 16px; }
.impact-item h3 { margin-bottom: 8px; color: var(--public-heading); font-size: 15px; font-weight: 700; }
.impact-item p { color: var(--public-muted); font-size: 12px; line-height: 1.8; }
.verse-section { max-width: 740px; margin: 0 auto; padding: 28px 24px; text-align: center; border: 1px solid var(--public-border); border-radius: 20px; background: var(--public-soft); }
.verse-section i { margin-bottom: 12px; color: var(--public-primary); font-size: 20px; }
.verse-section p { margin-bottom: 10px; color: var(--public-text); font-size: 16px; line-height: 1.8; }
.verse-section span { color: var(--public-muted); font-size: 12px; }
@media (max-width: 900px) {
  .donation-hero { gap: 28px; padding: 28px; }
  .donation-image { height: 260px; }
  .donation-methods { grid-template-columns: minmax(0, 1fr); gap: 20px; }
  .impact-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 600px) {
  .donation-section { padding: 28px 16px 48px; }
  .donation-hero { grid-template-columns: minmax(0, 1fr); gap: 24px; margin-bottom: 32px; padding: 24px 18px; border-radius: 22px; }
  .donation-content p { font-size: 14px; }
  .donation-image { height: 200px; border-radius: 18px; }
  .donate-btn { width: 100%; }
  .section-title h2 { font-size: 21px; }
  .donation-card-header { padding: 18px; }
  .donation-card-body { padding: 4px 18px 18px; }
  .info-row { gap: 8px; flex-direction: column; align-items: flex-start; padding: 12px 0; }
  .info-row strong { text-align: left; }
  .info-row.highlight { padding: 14px; }
  .impact-section { padding: 20px 14px; }
  .impact-grid { gap: 12px; }
  .impact-item { padding: 16px; }
  .impact-item h3 { font-size: 13px; }
}
@media (max-width: 360px) { .impact-grid { grid-template-columns: minmax(0, 1fr); } }
</style>
