<template>

  <footer class="footer">

    <div class="footer-container">

      <div class="footer-brand">

        <div class="footer-icon">

          <i class="fa-solid fa-book-bible"></i>

        </div>

        <h3>
          Homilías Padre Uriel
        </h3>

        <p>
          Evangelio, reflexión y oración para fortalecer tu fe cada día.
        </p>

      </div>

      <div class="footer-actions">

        <RouterLink
          :to="{ name:'contact' }"
          class="footer-button"
        >
          <i class="fa-solid fa-envelope"></i>
          Contáctanos
        </RouterLink>

        <RouterLink
          :to="{ name:'donateView' }"
          class="footer-button primary"
        >
          <i class="fa-solid fa-hand-holding-heart"></i>
          Apoyar ministerio
        </RouterLink>

      </div>

      <div class="footer-social">

        <a
          href="https://www.youtube.com/@Padreurielfranco"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="YouTube"
        >
          <i class="fa-brands fa-youtube"></i>
        </a>

        <a
          href="https://www.instagram.com/padreurielfrancos/"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Instagram"
        >
          <i class="fa-brands fa-instagram"></i>
        </a>

        <a
          href="https://www.tiktok.com/@padreurielfranco"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="TikTok"
        >
          <i class="fa-brands fa-tiktok"></i>
        </a>

      </div>

      <div class="footer-bottom">

        © {{ currentYear }}
        Homilías Padre Uriel.
        Todos los derechos reservados.

      </div>

    </div>

  </footer>
</template>

<script setup>

import { ref } from "vue";
import { RouterLink } from "vue-router";

const currentYear = ref(
  new Date().getFullYear()
);

</script>

<style scoped>

.footer-social{

  display:flex;

  justify-content:center;

  align-items:center;

  gap:16px;

  margin:30px 0;
}

.footer-social a{

  width:54px;
  height:54px;

  border-radius:16px;

  background:#f8fbff;

  border:1px solid #dbeafe;

  color:#2563eb;

  display:flex;
  align-items:center;
  justify-content:center;

  text-decoration:none;

  font-size:1.3rem;

  transition:all .25s ease;
}

.footer-social a:hover{

  background:#2563eb;

  color:#fff;

  transform:translateY(-4px);

  box-shadow:
    0 12px 24px rgba(37,99,235,.25);
}

.footer{

  margin-top:0;

  background:
    linear-gradient(
      180deg,
      #f8fafc 0%,
      #eef6ff 100%
    );

  border-top:1px solid #dbeafe;
}

.footer-container{

  max-width:1200px;

  margin:0 auto;

  padding:48px 24px 28px;
}

.footer-brand{

  text-align:center;
}

.footer-icon{

  width:72px;
  height:72px;

  margin:0 auto 18px;

  border-radius:20px;

  background:#2563eb;

  display:flex;
  align-items:center;
  justify-content:center;

  color:white;

  font-size:30px;

  box-shadow:
    0 12px 30px rgba(37,99,235,.25);
}

.footer-brand h3{

  font-size:2rem;

  font-weight:800;

  color:#0f172a;

  margin-bottom:10px;
}

.footer-brand p{

  max-width:620px;

  margin:0 auto;

  color:#64748b;

  line-height:1.8;
}

.footer-actions{

  display:flex;

  justify-content:center;

  gap:16px;

  margin-top:32px;

  flex-wrap:wrap;
}

.footer-button{

  height:48px;

  padding:0 20px;

  border-radius:14px;

  border:1px solid #dbeafe;

  background:white;

  display:flex;
  align-items:center;
  gap:10px;

  text-decoration:none;

  color:#334155;

  font-weight:700;

  transition:.25s;
}

.footer-button:hover{

  transform:translateY(-2px);
}

.footer-button.primary{

  background:#2563eb;

  color:white;

  border:none;

  box-shadow:
    0 10px 25px rgba(37,99,235,.25);
}

.footer-bottom{

  margin-top:40px;

  padding-top:24px;

  border-top:1px solid #dbeafe;

  text-align:center;

  color:#94a3b8;

  font-size:.9rem;
}

@media(max-width:768px){

  .footer-container{
    padding:40px 18px 24px;
  }

  .footer-brand h3{
    font-size:1.6rem;
  }

}
</style>
