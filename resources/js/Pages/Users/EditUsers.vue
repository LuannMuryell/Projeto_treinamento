<template>
    <Head title="Edição" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto">
                    <v-card-title class="text-h4 my-4">
                        Edição
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
                                        v-model="form.password"
                                        label="Senha:*"
                                        variant="outlined"
                                        @change="form.validate('password')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('password')" class="text-sm text-red-500">
                                        {{ form.errors.password }}
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
                                        disabled
                                    ></v-text-field>
                                    <span v-if="form.invalid('cpf')" class="text-sm text-red-500">
                                        {{ form.errors.cpf }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.profile"
                                        label="Perfil:*"
                                        variant="outlined"
                                        :items="['T', 'S', 'A']"
                                        @change="form.validate('profile')"
                                    ></v-select>
                                    <span v-if="form.invalid('profile')" class="text-sm text-red-500">
                                        {{ form.errors.profile }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-select
                                        v-model="form.active"
                                        label="Atividade:"
                                        variant="outlined"
                                        :items="['Ativo', 'Inativo']"
                                        @change="form.validate('active')"
                                    ></v-select>
                                    <span v-if="form.invalid('active')" class="text-sm text-red-500">
                                        {{ form.errors.active }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.email"
                                        label="E-mail:"
                                        variant="outlined"
                                        @change="form.validate('email')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('email')" class="text-sm text-red-500">
                                        {{ form.errors.email }}
                                    </span>
                                </v-col>
                            </v-row>
                                <v-col>
                                    <v-card-actions class="justify-end ga-2">
                                        <Link :href="route('users.index')">
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
    import { Head, Link } from '@inertiajs/vue3'
    import { useForm } from 'laravel-precognition-vue-inertia'
    import { useToast } from "vue-toast-notification"
    import "vue-toast-notification/dist/theme-sugar.css"
    import { defineProps } from "vue";

    const props = defineProps({
        user: Object
    })

    const form = useForm("put", route('users.update', props.user.id),{
                name: props.user.name,
                cpf: props.user.cpf,
                email: props.user.email,
                profile: props.user.profile,
                active: props.user.active,
                password: props.user.password
            })

    const toast = useToast()

    const showSuccessToast = () => {
        toast.success('Usuário editado com sucesso!', {
        position: 'top-right',
        })
    }

    const showErrorToast = () => {
        toast.error('Não foi possível editar o usuário', {
        position: 'top-right',
        })
            }

    const submit = () => {
        form.submit({
            onSuccess: () => {
            showSuccessToast()
        },
            onError: () => {
            showErrorToast()
            }
        })
    }
</script>
