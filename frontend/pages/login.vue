<template>
  <div>
    <div v-if="!isAuthenticated">
      <button @click="login({ email: 'test@test.com', password: 'qwerty123' })">
        Login
      </button>
    </div>
    <div v-else>
      <button @click="logout">Logout</button>
    </div>
  </div>
</template>

<script setup>
import { useAuth } from "@/composables/useAuth";

const { isAuthenticated, login, logout } = useAuth();
</script>
