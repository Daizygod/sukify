import { computed } from "vue";
import { useAuthStore } from "@/stores/auth";

export function useAuth() {
  const authStore = useAuthStore();

  // Вычисляемое свойство для проверки, авторизован ли пользователь
  const isAuthenticated = computed(
    () => !!authStore.accessToken && !authStore.isTokenExpired(),
  );

  // Метод для выполнения входа
  const login = async (credentials) => {
    await authStore.login(credentials);
  };

  // Метод для выполнения выхода
  const logout = () => {
    authStore.logout();
  };

  return {
    isAuthenticated,
    login,
    logout,
    // При необходимости можно добавить и другие вычисляемые свойства,
    // методы или осуществить доступ к состоянию из authStore
  };
}
