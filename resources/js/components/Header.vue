<template>
    <header
        class="main-header"
        :class="{ 'main-header--scrolled': isScrolled }"
    >
        <!-- =====================================================
             BARRA PRINCIPAL
        ====================================================== -->
        <nav class="navbar-container">

            <!-- BOTÓN MENÚ MÓVIL -->
            <button
                type="button"
                class="mobile-menu-button"
                @click="toggleMenu"
                :aria-expanded="menuOpen"
                :aria-label="menuOpen ? 'Cerrar menú' : 'Abrir menú'"
            >
                <i
                    :class="
                        menuOpen
                            ? 'fa-solid fa-xmark'
                            : 'fa-solid fa-bars'
                    "
                ></i>
            </button>


            <!-- =================================================
                 LOGO
            ================================================== -->
            <RouterLink
                :to="{ name: 'inicio' }"
                class="brand"
                aria-label="Ir al inicio"
                @click="closeMenu"
            >
                <img
                    src="/img/logo.png"
                    alt="Padre Uriel Franco - Homilías"
                    class="brand-logo"
                />
            </RouterLink>


            <!-- =================================================
                 MENÚ DESKTOP
            ================================================== -->
            <div class="desktop-navigation">

                <!-- INICIO -->
                <RouterLink
                    :to="{ name: 'inicio' }"
                    class="nav-link"
                >
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </RouterLink>


                <!-- HOMILÍAS -->
                <RouterLink
                    :to="{ name: 'homilyAllNew' }"
                    class="nav-link"
                >
                    <i class="fa-solid fa-book-open"></i>
                    <span>Homilías</span>
                </RouterLink>


                <!-- CANTA Y ORA -->
                <RouterLink
                    :to="{ name: 'chantPublic' }"
                    class="nav-link"
                >
                    <i class="fa-solid fa-music"></i>
                    <span>Canta y ora</span>
                </RouterLink>


                <!-- CONTÁCTENOS -->
                <RouterLink
                    :to="{ name: 'contact' }"
                    class="nav-link"
                >
                    <i class="fa-regular fa-envelope"></i>
                    <span>Contáctenos</span>
                </RouterLink>

            </div>


            <!-- =================================================
                 BOTÓN DONAR
            ================================================== -->
            <div
                class="navbar-actions"
                :class="{
                    'navbar-actions--mobile-open': menuOpen
                }"
            >
                <RouterLink
                    :to="{ name: 'donateView' }"
                    class="donate-button"
                    @click="closeMenu"
                >
                    <i class="fa-regular fa-heart"></i>
                    <span>Donar</span>
                </RouterLink>
            </div>

        </nav>


        <!-- =====================================================
             MENÚ MÓVIL ABIERTO
        ====================================================== -->
        <div
            v-if="menuOpen"
            class="mobile-menu"
        >

            <div class="mobile-menu-grid">

                <!-- COLUMNA IZQUIERDA -->
                <div class="mobile-menu-column">

                    <!-- INICIO -->
                    <RouterLink
                        :to="{ name: 'inicio' }"
                        class="mobile-nav-link"
                        @click="closeMenu"
                    >
                        <i class="fa-solid fa-house"></i>
                        <span>Inicio</span>
                    </RouterLink>


                    <!-- HOMILÍAS -->
                    <RouterLink
                        :to="{ name: 'homilyAllNew' }"
                        class="mobile-nav-link"
                        @click="closeMenu"
                    >
                        <i class="fa-solid fa-book-open"></i>
                        <span>Homilías</span>
                    </RouterLink>

                </div>


                <!-- COLUMNA DERECHA -->
                <div
                    class="
                        mobile-menu-column
                        mobile-menu-column-right
                    "
                >

                    <!-- CANTA Y ORA -->
                    <RouterLink
                        :to="{ name: 'chantPublic' }"
                        class="mobile-nav-link"
                        @click="closeMenu"
                    >
                        <i class="fa-solid fa-music"></i>
                        <span>Canta y ora</span>
                    </RouterLink>


                    <!-- CONTÁCTENOS -->
                    <RouterLink
                        :to="{ name: 'contact' }"
                        class="mobile-nav-link"
                        @click="closeMenu"
                    >
                        <i class="fa-regular fa-envelope"></i>
                        <span>Contáctenos</span>
                    </RouterLink>

                </div>

            </div>


            <!-- =================================================
                 REDES SOCIALES
            ================================================== -->
            <div class="mobile-menu-footer">

                <div class="social-links">

                    <!-- YOUTUBE -->
                    <a
                        href="https://www.youtube.com/@Padreurielfranco"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-button"
                        aria-label="YouTube"
                    >
                        <i class="fa-brands fa-youtube"></i>
                    </a>


                    <!-- INSTAGRAM -->
                    <a
                        href="https://www.instagram.com/padreurielfrancos/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-button"
                        aria-label="Instagram"
                    >
                        <i class="fa-brands fa-instagram"></i>
                    </a>


                    <!-- TIKTOK -->
                    <a
                        href="https://www.tiktok.com/@padreurielfranco"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-button"
                        aria-label="TikTok"
                    >
                        <i class="fa-brands fa-tiktok"></i>
                    </a>

                </div>

            </div>

        </div>

    </header>
