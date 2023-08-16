<template>
  <div>
    <ul v-for="track in tracks">
      {{ track }}
      <p>
        {{ track.name }}
      </p>
      <img :src="track.cover_file" alt="img" loading="lazy">
    </ul>
  </div>
</template>

<script setup>
const { data: tracks} = await useFetch('https://4807-176-52-96-170.ngrok-free.app/api/tracks/search');
</script>

<style>

img {
  width: 200px;
  height: 200px;
  object-fit: cover;
}
</style>