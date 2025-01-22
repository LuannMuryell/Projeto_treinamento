<template>
    <Head title="Edição" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto" max-width="1400px">
                    <v-card-title class="text-h4 my-4">
                        Edição
                    </v-card-title>
                    <v-card-text>
                        <form @submit.prevent="updatePeople()">
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome:"
                                        variant="outlined"
                                    ></v-text-field>
                                    <span class="text-sm text-red-500">
                                        {{ form.errors.name }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.birth_date"
                                        label="Data de Nascimento:*"
                                        variant="outlined"
                                        type="date"
                                    ></v-text-field>
                                    <span class="text-sm text-red-500">
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
                                        disabled
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.gender"
                                        label="Sexo:"
                                        variant="outlined"
                                        :items="['Masculino', 'Feminino', 'Outro']"
                                    ></v-select>
                                    <span class="text-sm text-red-500">
                                        {{ form.errors.birth_date }}
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
                                        <Link :href="route('people.index')">
                                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" class="text-light-gray-darken-2" variant="tonal">Sair</v-btn>
                                        </Link>
                                            <v-btn rounded="xs" color="blue" size="large" variant="tonal" type="submit">Salvar</v-btn>
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
    import { defineProps } from "vue";

    const props = defineProps({
        person: Object
    })

    const form = useForm({
                name: props.person.name,
                cpf: props.person.cpf,
                birth_date: props.person.birth_date,
                gender: props.person.gender,
                phone: props.person.phone,
                email: props.person.email
            })

    const toast = useToast()

    const showSuccessToast = () => {
        toast.success('Cadastro editado com sucesso!', {
        position: 'top-right',
        })
    }

    const showErrorToast = () => {
        toast.error('Não foi possível editar o cadastro', {
        position: 'top-right',
        })
            }

    const updatePeople = () => {
        form.put(route('people.update', props.person.id), {
            onSuccess: () => {
            showSuccessToast()
        },
            onError: () => {
            showErrorToast()
            }
        })
    }
</script>
