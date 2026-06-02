<template>

<section class="audio-card">

  <div class="audio-row">

    <div class="audio-left">

      <div class="audio-label">

        <div class="audio-icon">
          <i class="fa-solid fa-headphones"></i>
        </div>

        <div class="audio-title">
          Homilía
        </div>

      </div>

      <audio
        controls
        class="audio-player"
      >
        <source
          v-if="homily.audio"
          :src="'/support/audioHomily/' + homily.audio"
          type="audio/mp3"
        />
      </audio>

    </div>

    <button
      class="btn-share"
      @click="shareHomily"
    >
      <i class="fa-solid fa-share-nodes"></i>
      Compartir
    </button>

  </div>

</section>
</template>

<script setup>

const props = defineProps({
  homily: Object
})

const shareHomily = async () => {

  const url = window.location.href;

  if (navigator.share) {

    await navigator.share({
      title: props.homily.title,
      text: props.homily.description,
      url
    });

  } else {

    await navigator.clipboard.writeText(url);

    alert('Enlace copiado al portapapeles');

  }
};

</script>

<style scoped>

.audio-row{
  display:flex;
  align-items:center;
  gap:18px;
}

.audio-left{
  flex:1;

  display:flex;
  align-items:center;
  gap:18px;
}

.audio-card{
  margin-top:25px;
  background:white;
  border-radius:24px;
  padding:25px;
  box-shadow:0 8px 30px rgba(0,0,0,.08);
}

.audio-player{
  width:100%;
}  

.audio-card{
  margin-top:24px;

  background:#fff;

  border:1px solid #e5e7eb;
  border-radius:24px;

  padding:18px 20px;
}

.audio-left{
  display:flex;
  align-items:center;
  gap:18px;
}

.audio-label{
  display:flex;
  align-items:center;
  gap:12px;

  flex-shrink:0;
}

.audio-icon{
  width:52px;
  height:52px;

  border-radius:50%;

  display:flex;
  align-items:center;
  justify-content:center;

  background:linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
  );

  color:#fff;
  font-size:20px;
}

.audio-title{
  font-size:1.25rem;
  font-weight:700;
  color:#0f172a;
}

.audio-player{
  flex:1;
  min-width:0;
  height:54px;
}

.audio-player::-webkit-media-controls-panel{
  background:#f8fafc;
}


.btn-share,
.btn-read{
  height:48px;

  border-radius:14px;

  padding:0 22px;

  display:flex;
  align-items:center;
  gap:10px;

  font-size:.95rem;
  font-weight:700;

  cursor:pointer;

  transition:.2s ease;
}

.btn-share{
  height:48px;

  padding:0 24px;

  border-radius:14px;

  background:#fff;

  border:1px solid #dbeafe;

  color:#2563eb;

  display:flex;
  align-items:center;
  gap:10px;

  font-weight:700;

  white-space:nowrap;

  flex-shrink:0;
}

.btn-share:hover{
  background:#eff6ff;
}

.btn-read:hover{
  background:#1d4ed8;
}

@media(max-width:768px){

  .audio-row{
    flex-direction:column;
    align-items:stretch;
  }

  .audio-left{
    flex-direction:column;
    align-items:stretch;
  }

  .btn-share{
    width:100%;
    justify-content:center;
  }

}

</style>