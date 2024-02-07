import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    accessToken: null,
    tokenType: null,
    expiresAt: null,
  }),
  actions: {
    setTokens(tokens) {
      this.accessToken = tokens.access_token;
      this.tokenType = tokens.token_type;
      this.expiresAt = new Date().getTime() + tokens.expires_in * 1000;
    },
    clearTokens() {
      this.accessToken = null;
      this.tokenType = null;
      this.expiresAt = null;
    },
    async login(credentials) {
      try {
        const response = await fetch("https://api.sukify.ru/api/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(credentials),
        });
        const data = await response.json();
        this.setTokens(data);
      } catch (error) {
        this.clearTokens();
        throw error;
      }
    },
    isTokenExpired() {
      return !this.expiresAt || new Date().getTime() > this.expiresAt;
    },
    // Метод для выхода
    logout() {
      this.clearTokens();
    },
  },
});
