<template>
    <Head title="Pessoas"/>
    <v-app>
        <Menu />
            <v-main class="bg-grey-lighten-4 mt-8">
                <v-container class="mx-auto" max-width="1400px">
                    <v-card class="mt-8 pa-8 border">
                        <div class="d-flex align-center justify-space-between">
                            <v-card-title  class="text-h5 my-4 pa-2">Pessoas</v-card-title>
                            <v-card-title class="pa-2">
                                <Link :href="route ('people.create')">
                                    <v-btn rounded="xs" color="light-blue-lighten-5" size="large" class="text-light-blue-darken-2" variant="tonal">Cadastrar</v-btn>
                                </Link>
                            </v-card-title>
                        </div>
                        <v-data-table>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Data Nasc.</th>
                                    <th>Sexo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="person in people" :key="person.id">
                                    <td>{{ person.id }}</td>
                                    <td>{{ person.name }}</td>
                                    <td>{{ person.cpf }}</td>
                                    <td>{{ person.birth_date }}</td>
                                    <td>{{ person.gender }}</td>
                                    <td class="d-flex align-center ga-2">
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-pencil" variant="tonal">Visualizar</v-btn>
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-delete" variant="tonal">Excluir</v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </v-data-table>
                    </v-card>
                </v-container>
            </v-main>
    </v-app>
</template>

<script>
import Menu from '../../Components/Menu.vue'
import { Head, Link } from "@inertiajs/vue3";

export default {
    name: 'People',
    components: {
        Menu,
        Link,
        Head
    },
    props:{
        people: Array
    }
}
</script>