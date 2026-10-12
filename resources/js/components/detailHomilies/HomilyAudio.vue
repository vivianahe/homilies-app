<template>
    <section class="homily-player" :class="{ compact, slim }" :aria-label="heading">
        <audio v-if="audioSrc" :key="audioSrc" ref="audio" :src="audioSrc" preload="metadata"
            @loadedmetadata="updateDuration" @durationchange="updateDuration"
            @timeupdate="current = audio.currentTime" @play="handlePlay"
            @pause="playing = false" @ended="playing = false"
            @waiting="buffering = true" @playing="buffering = false"
            @canplay="buffering = false" @error="handleError" />

        <div v-if="!slim" class="player-heading">
            <div class="player-title">
                <span class="headphone-icon"><i class="fa-solid fa-headphones" aria-hidden="true"></i></span>
                <div>
                    <h2>{{ heading }}</h2>
                    <p v-if="subtitle">{{ subtitle }}</p>
                </div>
            </div>
            <a v-if="audioSrc" :href="audioSrc" :download="homily?.audio || ''" class="icon-button download"
                aria-label="Descargar audio" title="Descargar audio">
                <i class="fa-solid fa-download" aria-hidden="true"></i>
            </a>
        </div>

        <div class="player-main">
            <div class="playback-controls">
                <button v-if="!slim" type="button" class="skip-button" :disabled="!duration || !!error"
                    aria-label="Retroceder 15 segundos" @click="skip(-15)">
                    <i class="fa-solid fa-rotate-left" aria-hidden="true"></i><span>15</span>
                </button>
                <button type="button" class="play-button" :disabled="!audioSrc || !!error"
                    :aria-label="playing ? 'Pausar audio' : 'Reproducir audio'" @click="togglePlay">
                    <i :class="buffering ? 'fa-solid fa-spinner fa-spin' : playing ? 'fa-solid fa-pause' : 'fa-solid fa-play'"
                        aria-hidden="true"></i>
                </button>
                <button v-if="!slim" type="button" class="skip-button" :disabled="!duration || !!error"
                    aria-label="Avanzar 15 segundos" @click="skip(15)">
                    <i class="fa-solid fa-rotate-right" aria-hidden="true"></i><span>15</span>
                </button>
            </div>

            <div class="progress-area">
                <input class="progress-slider" type="range" min="0" :max="duration || 0" step="0.1"
                    :value="current" :disabled="!duration || !!error" aria-label="Posición del audio"
                    :aria-valuetext="`${formatTime(current)} de ${formatTime(duration)}`"
                    :style="{ '--progress': `${duration ? current / duration * 100 : 0}%` }"
                    @input="seek(Number($event.target.value))" />
                <div class="time-labels"><span>{{ formatTime(current) }}</span><span>{{ formatTime(duration) }}</span></div>
            </div>

            <div v-if="!slim" class="extra-controls">
                <button type="button" class="speed-button" :disabled="!audioSrc"
                    :aria-label="`Velocidad ${speed} por uno. Cambiar velocidad`" @click="changeSpeed">{{ speed }}×</button>
                <button type="button" class="icon-button" :disabled="!audioSrc"
                    :aria-label="muted ? 'Activar sonido' : 'Silenciar'" @click="toggleMute">
                    <i :class="muted ? 'fa-solid fa-volume-xmark' : 'fa-solid fa-volume-high'" aria-hidden="true"></i>
                </button>
            </div>
            <a v-if="slim && audioSrc" :href="audioSrc" :download="homily?.audio || ''"
                class="icon-button download" aria-label="Descargar audio" title="Descargar audio">
                <i class="fa-solid fa-download" aria-hidden="true"></i>
            </a>
        </div>
        <p v-if="error || !audioSrc" class="player-error" role="status">
            {{ error || 'No hay audio disponible.' }}
        </p>
    </section>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
    homily: { type: Object, default: null },
    source: { type: String, default: '' },
    heading: { type: String, default: 'Escucha la homilía' },
    subtitle: { type: String, default: 'Un momento para escuchar y reflexionar' },
    compact: Boolean,
    slim: Boolean,
    exclusive: Boolean,
});
const audio = ref(null);
const playing = ref(false);
const buffering = ref(false);
const current = ref(0);
const duration = ref(0);
const speed = ref(1);
const muted = ref(false);
const error = ref('');
const audioSrc = computed(() => props.source || (props.homily?.audio ? '/support/audioHomily/' + props.homily.audio : ''));

