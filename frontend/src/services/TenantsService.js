import api from '@/apirest/api.js'

class TenantsService {
  static async getTenants() {
    const response = await api.get('/tenants')
    return response.data.data // array limpio
  }

  static async getTenant(id) {
    const response = await api.get(`/tenants/${id}`)
    return response.data.data // objeto tenant
  }

  static async createTenant(data) {
    const response = await api.post('/tenants', data)
    return response.data // trae {status, message, data}
  }

  static async updateTenant(id, data) {
    const response = await api.put(`/tenants/${id}`, data)
    return response.data // trae {status, message, data}
  }

  static async deleteTenant(id) {
    const response = await api.delete(`/tenants/${id}`)
    return response.data // trae {status, message}
  }
}

export default TenantsService
