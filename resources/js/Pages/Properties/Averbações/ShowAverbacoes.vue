<template>
    <Head title="Averbações"/>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4" >
            <v-container class="mx-auto">
                <v-card class="mt-2 pa-8 border">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-4 pa-2">Averbações</v-card-title>
                        <v-card-title>
                            <Link :href="route('averbacoes.create', property.ins_municipal)">
                                <v-btn rounded="xs" color="blue"
                                size="large" 
                                variant="tonal" class="me-2">Registrar Averbação</v-btn>
                            </Link>
                        </v-card-title>
                    </div>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-center">Descrição</th>
                                <th class="py-2 px-4 text-center">Evento</th>
                                <th class="py-2 px-4 text-center">Medida</th>
                                <th class="py-2 px-4 text-center">Data da Averbação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="averbacao in averbacoes" :key="averbacao.id">
                                <td class="py-2 px-4 text-center max-w-xs">{{ averbacao.descricao }}</td>
                                <td class="py-2 px-4 text-center">{{ averbacao.evento }}</td>
                                <td class="py-2 px-4 text-center">{{ averbacao.medida }}m²</td>
                                <td class="py-2 px-4 text-center">{{ formattedDate(averbacao.data_averbacao) }}</td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
                    <v-card-actions class="justify-end ga-2">
                        <Link :href="route('properties.edit', property.ins_municipal )">
                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" class="text-light-gray-darken-2" variant="tonal">Sair</v-btn>
                        </Link>
                    </v-card-actions>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import Menu from '../../../Components/Menu.vue'
import { Head, Link } from "@inertiajs/vue3"
import { defineProps } from "vue"

const props = defineProps ({
    averbacoes: Object,
    property: Object
})

const formattedDate = (date) => {
    const year = date.slice(0, 4);
    const month = date.slice(5, 7); 
    const day = date.slice(8, 10); 
    return day + "/" + month + "/" + year; 
};
</script>