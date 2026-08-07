<template>

  <Header />

  <section class="donation-section">

    <div class="donation-container">

      <div class="donation-hero">

        <div class="donation-content">

          <span class="donation-badge">
            <i class="fa-solid fa-heart"></i>
            Apoya esta misión evangelizadora
          </span>

          <h1>
            Tu ayuda transforma vidas
          </h1>

          <p>
            Cada aporte nos permite seguir compartiendo la Palabra de Dios,
            acompañando familias, fortaleciendo la oración y llevando esperanza
            a miles de personas a través de nuestras homilías.
          </p>

          <div class="donation-actions">

            <a
              href="https://wa.link/kw36eo"
              target="_blank"
              class="donate-btn"
            >
              <i class="fa-solid fa-hand-holding-heart"></i>
              Realizar donación
            </a>

          </div>

        </div>

        <div class="donation-image-wrapper">

          <div class="image-decoration"></div>

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
  </section>

  <Footer />
</template>

<script setup>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import { onMounted, ref } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>


<style scoped>

.donation-section{
  background:#f8fafc;
  padding:70px 24px 50px;
}

.donation-container{
  max-width:1400px;
  margin:0 auto;
}

.donation-hero{
  display:grid;
  grid-template-columns:1.1fr .9fr;
  gap:60px;
  align-items:center;

  margin-bottom:60px;
}

.donation-badge{
  display:inline-flex;
  align-items:center;
  gap:8px;

  padding:10px 18px;

  border-radius:999px;

  background:#eff6ff;
  color:#2563eb;

  font-weight:700;

  margin-bottom:22px;
}

.donation-content h1{
  font-size:3.8rem;
  line-height:1.05;
  font-weight:800;

  color:#0f172a;

  margin-bottom:18px;
}

.donation-content p{
  max-width:720px;

  color:#64748b;

  line-height:1.8;
  font-size:1.05rem;

  margin-bottom:30px;
}

.donation-actions{
  display:flex;
  gap:16px;
}

.donate-btn{
  height:58px;

  padding:0 28px;

  border-radius:18px;

  background:#2563eb;
  color:#fff;

  font-weight:700;

  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:10px;

  transition:.25s ease;
}

.donate-btn:hover{
  transform:translateY(-3px);

  box-shadow:
    0 16px 35px rgba(37,99,235,.25);
}

.donation-image-wrapper{
  position:relative;
}

.image-decoration{
  position:absolute;

  top:-24px;
  left:-24px;

  width:180px;
  height:180px;

  border-radius:28px;

  background:#fbbf24;

  z-index:1;
}

.donation-image{
  position:relative;
  z-index:2;

  width:100%;
  height:580px;

  object-fit:cover;

  border-radius:32px;

  box-shadow:
    0 30px 60px rgba(15,23,42,.10);
}

.section-title{
  text-align:center;
  margin-bottom:35px;
}

.section-title h2{
  font-size:2.2rem;
  font-weight:800;

  color:#0f172a;

  margin-bottom:10px;
}

.section-title p{
  color:#64748b;
  line-height:1.7;
}

.bank-section{
  margin-bottom:55px;
}

.donation-methods{

  display:grid;

  grid-template-columns:1fr;

  gap:24px;

  max-width:1000px;

  margin:0 auto;
}

.donation-card-info{

  background:#fff;

  border:1px solid #e2e8f0;

  border-radius:28px;

  overflow:hidden;

  transition:.25s ease;
}

.donation-card-info:hover{

  transform:translateY(-4px);

  box-shadow:
    0 20px 40px rgba(15,23,42,.08);
}

.donation-card-header{

  padding:24px;

  background:#eff6ff;

  border-bottom:1px solid #dbeafe;

  display:flex;

  align-items:center;

  gap:14px;
}

.donation-card-header i{

  width:54px;
  height:54px;

  border-radius:16px;

  background:#2563eb;

  color:white;

  display:flex;
  align-items:center;
  justify-content:center;

  font-size:22px;
}