</template>


<script setup>

import {
    ref,
    onMounted,
    onUnmounted
} from "vue";

import { RouterLink } from "vue-router";


const menuOpen = ref(false);

const isScrolled = ref(false);


/* =========================================================
   MENÚ MÓVIL
========================================================= */

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};


const closeMenu = () => {
    menuOpen.value = false;
};


/* =========================================================
   SCROLL
========================================================= */

const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
};


onMounted(() => {
    window.addEventListener(
        "scroll",
        handleScroll
    );
});


onUnmounted(() => {
    window.removeEventListener(
        "scroll",
        handleScroll
    );
});

</script>


<style scoped>

/* =========================================================
   HEADER GENERAL
========================================================= */

.main-header {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0;
    z-index: 50;
    background: #ffffff;
}


/* =========================================================
   NAVBAR DESKTOP
========================================================= */

.navbar-container {
    position: relative;

    width: 100%;
    max-width: none;

    min-height: 110px;

    margin: 0;
    padding: 0 5%;

    display: flex;
    align-items: center;

    background: #ffffff;

    border-radius: 0;

    box-shadow:
        0 6px 22px rgba(15, 35, 90, 0.06);
}


/* =========================================================
   BOTÓN MENÚ MÓVIL
========================================================= */

.mobile-menu-button {
    display: none;
}


/* =========================================================
   LOGO DESKTOP
========================================================= */

/* =========================================================
   LOGO DESKTOP
========================================================= */

.brand {
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 35px;

    text-decoration: none;
}

.brand-logo {
    display: block;

    /* Logo con mayor presencia */
    width: 205px;
    height: auto;

    max-height: 82px;

    object-fit: contain;

    transition: transform 0.2s ease;
}

.brand:hover .brand-logo {
    transform: scale(1.02);
}


/* =========================================================
   NAVEGACIÓN DESKTOP
========================================================= */

.desktop-navigation {
    flex: 1;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 28px;
}

.nav-link {
    position: relative;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    padding: 13px 14px;

    color: #071a58;

    font-size: 14px;
    font-weight: 500;

    line-height: 1;

    white-space: nowrap;

    text-decoration: none;

    border-radius: 30px;

    transition:
        color 0.2s ease,
        background-color 0.2s ease,
        transform 0.2s ease;
}

.nav-link i {
    font-size: 18px;

    color: #071a58;

    transition: color 0.2s ease;
}


/* =========================================================
   HOVER NAVEGACIÓN
========================================================= */

.nav-link:hover {
    color: #1646e8;
    background: #f7f9ff;
}

.nav-link:hover i {
    color: #1646e8;
}


/* =========================================================
   MENÚ ACTIVO
========================================================= */

.nav-link.router-link-active {
    color: #1646e8;

    font-weight: 600;

    background: #f1f5ff;
}

.nav-link.router-link-active i {
    color: #1646e8;
}

.nav-link.router-link-active::after {
    content: "";

    position: absolute;

    left: 50%;
    bottom: 4px;

    width: 22px;
    height: 3px;

    transform: translateX(-50%);

    background: #1646e8;

    border-radius: 999px;
}


/* =========================================================
   ACCIONES DERECHA
========================================================= */

.navbar-actions {
    flex-shrink: 0;

    display: flex;
    align-items: center;

    margin-left: 30px;
}


