<template>

    <div>

        <audio
            ref="audio"
            controls
            style="width:100%;display:block;height:54px;"
            :src="audioSrc"
        >
        </audio>

    </div>

</template>

<script setup>

import {
    ref,
    computed,
    watch,
    nextTick
} from 'vue'


const props = defineProps({

    homily: {
        type: Object,
        default: null
    }

})


const audio = ref(null)


const audioSrc = computed(() => {

    if (!props.homily || !props.homily.audio) {
        return ''
    }

    return '/support/audioHomily/' + props.homily.audio

})


watch(
    audioSrc,
    async (newSrc) => {

        if (!newSrc) {
            return
        }

        await nextTick()

        if (!audio.value) {
            return
        }

        audio.value.load()

    },
    {
        immediate: true
    }
)

</script>

<style scoped>
</style>