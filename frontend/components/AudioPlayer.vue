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
          <button @click="$emit('shuffle')">
            <svg
              width="20"
              height="20"
              viewBox="0 0 59 50"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                :class="{
                  'fill-[#becdcf]': !shuffle,
                  'fill-[#78a0a5]': shuffle,
                }"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M47.2475 42.0835C47.3524 42.0835 47.4479 42.138 47.486 42.2378C47.5338 42.3286 47.5057 42.4375 47.4294 42.51C46.6373 43.2632 45.0527 44.7695 45.0527 44.7695C43.9648 45.8039 43.9648 47.4825 45.0527 48.517C46.1405 49.5514 47.8967 49.5514 48.9845 48.517C48.9845 48.517 56.208 41.6571 58.1261 39.8242C58.2501 39.7062 58.3169 39.5429 58.3169 39.3795C58.3169 39.2162 58.2501 39.0528 58.1261 38.9349C56.208 37.1019 48.9845 30.2419 48.9845 30.2419C47.8967 29.2075 46.1405 29.2075 45.0527 30.2419C43.9648 31.2763 43.9648 32.9551 45.0527 33.9895C45.0527 33.9895 46.7228 35.5774 47.5434 36.3578C47.6198 36.4304 47.6486 36.5393 47.6008 36.63C47.5627 36.7298 47.4673 36.7844 47.3623 36.7844C45.9118 36.7844 42.5149 36.7752 42.5149 36.7752C41.2362 36.7752 39.9569 36.1854 38.6114 35.3233C36.9032 34.2163 35.1762 32.6557 33.4203 30.8409C33.4203 30.8409 32.3899 29.7792 31.8555 29.2257C31.7696 29.1349 31.6551 29.0805 31.5215 29.0805C31.3974 29.0715 31.2734 29.1167 31.1875 29.1984C30.4145 29.8789 28.5631 31.4942 27.7902 32.1747C27.6947 32.2564 27.6373 32.3653 27.6373 32.4833C27.6278 32.6012 27.6759 32.7192 27.7618 32.8099C28.2962 33.3634 29.3267 34.4252 29.3267 34.4252C33.8022 39.0438 38.3637 42.0654 42.5052 42.0654C42.5052 42.0654 45.8256 42.0744 47.2475 42.0835ZM47.4294 7.57519C47.5057 7.64778 47.5338 7.74759 47.486 7.8474C47.4479 7.93814 47.3524 8.00159 47.2475 8.00159C45.8256 8.00159 42.5052 8.01063 42.5052 8.01063C39.5947 8.01063 36.4935 9.4172 33.4017 11.8853C29.5178 14.9886 25.4902 19.8251 21.4823 24.6797C17.7225 29.2167 13.9919 33.7808 10.3562 36.6844C8.43811 38.2179 6.63396 39.3251 4.83039 39.3251C4.83039 39.3251 1.85309 39.3251 0.679342 39.3251C0.412148 39.3251 0.202209 39.5246 0.202209 39.7696C0.202209 40.7768 0.202209 43.1633 0.202209 44.1614C0.202209 44.2885 0.250519 44.3973 0.336403 44.4881C0.431829 44.5697 0.545745 44.6151 0.679342 44.6151C1.47138 44.6151 2.98896 44.6151 2.98896 44.6151H4.83039C7.75045 44.6151 10.8429 43.2178 13.9347 40.7406C17.8185 37.6373 21.8455 32.8009 25.863 27.9463C29.6133 23.4093 33.3534 18.845 36.9891 15.9413C38.9072 14.4078 40.7017 13.3008 42.5052 13.3008H42.5149C42.5149 13.3008 45.9118 13.2918 47.3623 13.2918C47.4673 13.2918 47.5627 13.3552 47.6008 13.446C47.6486 13.5367 47.6198 13.6456 47.5434 13.7182C46.7228 14.5076 45.0527 16.0957 45.0527 16.0957C43.9648 17.1301 43.9648 18.7997 45.0527 19.8341C46.1405 20.8685 47.8967 20.8685 48.9845 19.8341C48.9845 19.8341 56.208 12.9741 58.1261 11.1412C58.2501 11.0232 58.3169 10.8691 58.3169 10.6967C58.3169 10.5333 58.2501 10.37 58.1261 10.252C56.208 8.42814 48.9845 1.55906 48.9845 1.55906C47.8967 0.533699 46.1405 0.533699 45.0527 1.55906C43.9648 2.59349 43.9648 4.27225 45.0527 5.30669C45.0527 5.30669 46.6373 6.81297 47.4294 7.57519ZM2.98896 10.7601H4.83039C6.43356 10.7601 8.03717 11.6493 9.72622 12.9106C11.8638 14.4985 14.0301 16.7127 16.2249 19.1809C16.2249 19.1809 17.1977 20.2788 17.713 20.8595C17.7893 20.9503 17.914 21.0047 18.038 21.0137C18.1621 21.0319 18.2855 20.9865 18.381 20.9139C19.1825 20.2697 21.1006 18.727 21.9117 18.0828C22.0072 18.0011 22.0647 17.8923 22.0743 17.7744C22.0838 17.6564 22.0455 17.5383 21.9691 17.4476C21.4538 16.8668 20.4714 15.7689 20.4714 15.7689C17.4845 12.4024 14.5069 9.48973 11.6251 7.684C9.32528 6.24124 7.03475 5.46088 4.83039 5.46088H0.202209V10.7601H2.98896Z"
              />
            </svg>
          </button>
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
          <div
            class="flex items-center gap-4 relative cursor-pointer w-full h-full"
          >
            <svg
              width="20"
              height="20"
              viewBox="0 0 58 55"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0.30078 24.0088C-0.0236701 26.1412 -0.0045848 28.3189 0.348493 30.4694C0.882882 33.7632 2.95379 36.6397 5.98835 38.3184C14.3 42.9189 33.9863 53.8168 33.9863 53.8168C34.8547 54.2887 35.9144 54.2887 36.7828 53.8168C37.6416 53.345 38.1762 52.4738 38.1762 51.5301V2.64857C38.1762 1.70487 37.6416 0.824625 36.7828 0.352777C35.9144 -0.11907 34.8547 -0.119106 33.9863 0.361816C33.9863 0.361816 14.3 11.2507 5.98835 15.8512C2.95379 17.5299 0.882882 20.4154 0.348493 23.7093L0.30078 24.0088ZM42.7566 7.40337C42.7566 7.30356 42.8043 7.20368 42.8998 7.14923C42.9856 7.08571 43.0996 7.0766 43.195 7.1129C51.7261 10.1255 57.7952 17.9381 57.7952 27.0847C57.7952 36.2404 51.7261 44.0441 43.195 47.0658C43.0996 47.102 42.9856 47.0839 42.8998 47.0294C42.8139 46.9659 42.7566 46.8751 42.7566 46.7753C42.7566 45.6682 42.7566 42.8282 42.7566 41.8392C42.7566 41.6305 42.8805 41.4308 43.0809 41.3401C48.5107 38.6814 52.2322 33.2913 52.2322 27.0847C52.2322 20.8781 48.5107 15.4972 43.0809 12.8386C42.8805 12.7387 42.7566 12.5482 42.7566 12.3304C42.7566 11.3414 42.7566 8.50133 42.7566 7.40337ZM5.84521 24.544V24.5259C6.12195 22.8109 7.21026 21.3047 8.78479 20.4336L32.6026 7.24901C32.6026 7.24901 32.6026 40.9135 32.6026 46.2218C32.6026 46.367 32.5268 46.5031 32.3932 46.5757C32.2596 46.6483 32.107 46.6483 31.9734 46.5757C25.5989 43.0459 14.5008 36.9119 8.78479 33.7451C7.21026 32.874 6.12195 31.3677 5.84521 29.6527C5.56847 27.9559 5.56847 26.2228 5.84521 24.5259V24.544ZM42.7566 17.6297C42.7566 17.5027 42.833 17.3846 42.9475 17.3302C43.0715 17.2757 43.2145 17.2848 43.3195 17.3665C46.3636 19.6169 48.3294 23.1375 48.3294 27.0847C48.3294 31.041 46.3636 34.5527 43.3195 36.8121C43.2145 36.8847 43.0715 36.8937 42.9475 36.8393C42.833 36.7848 42.7566 36.6669 42.7566 36.549C42.7566 33.5001 42.7566 20.6786 42.7566 17.6297ZM0.30078 23.9996L0.339547 23.7273C0.330004 23.8181 0.310323 23.9088 0.30078 23.9996L0.186716 24.6984L0.30078 24.0088V23.9996Z"
                fill="#becdcf"
              />
            </svg>
            <input
              v-model="volume"
              :style="volumeStyle"
              class="hidden xl:block absolute left-8 xl:min-w-[120px] xl:max-w-[120px] w-full"
              type="range"
              min="0"
              max="1"
              step="0.01"
              @input="setVolume"
            />
          </div>
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
    shuffle: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["play-next", "play-previous", "shuffle"],
  data() {
    return {
      volume: 1,
      isPlaying: false,
      currentTime: 0,
      duration: 0,
    };
  },
  computed: {
    volumeStyle() {
      return {
        background: `linear-gradient(to right, #78a0a5 ${
          this.volume * 100
        }%, rgb(181, 194, 196) ${this.volume * 100}%)`,
      };
    },
    sliderStyle() {
      const percentage = (this.currentTime / this.duration) * 100;
      return {
        background: `linear-gradient(to right, #78a0a5 ${percentage}%, rgb(181, 194, 196) ${percentage}%)`,
      };
    },
  },
  watch: {
    currentSong() {
      this.setupMediaSession();
    },
    volume(newValue) {
      this.setVolume(newValue);
    },
  },
  mounted() {
    this.setupMediaSession();
    // this.setVolume();
  },
  methods: {
    shuffleToggle() {
      this.$props.shuffle = !this.$props.shuffle;
    },
    setVolume() {
      if (this.$refs.audioElement) {
        const validVolume =
          !isNaN(parseFloat(this.volume)) && isFinite(this.volume)
            ? this.volume
            : 1;
        this.$refs.audioElement.volume = validVolume;
      }
    },
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
