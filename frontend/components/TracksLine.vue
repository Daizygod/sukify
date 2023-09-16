<template>
  <div class="shadow-sm overflow-hidden my-8">
    <table class="border-collapse table-auto w-full text-sm">
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
          @click="playTrack(track.file, idx)"
        >
          <td
            class="flex items-center gap-4 border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"
          >
            {{ idx + 1 }}
            <!-- {{ track }} -->
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
                      track.artists.indexOf(artist) !== track.artists.length - 1
                    "
                    >,</span
                  >
                </span>
              </div>
            </div>
          </td>
          <td
            class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400"
          >
            {{ track.album.name }}
          </td>
          <td
            class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400"
          >
            {{ track.added_at }}
          </td>
          <td
            class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400"
          >
            {{ formatTrackDuration(track.duration) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <AudioPlayer
    v-if="audio_active"
    class="h-[80px] w-full flex items-center justify-center bg-white fixed bottom-0 left-0"
    :current-song-url="currentSongUrl"
  />
</template>

<script setup>
const currentSongUrl = ref();
const active = ref();
const audio = ref();
const audioActive = ref(false);
const { data: tracks } = await useFetch(
  "https://d3f0-176-52-96-170.ngrok-free.app/api/tracks/search",
);

const playTrack = (track, idx) => {
  audioActive.value = false;
  active.value = idx;
  audio.value = null;
  nextTick(() => {
    currentSongUrl.value = track;
    audioActive.value = true;
  });
};

const formatTrackDuration = (duration) => {
  const minutes = Math.floor((duration % 3600) / 60);
  const seconds = Math.floor(duration % 60);
  if (seconds < 10) {
    return `${minutes}:0${seconds}`;
  }
  return `${minutes}:${seconds}`;
};

// const unixTime = (time) => {
//   return new Date(time * 1000).toLocaleString("ru-RU", {
//     year: "numeric",
//     month: "long",
//     day: "numeric",
//     // hour: 'numeric',
//     // minute: 'numeric',
//     // second: 'numeric',
//   });
// };
</script>

<style lang="css">
.bg_slate {
  background-color: #f5f5f5;
}
</style>
