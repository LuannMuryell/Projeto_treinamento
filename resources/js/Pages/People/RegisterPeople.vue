<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto" max-width="1400px">
                    <v-card-title class="text-h4 my-4">
                        Cadastro
                    </v-card-title>
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome:*"
                                        variant="outlined"
                                        @change="form.validate('name')"
                                    >
                                    </v-text-field>
                                    <span v-if="form.invalid('name')" class="text-sm text-red-500">
                                        {{ form.errors.name }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.birth_date"
                                        label="Data de Nascimento:*"
                                        variant="outlined"
                                        type="date"
                                        @change="form.validate('birth_date')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('birth_date')" class="text-sm text-red-500">
                                        {{ form.errors.birth_date }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.cpf"
                                        label="CPF:*"
                                        v-mask="'###.###.###-##'"
                                        variant="outlined"
                                        @change="form.validate('cpf')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('cpf')" class="text-sm text-red-500">
                                        {{ form.errors.cpf }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.gender"
                                        label="Sexo:*"
                                        variant="outlined"
                                        :items="['Masculino', 'Feminino', 'Outro']"
                                        @change="form.validate('gender')"
                                    ></v-select>
                                    <span v-if="form.invalid('gender')" class="text-sm text-red-500">
                                        {{ form.errors.gender }}
                                    </span>
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
import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"

const form = useForm("post", route("people.store"), {
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

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showSuccessToast()
    },
        onError: () => {
            showErrorToast()
            }
    })
}
</script>