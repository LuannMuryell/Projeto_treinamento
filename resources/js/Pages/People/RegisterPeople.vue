<template>
    <Head title="Cadastro" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto" max-width="1400px">
                    <v-card-title class="text-h4 my-4">
                        Cadastro de Pessoas
                    </v-card-title>
                    <v-card-text>
                        <form @submit.prevent="submit">
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
                            <v-row>
                                <v-col>
                                    <v-card-actions class="justify-end">
                                        <v-btn rounded="xs" color="blue" size="large" variant="tonal" type="submit">Cadastrar</v-btn>
                                    </v-card-actions>
                                </v-col>
                            </v-row>
                        </form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Menu from '../../Components/Menu.vue';
import { Head, useForm } from '@inertiajs/vue3';

export default {
    name: 'RegisterPeople',
    components: {
        Menu,
        Head
    },
    setup() {
        const form = useForm({
            name: '',
            cpf: '',
            birth_date: '',
            gender: '',
            phone: '',
            email: ''
        });

        const submit = () => {
            form.post(route('people.store'));
        };

        return {
            form,
            submit
        };
    }
};
</script>
