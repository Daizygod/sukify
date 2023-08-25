<template>
    <div class="shadow-sm overflow-hidden my-8">
        <table class="border-collapse table-auto w-full text-sm">
            <thead>
                <tr>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        # Название</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Альбом</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Дата добавления</th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pr-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Длительность</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
                <tr :class="{ bg_slate : active === idx }" @click="playTrack(track.file, idx)" class="hover:bg-slate-100 dark:hover:bg-slate-700" v-if="tracks" v-for="(track, idx) in tracks.data">
                    <td
                        class="flex items-center gap-4 border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                        {{ idx + 1 }}
                        <img class="w-[40px] rounded" :src="track.cover_file" alt="img" loading="lazy">
                        <div class="flex flex-col justify-between">
                            <p class="text-black">
                                {{ track.name }}
                            </p>
                            <div class="flex flex-wrap gap-1">
                                <span class="cursor-pointer" v-for="artist in track.artists">
                                    {{ artist.name }}<span
                                        v-if="track.artists.indexOf(artist) !== track.artists.length - 1">,</span>
                                </span>
                            </div>
                        </div>

                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        {{ track.album.name }}
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">
                        {{ unixTime(track.added_at) }}</td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">
                        {{ formatTrackDuration(track.duration) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <audio v-if="audio" controls>
        <source :src="audio" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>
</template>
<script setup>

const active = ref();
const audio = ref();
const { data: tracks, error, pending } = await useFetch('https://d3f0-176-52-96-170.ngrok-free.app/api/tracks/search');

const playTrack = (track , idx) => {
    active.value = idx;
    audio.value = null;
    nextTick(() => {
        audio.value = track;
    })
}

const formatTrackDuration = (duration) => {
    const minutes = Math.floor((duration % 3600) / 60);
    const seconds = Math.floor(duration % 60);
    if (seconds < 10) {
        return `${minutes}:0${seconds}`;
    }
    return `${minutes}:${seconds}`;
}

const unixTime = (time) => {
    return new Date(time * 1000).toLocaleString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        // hour: 'numeric',
        // minute: 'numeric',
        // second: 'numeric',
    })
}
</script>
<style lang="css">
    .bg_slate {
        background-color: #f5f5f5;
    }
</style>