<!-- TODO : buffer fetch request -->

<template>
  <div class="audio-player">
    <audio
      ref="audioElement"
      @timeupdate="updateTime"
      @loadedmetadata="updateDuration"
    >
      <source :src="currentSongUrl" type="audio/mpeg" />
      Your browser does not support the audio element.
    </audio>
    <div class="controls">
      <button @click="togglePlayback">
        {{ isPlaying ? "Pause" : "Play" }}
      </button>
      <input
        v-model="currentTime"
        type="range"
        :max="duration"
        @input="seekToTime"
      />
      <span>{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentSongUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      isPlaying: false,
      currentTime: 0,
      duration: 0,
      currentSong: null,
    };
  },
  methods: {
    togglePlayback() {
      this.isPlaying = !this.isPlaying;
      if (this.isPlaying) {
        this.$refs.audioElement.play();
      } else {
        this.$refs.audioElement.pause();
      }
    },
    updateTime() {
      this.currentTime = this.$refs.audioElement.currentTime;
      // this.duration = this.$refs.audioElement.duration;
    },
    seekToTime() {
      this.$refs.audioElement.currentTime = this.currentTime;
      // this.$refs.audioElement.play();
    },
    formatTime(time) {
      const minutes = Math.floor(time / 60);
      const seconds = Math.floor(time % 60);
      return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    },
    updateDuration() {
      this.duration = this.$refs.audioElement.duration;
      this.togglePlayback();
      // console.log(this.duration);
    },
  },
};
</script>

<style scoped>
/* Add your styling here */
</style>