watch(audioSrc, () => {
    audio.value?.pause();
    playing.value = false;
    buffering.value = false;
    current.value = 0;
    duration.value = 0;
    speed.value = 1;
    muted.value = false;
    error.value = '';
}, { flush: 'pre' });

const handlePlay = () => {
    playing.value = true;
    if (props.exclusive) {
        document.querySelectorAll('audio').forEach(player => {
            if (player !== audio.value) player.pause();
        });
    }
};
const updateDuration = () => {
    duration.value = Number.isFinite(audio.value?.duration) ? audio.value.duration : 0;
};
const togglePlay = async () => {
    const player = audio.value;
    if (!player) return;
    if (!player.paused) {
        player.pause();
        return;
    }
    try {
        await player.play();
    } catch (e) {
        if (player !== audio.value || e.name === 'AbortError') return;
        buffering.value = false;
        playing.value = false;
        if (e.name !== 'NotAllowedError') handleError();
    }
};
const seek = (value) => {
    if (!audio.value || !duration.value) return;
    current.value = Math.max(0, Math.min(value, duration.value));
    audio.value.currentTime = current.value;
};
const skip = (seconds) => seek(current.value + seconds);
const changeSpeed = () => {
    const speeds = [1, 1.25, 1.5, 2, 0.75];
    speed.value = speeds[(speeds.indexOf(speed.value) + 1) % speeds.length];
    if (audio.value) audio.value.playbackRate = speed.value;
};
const toggleMute = () => {
    muted.value = !muted.value;
    if (audio.value) audio.value.muted = muted.value;
};
const handleError = () => {
    playing.value = false;
    buffering.value = false;
    error.value = 'No se pudo cargar el audio. Recarga la página para intentarlo de nuevo.';
};
const formatTime = (seconds) => {
    const value = Number.isFinite(seconds) ? Math.max(0, Math.floor(seconds)) : 0;
    return `${Math.floor(value / 60)}:${String(value % 60).padStart(2, '0')}`;
};
</script>

