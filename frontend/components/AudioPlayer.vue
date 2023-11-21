<template>
  <div class="relative audio-player bg-white">
    <div class="hidden xl:flex absolute left-0 z-10 px-6 items-center gap-4">
      <div>
        <img
          :src="currentSong?.cover_file"
          alt="cover"
          class="w-[58px] object-cover rounded"
        />
      </div>
      <div class="flex flex-col">
        <p class="text-xl">{{ currentSong?.name }}</p>
        <p class="text-sm text-gray-500 whitespace-nowrap">
          {{ currentSong?.artists[0].name }}
        </p>
      </div>
    </div>
    <audio
      ref="audioElement"
      :src="currentSong?.file2"
      @timeupdate="updateTime"
      @loadedmetadata="updateDuration"
      @ended="playNextSong"
    ></audio>
    <div class="absolute controls border-t bg-white w-full py-8">
      <div class="flex flex-col justify-center items-center gap-6">
        <div class="controls_btns flex items-center gap-8 justify-center">
          <button @click="playPrevious">
            <svg
              width="20"
              height="20"
              viewBox="0 0 49 50"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M11.145 28.8432L11.145 47.4046C11.145 48.3233 10.4307 49.0697 9.44864 49.0697L2.48474 49.0697C1.59193 49.0697 0.877686 48.3233 0.877686 47.4046L0.87769 2.59642C0.87769 1.67772 1.59193 0.932262 2.48474 0.932262L9.44864 0.932263C10.4307 0.932263 11.145 1.67772 11.145 2.59642L11.145 21.1579L45.0717 1.56168C45.8752 1.10009 46.8573 1.10009 47.6608 1.56168C48.4643 2.02326 49 2.87585 49 3.79901C49 13.5199 49 36.4811 49 46.2029C49 47.1251 48.4643 47.9778 47.6608 48.4393C46.8573 48.9009 45.8752 48.901 45.0717 48.4403L11.145 28.8432Z"
                fill="#becdcf"
              />
            </svg>
          </button>
          <button @click="togglePlayback">
            <svg
              v-if="isPlaying === true"
              width="40"
              height="40"
              viewBox="0 0 110 110"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M55.0039 0C85.3633 0 110.008 24.6441 110.008 54.9995C110.008 85.3559 85.3633 110 55.0039 110C24.6446 110 0 85.3559 0 54.9995C0 24.6441 24.6446 0 55.0039 0ZM48.5749 33.0133C48.5749 31.7902 47.5034 30.7965 46.3426 30.7965H37.0562C35.8061 30.7965 34.8239 31.7902 34.8239 33.0133V76.7162C34.8239 77.9402 35.8061 78.9339 37.0562 78.9339H46.3426C47.5034 78.9339 48.5749 77.9402 48.5749 76.7162V33.0133ZM76.0769 33.0133C76.0769 31.7902 75.0947 30.7965 73.8446 30.7965H64.5582C63.3081 30.7965 62.3259 31.7902 62.3259 33.0133V76.7162C62.3259 77.9402 63.3081 78.9339 64.5582 78.9339H73.8446C75.0947 78.9339 76.0769 77.9402 76.0769 76.7162V33.0133Z"
                fill="#78a0a5"
              />
            </svg>
            <svg
              v-else
              width="40"
              height="40"
              viewBox="0 0 110 110"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M55 110C85.3757 110 110 85.3756 110 55C110 24.6244 85.3757 0 55 0C24.6243 0 0 24.6244 0 55C0 85.3756 24.6243 110 55 110ZM79.788 59.6558C82.7477 57.6758 82.7477 53.3242 79.788 51.3442L46.5302 29.095C43.2079 26.8724 38.75 29.2537 38.75 33.2507V77.7493C38.75 81.7463 43.2079 84.1276 46.5302 81.905L79.788 59.6558Z"
                fill="#78a0a5"
              />
            </svg>
          </button>
          <button @click="playNextSong">
            <svg
              width="20"
              height="20"
              viewBox="0 0 49 50"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M37.855 21.1588V2.59737C37.855 1.67867 38.5693 0.932251 39.5514 0.932251H46.5153C47.4081 0.932251 48.1223 1.67867 48.1223 2.59737V47.4055C48.1223 48.3242 47.4081 49.0697 46.5153 49.0697H39.5514C38.5693 49.0697 37.855 48.3242 37.855 47.4055V28.844L3.92835 48.4403C3.12483 48.9019 2.14274 48.9019 1.33921 48.4403C0.535685 47.9787 0 47.1261 0 46.2029C0 36.4821 0 13.5209 0 3.79908C0 2.87681 0.535685 2.0242 1.33921 1.56262C2.14274 1.10104 3.12483 1.10097 3.92835 1.56166L37.855 21.1588Z"
                fill="#becdcf"
              />
            </svg>
          </button>
        </div>
        <div class="progress flex items-center relative">
          <span class="absolute left-[-40px]">
            {{ formatTime(currentTime) }}
          </span>
          <input
            v-model="currentTime"
            class="min-w-[200px] max-w-[200px] xl:min-w-[400px] xl:max-w-[400px] w-full"
            :style="sliderStyle"
            min="0"
            :max="duration"
            type="range"
            @input="seekToTime"
          />
          <span class="absolute right-[-40px]">
            {{ formatTime(duration) }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentSong: {
      type: Object,
      default: () => {
        return {};
      },
    },
  },
  emits: ["play-next", "play-previous"],
  data() {
    return {
      isPlaying: false,
      currentTime: 0,
      duration: 0,
    };
  },
  computed: {
    sliderStyle() {
      const percentage = (this.currentTime / this.duration) * 100;
      return {
        background: `linear-gradient(to right, #78a0a5 ${percentage}%, rgb(181, 194, 196) ${percentage}%)`,
      };
    },
  },
  mounted() {
    this.setupMediaSession();
  },
  methods: {
    playPrevious() {
      this.$emit("play-previous");
      const player = this.$refs.audioElement;
      if (player) {
        player.src = this.currentSong.file2;
        setTimeout(() => {
          this.setupMediaSession();
          player.play();
          this.isPlaying = true;
        }, 500);
      }
    },
    playNextSong() {
      this.$emit("play-next");
      const player = this.$refs.audioElement;
      if (player) {
        player.src = this.currentSong.file2;
        setTimeout(() => {
          this.setupMediaSession();
          player.play();
          this.isPlaying = true;
        }, 500);
      }
    },
    setupMediaSession() {
      if ("mediaSession" in navigator && this.currentSong) {
        const artistNames = this.currentSong.artists
          .map((artist) => artist.name)
          .join(", ");
        navigator.mediaSession.metadata = new MediaMetadata({
          title: this.currentSong.name,
          artist: artistNames,
          album: this.currentSong.album.name,
          artwork: [
            {
              src: this.currentSong.cover_file,
              sizes: "512x512",
              type: "image/png",
            },
          ],
        });
        navigator.mediaSession.setActionHandler("nexttrack", this.playNextSong);
        navigator.mediaSession.setActionHandler(
          "previoustrack",
          this.playPrevious,
        );
        navigator.mediaSession.setActionHandler("play", this.togglePlayback);
        navigator.mediaSession.setActionHandler("pause", this.togglePlayback);
      }
    },
    togglePlayback() {
      this.isPlaying = !this.isPlaying;
      if (this.isPlaying) {
        this.$refs.audioElement.play();
      } else {
        this.$refs.audioElement.pause();
      }
    },
    updateTime() {
      if (this.$refs.audioElement) {
        this.currentTime = this.$refs.audioElement.currentTime;
      }
    },
    seekToTime() {
      this.$refs.audioElement.currentTime = this.currentTime;
    },
    formatTime(time) {
      const minutes = Math.floor(time / 60);
      const seconds = Math.floor(time % 60);
      return `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    },
    updateDuration() {
      this.isPlaying = false;
      this.duration = this.$refs.audioElement.duration;
      this.togglePlayback();
    },
  },
};
</script>

<style scoped>
input {
  height: 4px;
  appearance: none;
  width: 100%;
  margin: 2px;
  border-radius: 8px;
  transition: 0.2s ease;
  background-color: rgb(181, 194, 196);
}

input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  /* display: none; */
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background-color: rgb(255, 255, 255);
  border: 1px solid rgb(224, 224, 224);
}
</style>
