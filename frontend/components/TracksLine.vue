<template>
  <div class="shadow-sm overflow-hidden my-8">
    <table class="table-auto w-full text-sm">
      <thead>
        <tr>
          <th
            class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left"
          >
            # Название
          </th>
          <th
            class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left"
          >
            Альбом
          </th>
          <th
            class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left"
          >
            Дата добавления
          </th>
          <th
            class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left"
          >
            Длительность
          </th>
        </tr>
      </thead>
      <tbody v-if="tracks" class="bg-white dark:bg-slate-800">
        <tr
          v-for="(track, idx) in tracks.data"
          :key="idx"
          :class="{ bg_slate: active === idx }"
          class="hover:bg-slate-100 dark:hover:bg-slate-700"
          @click="playTrack(track.file2, idx)"
        >
          <td
            class="dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"
          >
            <div class="flex items-center gap-4 justify-start">
              <p>{{ idx + 1 }}</p>
              <img
                class="w-[40px] rounded"
                :src="track.cover_file"
                alt="img"
                loading="lazy"
              />
              <div class="flex flex-col justify-between">
                <p class="text-black">
                  {{ track.name }}
                </p>
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="(artist, index) in track.artists"
                    :key="index"
                    class="cursor-pointer"
                  >
                    {{ artist.name
                    }}<span
                      v-if="
                        track.artists.indexOf(artist) !==
                        track.artists.length - 1
                      "
                      >,</span
                    >
                  </span>
                </div>
              </div>
            </div>
          </td>
          <td
            class="dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"
          >
            {{ track.album.name }}
          </td>
          <td
            class="dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400"
          >
            {{ track.added_at }}
          </td>
          <td
            class="dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400"
          >
            {{ formatTrackDuration(track.duration) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <AudioPlayer
    v-if="audioActive"
    class="h-[80px] w-full flex items-center justify-center bg-white fixed bottom-8 left-0"
    :current-song-url="currentSongUrl"
    @play-next="playNext"
    @play-previous="playPrevious"
  />
</template>

<script>
import AudioPlayer from "@/components/AudioPlayer.vue";

export default {
  name: "TracksLine",
  components: {
    AudioPlayer,
  },
  data() {
    return {
      audioActive: false,
      currentSongUrl: "",
      active: null,
      audio: null,
      tracks: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    playPrevious() {
      const previousSound = this.tracks.data[this.active - 1];
      if (previousSound) {
        this.playTrack(previousSound.file2, this.active - 1);
      } else {
        this.playTrack(
          this.tracks.data[this.tracks.data.length - 1].file2,
          this.tracks.data.length - 1,
        );
      }
    },
    playNext() {
      const nextSound = this.tracks.data[this.active + 1];
      if (nextSound) {
        this.playTrack(nextSound.file2, this.active + 1);
      } else {
        this.playTrack(this.tracks.data[0].file2, 0);
      }
    },
    playTrack(track, idx) {
      this.audioActive = false;
      this.active = idx;
      this.audio = null;
      nextTick(() => {
        this.currentSongUrl = track;
        this.audioActive = true;
      });
    },
    formatTrackDuration(duration) {
      const minutes = Math.floor((duration % 3600) / 60);
      const seconds = Math.floor(duration % 60);
      if (seconds < 10) {
        return `${minutes}:0${seconds}`;
      }
      return `${minutes}:${seconds}`;
    },
    async fetchData() {
      const response = await $fetch("https://sukify.ru/api/tracks/search");
      this.tracks = await response;
    },
  },
};
</script>

<style lang="css">
.bg_slate {
  background-color: #f5f5f5;
}
</style>
