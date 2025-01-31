<template>
    <v-app>
        <Head title='Averbações'/>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto">
                    <div class="d-flex align-center">
                        <v-card-title class="text-h4 my-4">
                            Averbações
                        </v-card-title>
                    </div>
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row >
                                <v-col>
                                    <v-select
                                        v-model="form.evento"
                                        label="Eventos:*"
                                        variant="outlined"
                                        :items="['Aumento de Área Construída','Redução de Área Construída','Observação', 'Cancelamento','Reativação']"
                                        @change="form.validate('evento')">
                                    </v-select>
                                    <span v-if="form.invalid('evento')" class="text-sm text-red-500">
                                        {{ form.errors.evento }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                            v-model="form.medida"
                                            label="Medida:* m²"
                                            variant="outlined"
                                            :disabled="!['Aumento de Área Construída', 'Redução de Área Construída'].includes(form.evento)"
                                            @change="form.validate('medida')"
                                        ></v-text-field>
                                        <span v-if="form.invalid('medida')" class="text-sm text-red-500">
                                        {{ form.errors.medida }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-textarea
                                        v-model="form.descricao"
                                        label="Descrição:*"
                                        variant="outlined"
                                        row-height="30"
                                        rows="4"
                                        counter
                                        @change="form.validate('descricao')">
                                    </v-textarea>
                                    <span v-if="form.invalid('descricao')" class="text-sm text-red-500">
                                        {{ form.errors.descricao }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col>
                                    <v-card-actions class="justify-end ga-2">
                                        <Link :href="route('properties.edit', property.ins_municipal )">
                                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" class="text-light-gray-darken-2" variant="tonal">Sair</v-btn>
                                        </Link>
                                            <v-btn rounded="xs" color="blue" size="large" variant="tonal" type="submit">Registrar</v-btn>
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

<script setup>
import Menu from '../../../Components/Menu.vue'
import { Head, Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"

const props = defineProps({
    property: Object
})

const form = useForm("post", route("averbacoes.store"), {
            evento: '',
            descricao: '',
            data_averbacao: '',
            medida: '',
            property_id: props.property.ins_municipal
        })

const toast = useToast()

const showSuccessToast = () => {
    toast.success('Averbação registrada com sucesso!', {
    position: 'top-right',
    })
}

const showErrorToast = () => {
    toast.error('Não foi possível registrar a averbação', {
    position: 'top-right',
    })
        }

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
        form.reset()
        showSuccessToast()
    },
        onError: () => {
            console.error("Erro ao enviar:", form.errors)
        showErrorToast()
        }
    })
}
</script>