.donation-card-header h3{

  margin:0;

  font-size:1.4rem;

  font-weight:800;

  color:#0f172a;
}

.donation-card-body{

  padding:26px;
}

.info-row{

  display:flex;

  justify-content:space-between;

  align-items:center;

  gap:16px;

  padding:14px 0;

  border-bottom:1px solid #f1f5f9;
}

.info-row:last-child{

  border-bottom:none;
}

.info-row span{

  color:#64748b;

  font-size:.95rem;
}

.info-row strong{

  color:#0f172a;

  font-weight:800;

  text-align:right;
}

.highlight strong{

  color:#2563eb;

  font-size:1.2rem;
}

.donation-card-alt{

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #1d4ed8
    );

  color:white;
}

.donation-card-alt .donation-card-header{

  background:transparent;

  border-bottom:1px solid rgba(255,255,255,.15);
}

.donation-card-alt .donation-card-header h3{

  color:white;
}

.donation-card-alt .donation-card-header i{

  background:white;

  color:#2563eb;
}

.card-description{

  color:rgba(255,255,255,.85);

  margin-bottom:22px;

  line-height:1.7;
}

.phone-number{

  font-size:2rem;

  font-weight:800;

  text-align:center;

  letter-spacing:2px;
}

.impact-section{
  margin-bottom:55px;
}

.impact-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:24px;
}

.impact-item{
  background:#fff;

  border:1px solid #e2e8f0;

  border-radius:24px;

  padding:30px 24px;

  text-align:center;

  transition:.25s ease;
}

.impact-item:hover{
  transform:translateY(-4px);

  box-shadow:
    0 15px 35px rgba(15,23,42,.06);
}

.impact-item i{
  width:70px;
  height:70px;

  margin:0 auto 18px;

  display:flex;
  align-items:center;
  justify-content:center;

  border-radius:18px;

  background:#eff6ff;

  color:#2563eb;

  font-size:24px;
}

.impact-item h3{
  font-size:1.15rem;
  font-weight:800;

  color:#0f172a;

  margin-bottom:10px;
}

.impact-item p{
  color:#64748b;
  line-height:1.7;
}


.verse-section{
  max-width:900px;

  margin:0 auto;

  padding:45px;

  background:#fff;

  border:1px solid #e2e8f0;

  border-radius:28px;

  text-align:center;
}

.verse-section i{
  font-size:30px;

  color:#2563eb;

  margin-bottom:18px;
}

.verse-section p{
  font-size:1.35rem;
  font-weight:700;

  color:#0f172a;

  line-height:1.6;

  margin-bottom:10px;
}

.verse-section span{
  color:#64748b;
  font-weight:600;
}

.wallet-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 0;
    border-bottom:1px solid rgba(255,255,255,.15);
}

.wallet-item:last-child{
    border-bottom:none;
}

.wallet-name{
    display:flex;
    align-items:center;
    gap:12px;
}

.wallet-name i{
    width:38px;
    height:38px;
    border-radius:12px;
    background:rgba(255,255,255,.15);
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
    font-size:16px;
}

.wallet-name span{
    color:#fff;
    font-size:1rem;
    font-weight:600;
}

.wallet-item strong{
    color:#fff;
    font-size:1.35rem;
    font-weight:800;
    letter-spacing:1px;
}

@media(max-width:1200px){

  .donation-hero{
    grid-template-columns:1fr;
  }

  .bank-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .impact-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .donation-image{
    height:450px;
  }

}

@media(max-width:768px){

  .donation-section{
    padding:50px 16px 40px;
  }

  .donation-content h1{
    font-size:2.4rem;
  }

  .donation-content p{
    font-size:1rem;
  }

  .donation-image{
    height:320px;
  }

  .image-decoration{
    width:110px;
    height:110px;
  }

  .bank-grid,
  .impact-grid{
    grid-template-columns:1fr;
  }

  .section-title h2{
    font-size:1.8rem;
  }

  .verse-section{
    padding:30px 24px;
  }

  .verse-section p{
    font-size:1.1rem;
  }

}

</style>