/* =========================================================
   BOTÓN DONAR
========================================================= */

.donate-button {
    min-height: 50px;

    padding: 0 25px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 9px;

    border-radius: 999px;

    background:
        linear-gradient(
            135deg,
            #2144ef 0%,
            #6137ff 100%
        );

    color: #ffffff;

    font-size: 15px;
    font-weight: 600;

    text-decoration: none;

    box-shadow:
        0 8px 18px rgba(69, 57, 239, 0.22);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.donate-button i {
    font-size: 18px;
}

.donate-button:hover {
    color: #ffffff;

    transform: translateY(-1px);

    box-shadow:
        0 10px 24px rgba(69, 57, 239, 0.30);
}


/* =========================================================
   MENÚ MÓVIL
========================================================= */

.mobile-menu {
    display: none;
}


/* =========================================================
   TABLET + MÓVIL
========================================================= */

@media (max-width: 900px) {

    .main-header {
        position: relative;

        width: 100%;

        padding: 0;

        background: #ffffff;
    }


    /* BARRA SUPERIOR */

    .navbar-container {
        position: relative;

        width: 100%;
        max-width: none;

        height: 96px;
        min-height: 96px;

        margin: 0;

        padding: 0 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #ffffff;

        border-radius: 0;

        box-shadow:
            0 3px 12px rgba(15, 35, 90, 0.07);
    }


    /* OCULTAR MENÚ DESKTOP */

    .desktop-navigation {
        display: none;
    }


    /* BOTÓN HAMBURGUESA */

    .mobile-menu-button {
        position: absolute;

        left: 20px;
        top: 50%;

        transform: translateY(-50%);

        width: 44px;
        height: 44px;

        padding: 0;

        display: flex;
        align-items: center;
        justify-content: flex-start;

        border: none;

        background: transparent;

        color: #1646e8;

        font-size: 24px;

        cursor: pointer;

        z-index: 5;
    }

    .mobile-menu-button:hover {
        color: #6137ff;
    }

    .mobile-menu-button:focus {
        outline: none;
    }


    /* LOGO MÓVIL */

    .brand {
        position: relative;

        margin: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        z-index: 2;
    }

    .brand-logo {
        display: block;

        width: 150px;
        max-width: none;

        height: auto;

        object-fit: contain;
    }


    /* DONAR CERRADO */

    .navbar-actions {
        display: none;

        margin: 0;
    }


    /* DONAR MENÚ ABIERTO */

    .navbar-actions--mobile-open {
        position: absolute;

        right: 20px;
        top: 50%;

        transform: translateY(-50%);

        display: flex;
        align-items: center;

        margin: 0;

        z-index: 5;
    }

    .navbar-actions--mobile-open .donate-button {
        min-height: 44px;

        padding: 0 18px;

        gap: 7px;

        font-size: 14px;

        box-shadow:
            0 6px 15px rgba(69, 57, 239, 0.22);
    }

    .navbar-actions--mobile-open .donate-button i {
        font-size: 16px;
    }


    /* =====================================================
       PANEL MENÚ MÓVIL
    ===================================================== */

    .mobile-menu {
        position: relative;

        width: 100%;

        padding: 25px 20px 18px;

        display: block;

        background: #ffffff;

        border-top: 1px solid #e9edf5;

        box-shadow:
            0 12px 25px rgba(15, 35, 90, 0.08);

        z-index: 4;
    }


    /* GRID */

    .mobile-menu-grid {
        width: 100%;

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 0;
    }


    /* COLUMNAS */

    .mobile-menu-column {
        display: flex;
        flex-direction: column;

        gap: 4px;

        padding-right: 18px;
    }

    .mobile-menu-column-right {
        padding-right: 0;
        padding-left: 18px;

        border-left: 1px solid #e3e7ef;
    }


    /* LINKS */

    .mobile-nav-link {
        position: relative;

        width: 100%;
        min-height: 43px;

        display: grid;

        grid-template-columns:
            25px
            minmax(0, 1fr)
            auto;

        align-items: center;

        gap: 8px;

        padding: 7px 10px;

        color: #071a58;

        font-size: 14px;
        font-weight: 500;

        line-height: 1.2;

        text-decoration: none;

        border-radius: 8px;

        transition:
            background-color 0.2s ease,
            color 0.2s ease;
    }

    .mobile-nav-link:hover {
        background: #f7f8fc;

        color: #1646e8;
    }

    .mobile-nav-link > i:first-child {
        width: 22px;

        color: #1646e8;

        font-size: 18px;

        text-align: center;
    }


    /* ACTIVO MÓVIL */

    .mobile-nav-link.router-link-active {
        color: #1646e8;

        font-weight: 600;

        background: #eef4ff;
    }

    .mobile-nav-link.router-link-active > i:first-child {
        color: #1646e8;
    }

    .mobile-nav-link.router-link-active::before {
        content: "";

        position: absolute;

        left: 0;
        top: 50%;

        width: 3px;
        height: 22px;

        transform: translateY(-50%);

        background: #1646e8;

        border-radius: 0 4px 4px 0;
    }


    /* FOOTER MENÚ */

    .mobile-menu-footer {
        width: 100%;

        margin-top: 20px;

        padding-top: 18px;
        padding-bottom: 2px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-top: 1px solid #e3e7ef;
    }


    /* REDES */

    .social-links {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 14px;
    }

    .social-button {
        width: 42px;
        height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border: 1px solid #e2e7f0;
        border-radius: 50%;

        background: #ffffff;

        color: #071a58;

        font-size: 17px;

        text-decoration: none;

        box-shadow:
            0 3px 8px rgba(15, 35, 90, 0.07);

        transition:
            color 0.2s ease,
            background-color 0.2s ease,
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .social-button:hover {
        color: #1646e8;

        background: #f7f8fc;

        transform: translateY(-2px);

        box-shadow:
            0 5px 12px rgba(15, 35, 90, 0.10);
    }
}


/* =========================================================
   MÓVILES PEQUEÑOS
========================================================= */

@media (max-width: 480px) {

    .navbar-container {
        height: 96px;
        min-height: 96px;

        padding: 0 16px;
    }

    .mobile-menu-button {
        left: 16px;

        width: 42px;
        height: 42px;

        font-size: 23px;
    }

    .brand-logo {
        width: 145px;
    }

    .navbar-actions--mobile-open {
        right: 16px;
    }

    .navbar-actions--mobile-open .donate-button {
        min-height: 42px;

        padding: 0 15px;

        gap: 6px;

        font-size: 13px;
    }

    .navbar-actions--mobile-open .donate-button i {
        font-size: 15px;
    }

    .mobile-menu {
        padding: 22px 16px 16px;
    }

    .mobile-menu-column {
        padding-right: 12px;
    }

    .mobile-menu-column-right {
        padding-left: 12px;
        padding-right: 0;
    }

    .mobile-nav-link {
        grid-template-columns:
            23px
            minmax(0, 1fr)
            auto;

        gap: 6px;

        padding: 7px 8px;

        font-size: 13px;
    }

    .mobile-nav-link > i:first-child {
        width: 20px;

        font-size: 17px;
    }

    .mobile-menu-footer {
        margin-top: 18px;

        padding-top: 17px;
    }

    .social-links {
        width: 100%;

        justify-content: center;

        gap: 12px;
    }

    .social-button {
        width: 38px;
        height: 38px;

        font-size: 15px;
    }
}


/* =========================================================
   MÓVILES MUY PEQUEÑOS
========================================================= */

@media (max-width: 360px) {

    .navbar-container {
        padding: 0 12px;
    }

    .mobile-menu-button {
        left: 12px;
    }

    .brand-logo {
        width: 130px;
    }

    .navbar-actions--mobile-open {
        right: 12px;
    }

    .navbar-actions--mobile-open .donate-button {
        padding: 0 12px;

        font-size: 12px;
    }

    .mobile-menu {
        padding: 20px 12px 14px;
    }

    .mobile-menu-column {
        padding-right: 8px;
    }

    .mobile-menu-column-right {
        padding-left: 8px;
    }

    .mobile-nav-link {
        gap: 4px;

        padding-left: 7px;
        padding-right: 7px;

        font-size: 12px;
    }

    .mobile-menu-footer {
        margin-top: 16px;

        padding-top: 16px;
    }

    .social-links {
        justify-content: center;

        gap: 10px;
    }

    .social-button {
        width: 36px;
        height: 36px;

        font-size: 14px;
    }
}

</style>