<style scoped>
.homily-player { padding: 24px; border: 1px solid var(--public-soft); border-radius: 24px; background: var(--public-surface); color: var(--public-heading); }
.player-heading, .player-title, .player-main, .playback-controls, .extra-controls { display: flex; align-items: center; }
.player-heading { justify-content: space-between; gap: 12px; margin-bottom: 22px; }
.player-title { gap: 12px; min-width: 0; }
.headphone-icon { display: grid; place-items: center; width: 44px; height: 44px; flex-shrink: 0; border-radius: 14px; background: var(--public-soft); color: var(--public-primary); font-size: 20px; }
h2 { margin: 0; font-size: 17px; font-weight: 700; }
.player-title p { margin: 3px 0 0; font-size: 12px; color: var(--public-text); }
.player-main { gap: 24px; }
.playback-controls { gap: 12px; }
button, a { -webkit-tap-highlight-color: transparent; }
button:disabled { opacity: .4; cursor: not-allowed; }
button:focus-visible, a:focus-visible, input:focus-visible { outline: 3px solid var(--public-border); outline-offset: 4px; }
.play-button { display: grid; place-items: center; width: 60px; height: 60px; flex-shrink: 0; border-radius: 50%; background: var(--public-primary); color: white; font-size: 21px; box-shadow: 0 6px 16px rgb(37 99 235 / 20%); }
.play-button:hover:not(:disabled) { background: var(--public-primary); }
.skip-button { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px; width: 40px; height: 44px; color: var(--public-text); font-size: 17px; }
.skip-button span { font-size: 10px; font-weight: 600; }
.progress-area { flex: 1; min-width: 0; }
.progress-slider { display: block; width: 100%; height: 6px; margin: 12px 0; padding: 0; appearance: none; border: 0; border-radius: 999px; background: linear-gradient(to right, var(--public-primary) var(--progress), var(--public-soft) var(--progress)); cursor: pointer; }
.progress-slider::-webkit-slider-thumb { appearance: none; width: 16px; height: 16px; border: 3px solid white; border-radius: 50%; background: var(--public-primary); box-shadow: 0 1px 5px var(--public-primary); }
.progress-slider::-moz-range-thumb { width: 10px; height: 10px; border: 3px solid white; border-radius: 50%; background: var(--public-primary); box-shadow: 0 1px 5px var(--public-primary); }
.time-labels { display: flex; justify-content: space-between; color: var(--public-text); font-size: 12px; font-variant-numeric: tabular-nums; }
.extra-controls { gap: 8px; }
.icon-button, .speed-button { display: inline-flex; align-items: center; justify-content: center; min-width: 44px; height: 44px; border-radius: 12px; color: var(--public-primary); background: white; border: 1px solid var(--public-soft); }
.speed-button { padding: 0 10px; font-size: 13px; font-weight: 700; }
.icon-button:hover, .speed-button:hover { background: var(--public-surface); }
.player-error { margin-top: 16px; font-size: 13px; color: #b45309; }
.compact { padding: 16px; border-radius: 18px; background: #f8fafc; border-color: #e2e8f0; }
.compact .icon-button, .compact .speed-button { color: var(--public-text); border-color: #e2e8f0; background: white; }
.compact .icon-button:hover, .compact .speed-button:hover { background: #f1f5f9; }
.compact .progress-slider { background: linear-gradient(to right, var(--public-primary) var(--progress), #e2e8f0 var(--progress)); }
.compact .headphone-icon { display: none; }
.compact h2 { font-size: 13px; }
.compact .player-heading { margin-bottom: 10px; }
.compact .player-main { flex-wrap: wrap; gap: 12px 6px; justify-content: space-between; }
.compact .progress-area { order: -1; flex-basis: 100%; }
.compact .playback-controls { gap: 2px; }
.compact .play-button { width: 48px; height: 48px; font-size: 18px; }
.compact .skip-button { width: 32px; }
.compact .extra-controls { gap: 4px; }
@media (max-width: 768px) {
    .homily-player { padding: 20px 16px; border-radius: 20px; }
    .player-title p { font-size: 11px; }
    h2 { font-size: 15px; }
    .headphone-icon { display: none; }
    .player-main { flex-wrap: wrap; gap: 16px 8px; justify-content: space-between; }
    .progress-area { order: -1; flex-basis: 100%; }
    .playback-controls { gap: 4px; }
    .play-button { width: 54px; height: 54px; }
    .extra-controls { gap: 6px; }
}
/* Barra de audio para los días de reflexión, también en pantallas pequeñas. */
.homily-player.slim { padding: 12px; border-radius: 16px; background: var(--public-surface); border-color: #e2e8f0; }
.slim .player-main { flex-wrap: nowrap; gap: 12px; }
.slim .playback-controls { flex-shrink: 0; }
.slim .play-button { width: 44px; height: 44px; font-size: 16px; box-shadow: 0 3px 8px rgb(37 99 235 / 15%); }
.slim .progress-area { order: 0; flex: 1; min-width: 0; }
.slim .progress-slider { margin: 9px 0; height: 4px; }
.slim .time-labels { font-size: 10px; }
.slim .download { flex-shrink: 0; color: var(--public-text); background: transparent; border-color: transparent; }
.slim .download:hover { background: white; color: var(--public-primary); }
</style>