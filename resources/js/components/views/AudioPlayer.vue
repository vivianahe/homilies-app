<template>
    <div
        class="
        rounded-3xl
        border
        border-slate-200
        bg-gradient-to-br
        from-slate-50
        to-white
        p-5
        shadow-inner
        "
    >

        <!-- Audio oculto -->
        <audio
            ref="audio"
            :src="src"
            @loadedmetadata="loaded"
            @timeupdate="timeUpdate"
            @ended="ended"
        />

        <!-- Controles -->
        <div class="flex items-center gap-4">

            <!-- Botón -->
            <button
                @click="togglePlay"
                class="
                    flex
                    h-14
                    w-14
                    items-center
                    justify-center
                    rounded-full
                    text-white
                    shadow-xl
                    transition-all
                    duration-300
                    hover:scale-110
                    active:scale-95
                "
                :class="buttonColor"
            >
                <Play
                    v-if="!playing"
                    class="h-6 w-6"
                />

                <Pause
                    v-else
                    class="h-6 w-6"
                />
            </button>

            <!-- Barra -->
            <div class="flex-1">

                <!-- Estado del reproductor -->
                <p
                    class="mb-3 text-xs uppercase tracking-[0.2em] text-slate-400 font-semibold"
                >
                    {{ playing ? 'REPRODUCIENDO' : 'LISTO PARA REPRODUCIR' }}
                </p>

                <input
                    type="range"
                    min="0"
                    :max="duration"
                    v-model="current"
                    @input="seek"
                    class="
                        w-full
                        h-2
                        cursor-pointer
                        accent-indigo-600
                    "
                />

                <div
                    class="mt-2 flex justify-between text-sm font-semibold text-slate-500"
                >
                    <span>{{ format(current) }}</span>
                    <span>{{ format(duration) }}</span>
                </div>

            </div>

        </div>

    </div>
</template>

<script setup>

import { ref, computed } from 'vue'
import { Play, Pause } from 'lucide-vue-next'

const props = defineProps({

    src: String,

    color: {
        type: Object,
        default: () => ({})
    }

})

const audio = ref(null)

const playing = ref(false)

const duration = ref(0)

const current = ref(0)

const buttonColor = computed(() => {

    if (props.color.bg.includes('violet'))
        return 'bg-violet-600'

    if (props.color.bg.includes('blue'))
        return 'bg-blue-600'

    if (props.color.bg.includes('emerald'))
        return 'bg-emerald-600'

    if (props.color.bg.includes('orange'))
        return 'bg-orange-500'

    if (props.color.bg.includes('pink'))
        return 'bg-pink-600'

    return 'bg-indigo-600'

})

const togglePlay = () => {

    if (!audio.value) return

    if (playing.value) {

        audio.value.pause()

        playing.value = false

    } else {

        audio.value.play()

        playing.value = true

    }

}

const loaded = () => {

    duration.value = audio.value.duration

}

const timeUpdate = () => {

    current.value = audio.value.currentTime

}

const seek = () => {

    audio.value.currentTime = current.value

}

const ended = () => {

    playing.value = false

}

const format = (sec) => {

    if (!sec) return "0:00"

    const m = Math.floor(sec / 60)

    const s = Math.floor(sec % 60)

    return `${m}:${String(s).padStart(2, "0")}`

}

</script>