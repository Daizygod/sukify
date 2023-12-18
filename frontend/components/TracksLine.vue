<template>
  <div
    class="h-[calc(100vh-170px)] pb-[50px] overflow-y-auto shadow-sm overflow-hidden my-8"
  >
    <table class="table-auto w-full text-sm">
      <thead>
        <tr>
          <th
            class="hidden xl:table-cell border-b font-medium pt-0 pb-3 text-slate-400 text-right"
          >
            #
          </th>
          <th
            class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 text-left"
          >
            Название
          </th>
          <th
            class="hidden xl:table-cell border-b font-medium p-4 pt-0 pb-3 text-slate-400 text-left"
          >
            Альбом
          </th>
          <th
            class="hidden xl:table-cell border-b font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 text-left"
          >
            Дата добавления
          </th>
          <th
            class="border-b font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 text-left"
          >
            Длительность
          </th>
        </tr>
      </thead>
      <tbody v-if="tracks" class="bg-white">
        <tr
          v-for="(track, idx) in tracks.data"
          :key="idx"
          :class="{ bg_slate: active === idx }"
          class="hover:bg-slate-100"
          @click="playTrack(idx)"
        >
          <td class="hidden xl:table-cell text-slate-500">
            <p class="text-right">{{ idx + 1 }}</p>
          </td>
          <td class="p-4 pl-8 text-slate-500">
            <div class="flex items-center gap-4 justify-start">
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
          <td class="hidden xl:table-cell p-4 text-slate-500">
            {{ track.album.name }}
          </td>
          <td class="hidden xl:table-cell p-4 pr-8 text-slate-500">
            {{ track.added_at }}
          </td>
          <td class="text-right xl:text-left p-4 pr-8 text-slate-500">
            {{ formatTrackDuration(track.duration) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <AudioPlayer
    v-if="audioActive"
    class="h-[80px] w-full flex items-center justify-center bg-white fixed bottom-8 left-0"
    :current-song="currentSong"
    :shuffle="shuffle"
    @shuffle="shuffleToggle"
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
      currentSong: null,
      active: null,
      audio: null,
      tracks: [],
      shuffle: false,
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    shuffleToggle() {
      this.shuffle = !this.shuffle;
    },
    playPrevious() {
      const previousSound = this.tracks.data[this.active - 1];
      if (previousSound) {
        this.playTrack(this.active - 1);
      } else {
        this.playTrack(this.tracks.data.length - 1);
      }
    },
    playNext() {
      const nextSound = this.tracks.data[this.active + 1];
      // KOCTblJlb shuffle
      if (this.shuffle) {
        const randomIndex = Math.floor(Math.random() * this.tracks.data.length);
        const randomNumber = this.tracks.data[randomIndex];
        if (randomNumber.id !== this.active) {
          this.playTrack(randomNumber.id);
        } else {
          this.playNext();
        }
      } else if (nextSound) {
        this.playTrack(this.active + 1);
      } else {
        this.playTrack(0);
      }
    },
    playTrack(idx) {
      this.audioActive = false;
      this.active = idx;
      this.audio = null;
      this.currentSong = this.tracks.data[idx];
      this.audioActive = true;
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
