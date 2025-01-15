<template>
    <Head title="Cadastro" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto" max-width="1400px">
                    <v-card-title class="text-h4 my-4">
                        Cadastro
                    </v-card-title>
                    <v-card-text>
                        <form @submit.prevent="savePeople()">
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome:"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.birth_date"
                                        label="Data de Nascimento:"
                                        variant="outlined"
                                        type="date"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.cpf"
                                        label="CPF:"
                                        v-mask="'###.###.###-##'"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.gender"
                                        label="Sexo:"
                                        variant="outlined"
                                        :items="['Masculino', 'Feminino', 'Outro']"
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.phone"
                                        label="Telefone:"
                                        v-mask="'(##) #####-####'"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.email"
                                        label="E-mail:"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                                <v-col>
                                    <v-card-actions class="justify-end ga-2">
                                        <Link :href="route ('people.index')">
                                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" class="text-light-gray-darken-2" variant="tonal">Sair</v-btn>
                                        </Link>
                                            <v-btn rounded="xs" color="blue" size="large" variant="tonal" type="submit">Cadastrar</v-btn>
                                    </v-card-actions>
                                </v-col>
                        </form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>

import Menu from '../../Components/Menu.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"

const form = useForm({
            name: '',
            cpf: '',
            birth_date: '',
            gender: '',
            phone: '',
            email: ''
        })

const toast = useToast()

const showSuccessToast = () => {
    toast.success('Cadastro realizado com sucesso!', {
    position: 'top-right',
    })
}

const showErrorToast = () => {
    toast.error('Não foi possível realizar o cadastro', {
    position: 'top-right',
    })
        }

const savePeople = () => {
    form.post(route('people.store'), {
        onSuccess: () => {
        form.reset()
        showSuccessToast()
    },
        onError: () => {
        showErrorToast()
        }
    })
}
</script>
