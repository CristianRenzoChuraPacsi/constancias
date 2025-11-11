import api from '@/apirest/api.js'

class VehiculosService {
  static async getVehiculos() {
    const response = await api.get('/vehiculos')
    return response.data.data
  }

  static async createVehiculo(data) {
    const response = await api.post('/vehiculos', data)
    return response.data.data
  }

  static async updateVehiculo(id, data) {
    const response = await api.put(`/vehiculos/editar/${id}`, data)
    return response.data.data
  }
}

export default VehiculosService