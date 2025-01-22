<template>
    <Head title="Imóveis"/>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4" >
            <v-container class="mx-auto" max-width="1400px">
                <v-card class="mt-2 pa-8 border">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-4 pa-2">Imóveis</v-card-title>
                        <v-card-title>
                            <Link :href="route('properties.create')">
                                <v-btn rounded="xs" color="blue"
                                size="large" 
                                variant="tonal" class="me-2">Novo Cadastro</v-btn>
                            </Link>
                        </v-card-title>
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
                                <th class="py-2 px-4 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="property in properties" :key="property.ins_municipal">
                                <td class="py-2 px-4 text-center">{{ property.ins_municipal }}</td>
                                <td class="py-2 px-4 text-center">{{ property.tipo }}</td>
                                <td class="py-2 px-4 text-center">{{ property.logradouro }}</td>
                                <td class="py-2 px-4 text-center">{{ property.numero }}</td>
                                <td class="py-2 px-4 text-center">{{ property.bairro }}</td>
                                <td class="py-2 px-4 text-center">{{ property.contribuinte.name }}</td>
                                <td class="py-2 me-2 text-center">
                                    <Link :href="route('properties.edit', property.ins_municipal)">
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-pencil" variant="tonal" class="me-2">Visualizar</v-btn>
                                    </Link>
                                    <v-btn
                                        type="submit"
                                        rounded="xs" small color="red" prepend-icon="mdi-delete" variant="tonal"
                                        @click="confirmDelete(property)"
                                    >Excluir</v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
            </v-container>
        </v-main>
        <v-dialog v-model="isDialogOpen" max-width="500">
            <v-card>
                <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
                    <v-card-text>Tem certeza de que deseja excluir este registro?</v-card-text>
                    <v-card-actions>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="isDialogOpen = false">Cancelar</v-btn>
                        <v-btn rounded="xs" small color="red" variant="tonal" text @click="deleteProperty">Excluir</v-btn>
                    </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link, useForm } from "@inertiajs/vue3"
import { useToast } from "vue-toast-notification"
import { defineProps, ref } from "vue"

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

</script>