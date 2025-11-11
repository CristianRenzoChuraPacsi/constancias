<script setup>
import VehiculosService from '@/services/VehiculosService';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';

const toast = useToast();
const dt = ref();
const vehiculos = ref([]);
const vehiculoForm = ref(false);
const vehiculo = ref({});
const selectedVehiculo = ref({});
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});
const submitted = ref(false);

async function listarVehiculos() {
  try {
    vehiculos.value = await VehiculosService.getVehiculos();
  } catch (error) {
    console.error(error);
    toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudieron obtener los vehiculos', life: 3000 });
  }
}

function formularioConductor() {
  vehiculo.value = {};
  submitted.value = false;
  vehiculoForm.value = true;
}

function ocultarFormularioVehiculo() {
  vehiculoForm.value = false;
  submitted.value = false;
}

async function guardarVehiculo() {
  submitted.value = true;
  try {
    if (vehiculo?.value?.placa?.trim()) {
      if (vehiculo.value.id) {
        await VehiculosService.updateVehiculo(vehiculo.value.id, vehiculo.value);
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Vehículo actualizado', life: 3000 });
      } else {
        await VehiculosService.createVehiculo(vehiculo.value);
        toast.add({ severity: 'success', summary: 'Éxito', detail: 'Vehículo creado', life: 3000 });
      }
      await listarVehiculos(); // refrescar tabla con la función global
      vehiculoForm.value = false;
      vehiculo.value = {};
    }
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo realizar la operacion', life: 3000 });
    console.error(error);
  }
}

function editarVehiculo(vehi) {
  vehiculo.value = { ...vehi };
  vehiculoForm.value = true;
}

function exportCSV() {
    dt.value.exportCSV();
}

onMounted(() => {
  listarVehiculos();
});

</script>

<template>
  <div>
    <div class="card">
      <Toolbar class="mb-6">
        <template #start>
          <Button label="Nuevo Vehículo" icon="pi pi-car" class="mr-2" @click="formularioConductor" />
        </template>
        <template #end>
          <Button label="Exportar" icon="pi pi-upload" @click="exportCSV($event)" />
        </template>
      </Toolbar>

      <DataTable
        ref="dt"
        v-model:selection="selectedVehiculo"
        :value="vehiculos"
        dataKey="id"
        :paginator="true"
        :rows="10"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Mostrando {first} al {last} de {totalRecords} vehículos"
      >
        <template #header>
          <div class="flex flex-wrap gap-2 items-center justify-between">
            <h4>Lista de Vehículos</h4>
            <IconField>
              <InputIcon>
                <i class="pi pi-search" />
              </InputIcon>
              <InputText v-model="filters['global'].value" placeholder="Buscar..." />
            </IconField>
          </div>
        </template>

        <Column selectionMode="multiple" style="width: 3rem"></Column>
        <Column field="id" header="ID" sortable></Column>
        <Column field="placa" header="PLACA" sortable></Column>
        <Column field="modelo" header="MODELO VEHÍ." sortable></Column>
        <Column field="capacidad" header="CAPACIDAD" sortable></Column>
        <Column header="Acciones">
          <template #body="slotProps">
            <Button icon="pi pi-pencil" outlined rounded class="mr-1" severity="success" @click="editarVehiculo(slotProps.data)" />
          </template>
        </Column>
      </DataTable>
    </div>

    <Dialog v-model:visible="vehiculoForm" :style="{ width: '450px' }" header="Vehículo" :modal="true">
      <div class="flex flex-col gap-6">
        <div>
          <label for="placa" class="block font-bold mb-3">PLACA</label>
          <InputText id="placa" v-model.trim="vehiculo.placa" required="true" autofocus :invalid="submitted && !vehiculo.placa" fluid />
          <small v-if="submitted && !vehiculo.placa" class="text-red-500">PLACA requerida.</small>
        </div>
        <div>
          <label for="modelo" class="block font-bold mb-3">MODELO VEHÍCULO</label>
          <InputText id="modelo" v-model="vehiculo.modelo" required="true" fluid />
        </div>
        <div>
          <label for="capacidad" class="block font-bold mb-3">CAPACIDAD</label>
          <InputNumber id="capacidad" v-model="vehiculo.capacidad" required="true" :min="0" showButtons fluid />
        </div>
      </div>

      <template #footer>
        <Button label="Cancelar" icon="pi pi-times" text @click="ocultarFormularioVehiculo" />
        <Button label="Guardar" icon="pi pi-check" @click="guardarVehiculo" />
      </template>
    </Dialog>

  </div>
</template>
