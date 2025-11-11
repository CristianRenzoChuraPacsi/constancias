<script setup>
import { ref, computed } from 'vue'
import AppMenuItem from './AppMenuItem.vue';
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const model = computed(() => [
  {
    label: 'Home',
    items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
  },
  {
    label: 'Pages',
    icon: 'pi pi-fw pi-briefcase',
    items: [
      auth.hasPermission('tenants.view') && {
        label: 'Empresas',
        icon: 'pi pi-fw pi-building',
        to: '/pages/empresas'
      },
      auth.hasPermission('conductores.view') && {
        label: 'Conductores',
        icon: 'pi pi-fw pi-id-card',
        to: '/pages/conductores'
      },
      auth.hasPermission('vehiculos.view') && {
        label: 'Vehículos',
        icon: 'pi pi-fw pi-car',
        to: '/pages/vehiculos'
      },
      auth.hasPermission('users.view') && {
        label: 'Usuarios',
        icon: 'pi pi-fw pi-user',
        to: '/pages/usuarios'
      },
      auth.hasPermission('users.view') && {
        label: 'Crud',
        icon: 'pi pi-fw pi-book',
        to: '/pages/crud'
      }
    ].filter(Boolean)
  }
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
