<script setup>
import TenantsService from '@/services/TenantsService';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';

// ====== VARIABLES ======
const toast = useToast();
const dt = ref();
const empresas = ref([]);
const empresaForm = ref(false);
const empresa = ref({});
const selectedEmpresa = ref({});
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});
const submitted = ref(false);

// ====== INICIO, MOSTRAR EMPRESAS ======
onMounted(async () => {
    empresas.value = await TenantsService.getTenants();
});

// ====== FUNCIONES ======
function formularioEmpresa() {
    empresa.value = {};
    submitted.value = false;
    empresaForm.value = true;
}

function ocultarFormularioEmpresa() {
    empresaForm.value = false;
    submitted.value = false;
}

async function guardarEmpresa() {
    submitted.value = true;

    try {
        if (empresa?.value?.ruc?.trim()) {
            if (empresa.value.id) {
                await EmpresasService.updateEmpresas(empresa.value.id, empresa.value);
                toast.add({ severity: 'success', summary: 'Éxito', detail: 'Empresa actualizada', life: 3000 });
            } else {
                await EmpresasService.createEmpresas(empresa.value);
                toast.add({ severity: 'success', summary: 'Éxito', detail: 'Empresa creada', life: 3000 });
            }

            empresas.value = await EmpresasService.getEmpresas();
            empresaForm.value = false;
            empresa.value = {};
        }
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'No se pudo guardar la empresa', life: 3000 });
        console.error(error);
    }
}

function editarEmpresa(empr) {
    empresa.value = { ...empr };
    empresaForm.value = true;
}

function eliminarEmpresa(id) {
    const temp = id;
    toast.add({ severity: 'error', summary: 'Error', detail: 'Esta seguro de eliminar?', life: 3000 });
    console.error(temp);
}

function exportCSV() {
    dt.value.exportCSV();
}
</script>

<template>
    <div>
        <div class="card">
            <Toolbar class="mb-6">
                <template #start>
                    <Button label="Nueva Empresa" icon="pi pi-plus" severity="secondary" class="mr-2" @click="formularioEmpresa" />
                    <Button label="Eliminar" icon="pi pi-trash" severity="secondary" @click="exportCSV($event)" disabled />
                </template>

                <template #end>
                    <Button label="Exportar" icon="pi pi-upload" severity="secondary" @click="exportCSV($event)" />
                </template>
            </Toolbar>

            <DataTable
                ref="dt"
                v-model:selection="selectedEmpresa"
                :value="empresas"
                dataKey="id"
                :paginator="true"
                :rows="10"
                :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Mostrando {first} al {last} de {totalRecords} empresas"
            >
                <template #header>
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <h4 class="m-0">Lista de Empresas</h4>
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Buscar..." />
                        </IconField>
                    </div>
                </template>
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="id" header="ID" sortable style="min-width: 12rem"></Column>
                <Column field="ruc" header="RUC" sortable style="min-width: 16rem"></Column>
                <Column field="razon_social" header="Razon Social" sortable style="min-width: 16rem"></Column>
                <Column :exportable="false" style="min-width: 12rem">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editarEmpresa(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="eliminarEmpresa(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="empresaForm" :style="{ width: '450px' }" header="Empresa a Registrar" :modal="true">
            <div class="flex flex-col gap-6">
                <div>
                    <label for="ruc" class="block font-bold mb-3">RUC</label>
                    <InputText id="ruc" v-model.trim="empresa.ruc" required="true" autofocus :invalid="submitted && !empresa.ruc" fluid />
                    <small v-if="submitted && !empresa.ruc" class="text-red-500">Ruc es requerido.</small>
                </div>
                <div>
                    <label for="razon_social" class="block font-bold mb-3">RAZON SOCIAL</label>
                    <Textarea id="razon_social" v-model="empresa.razon_social" required="true" rows="3" cols="20" fluid />
                </div>
            </div>

            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="ocultarFormularioEmpresa" />
                <Button label="Guardar" icon="pi pi-check" @click="guardarEmpresa" />
            </template>
        </Dialog>
    </div>
</template>