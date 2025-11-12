<script setup>
import { useLayout } from '@/layouts/composables/layout';
import AppConfigurator from './AppConfigurator.vue';

import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

import logoCepreIni from '@/assets/images/logo-cepreuna-inicio.png'

const auth = useAuthStore()
const router = useRouter()

const { toggleMenu, toggleDarkMode, isDarkTheme } = useLayout();

async function handleLogout() {
  try {
    await auth.logout() // limpiamos store + backend
    router.push({ name: 'Login' }) // volver al login
  } catch (error) {
    console.error('Error cerrando sesión', error)
  }
}

</script>

<template>
    <div class="layout-topbar">
        <div class="layout-topbar-logo-container pl-4">
            <button class="layout-menu-button layout-topbar-action" @click="toggleMenu">
                <i class="pi pi-bars"></i>
            </button>
            <router-link to="/" class="layout-topbar-logo">
                <img
                    :src="logoCepreIni"
                    alt="Logo CEPRE UNA"
                    class="mt-0 w-16 h-auto mx-auto"
                />
            </router-link>
        </div>

        <div class="layout-topbar-actions">
            <div class="layout-config-menu">
                <button type="button" class="layout-topbar-action" @click="toggleDarkMode">
                    <i :class="['pi', { 'pi-moon': isDarkTheme, 'pi-sun': !isDarkTheme }]"></i>
                </button>
                <div class="relative">
                    <button
                        v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }"
                        type="button"
                        class="layout-topbar-action layout-topbar-action-highlight"
                    >
                        <i class="pi pi-palette"></i>
                    </button>
                    <AppConfigurator />
                </div>
            </div>

            <button
                class="layout-topbar-menu-button layout-topbar-action"
                v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }"
            >
                <i class="pi pi-ellipsis-v"></i>
            </button>

            <div class="layout-topbar-menu hidden lg:block">
                <div class="layout-topbar-menu-content">
                    <button type="button" class="layout-topbar-action">
                        <i class="pi pi-calendar"></i>
                        <span>Calendar</span>
                    </button>
                    <button type="button" class="layout-topbar-action">
                        <i class="pi pi-inbox"></i>
                        <span>Messages</span>
                    </button>
                    <button type="button" class="layout-topbar-action" @click="handleLogout">
                        <i class="pi pi-sign-out"></i>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
