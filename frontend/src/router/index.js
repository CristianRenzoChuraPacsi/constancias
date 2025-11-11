import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '@/layouts/AppLayout.vue';
import { useAuthStore } from '@/stores/auth'

import Dashboard from '@/pages/Dashboard.vue'
import Empresas from '@/pages/Empresas.vue'
import Crud from '@/pages/Crud.vue'  // eliminar solo era ejemplo
import Conductores from '@/pages/Conductores.vue'
import Vehiculos from '@/pages/Vehiculos.vue'
import Login from '@/pages/auth/Login.vue'
import Users from '@/pages/Users.vue'

const routes = [
  { 
    path: '/login', name: 'Login', component: Login 
  },
  {
    path: '/',
    component: AppLayout,
    meta: { requiresAuth: true }, // protege todo el layout
    children: [
      { path: '', name: 'Dashboard', component: Dashboard },
      { path: '/pages/empresas', name: 'Empresas', component: Empresas, meta: { permission: 'tenants.view' } },
      { path: '/pages/conductores', name: 'Conductores', component: Conductores, meta: { permission: 'conductores.view' } },
      { path: '/pages/vehiculos', name: 'Vehiculos', component: Vehiculos, meta: { permission: 'vehiculos.view' } },
      { path: '/pages/usuarios', name: 'Users', component: Users, meta: { permission: 'users.view' } }, // o el permiso que uses
      { path: '/pages/crud', name: 'Crud', component: Crud, meta: { permission: 'users.view' } } // o el permiso que uses
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Protege rutas
router.beforeEach(async (to) => {
  const auth = useAuthStore()
  if (to.meta.requiresAuth && !(await auth.validateToken())) {
    return { name: 'Login' }
  }

  // Valida permisos
  if (to.meta.permission && !auth.hasPermission(to.meta.permission)) {
    return { name: 'Dashboard' } // Redirige si no tiene permiso
  }
})

export default router