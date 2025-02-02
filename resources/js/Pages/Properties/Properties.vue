<template>
    <Head title="Imóveis"/>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4" >
            <v-container class="mx-auto">
                <v-card class="mt-2 pa-8 border">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4" style="position: relative; top: -10px;">Imóveis</v-card-title>
                        <div class="d-flex gap-2">
                            <v-text-field
                                v-model="search"
                                density="compact"
                                label="Buscar"
                                variant="outlined"
                                disable-focus
                                prepend-inner-icon="mdi-magnify"
                                class="me-2"
                                style="width: 250px; margin-top: 2px;">
                            </v-text-field>
                            <Link :href="route('synthetic.report')">
                                <v-btn prepend-icon="mdi-file-download-outline" rounded="xs" color="blue"
                                    size="large" variant="tonal" class="me-2">
                                    Emitir Relatório
                                </v-btn>
                            </Link>
                            <Link :href="route('properties.create')">
                                <v-btn rounded="xs" color="blue" size="large" variant="tonal">
                                    Novo Cadastro
                                </v-btn>
                            </Link>
                        </div>
                    </div>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-center">Inscrição Municipal</th>
                                <th class="py-2 px-4 text-center">Tipo</th>
                                <th class="py-2 px-4 text-center">Logradouro</th>
                                <th class="py-2 px-4 text-center">Número</th>
                                <th class="py-2 px-4 text-center">Bairro</th>
                                <th class="py-2 px-4 text-center">Contribuinte</th>
                                <th class="py-2 px-4 text-center">Situação</th>
                                <th class="py-2 px-4 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="property in filteredProperties" :key="property.ins_municipal">
                                <td class="py-2 px-4 text-center">{{ property.ins_municipal }}</td>
                                <td class="py-2 px-4 text-center">{{ property.tipo }}</td>
                                <td class="py-2 px-4 text-center">{{ property.logradouro }}</td>
                                <td class="py-2 px-4 text-center">{{ property.numero }}</td>
                                <td class="py-2 px-4 text-center">{{ property.bairro }}</td>
                                <td class="py-2 px-4 text-center">{{ property.contribuinte.name }}</td>
                                <td class="py-2 px-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <v-icon v-if="property.situacao == 'Ativo'" color="green" size="x-small" class="me-1">mdi-circle</v-icon>
                                        <v-icon v-else color="red" size="x-small" class="me-1">mdi-circle</v-icon> 
                                        <span>{{ property.situacao }}</span>
                                    </div>
                                </td>
                                <td class="py-2 me-2 text-center">
                                    <Link :href="route('properties.edit', property.ins_municipal)">
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-pencil" variant="tonal" class="me-2">Visualizar</v-btn>
                                    </Link>
                                    <v-btn
                                        type="submit"
                                        rounded="xs" small color="blue" prepend-icon="mdi-delete" variant="tonal"
                                        @click="confirmDelete(property)"
                                    >Excluir</v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
                <v-pagination
                    v-model="currentPage"
                    :length="properties.last_page"
                    :total-visible="5"
                    @update:modelValue="fetchPage"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"/>
            </v-container>
        </v-main>
        <v-dialog v-model="isDialogOpen" max-width="500">
            <v-card>
                <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
                    <v-card-text>Tem certeza de que deseja excluir este registro?</v-card-text>
                    <v-card-actions>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="isDialogOpen = false">Cancelar</v-btn>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="deleteProperty">Excluir</v-btn>
                    </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link, useForm, router } from "@inertiajs/vue3"
import { useToast } from "vue-toast-notification"
import { defineProps, ref, computed } from "vue"

const props = defineProps ({
    properties: Object
})

const toast = useToast()
const isDialogOpen = ref(false)
const deleteForm = useForm({})
const selectedProperty = ref(null)

const confirmDelete = (Property) => {
    selectedProperty.value = Property
    isDialogOpen.value = true
}

const showSuccessToast = () => {
    toast.success('Registro excluído com sucesso!', {
        position: 'top-right',
    })
}

const showErrorToast = () => {
        toast.error('Não foi possível excluir o registro.', {
            position: 'top-right',
    })
}

const deleteProperty = () => {
    deleteForm.delete(route('properties.destroy', selectedProperty.value.ins_municipal), {
        onSuccess: () => {
            isDialogOpen.value = false;
            showSuccessToast()
        },
        onError: () => {
            showErrorToast()
        }
    })
}

// Paginação

const currentPage = ref(props.properties.current_page);

const fetchPage = (page) => {
    router.get(route('properties.index', { page }));
};

const search = ref("");

const filteredProperties = computed(() => {
  return props.properties.data.filter((property) => {
    const searchTerm = search.value.toLowerCase();
    return (
        String(property.ins_municipal).includes(searchTerm) ||
        property.tipo.toLowerCase().includes(searchTerm) || 
        property.logradouro.toLowerCase().includes(searchTerm) ||
        String(property.numero).includes(searchTerm) ||
        property.bairro.toLowerCase().includes(searchTerm) ||
        property.contribuinte.name.toLowerCase().includes(searchTerm) ||
        property.situacao.toLowerCase().includes(searchTerm) 
    )
  })
})
</script>