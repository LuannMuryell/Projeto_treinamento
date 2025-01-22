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
                        <form @submit.prevent="updateProperties()">
                            <v-row>
                                <v-col>
                                    <v-select
                                        v-model="form.tipo"
                                        label="Tipo:*"
                                        variant="outlined"
                                        :items="['Terreno', 'Casa', 'Apartamento']"
                                    >
                                    </v-select>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.area_terreno"
                                        label="Área do Terreno:"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.area_edificacao"
                                        label="Área da Edificação:"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.logradouro"
                                        label="Logradouro:*"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.numero"
                                        label="Número:*"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.bairro"
                                        label="Bairro:*"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.complemento"
                                        label="Complemento:"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.contribuinte_id"
                                        label="Contribuinte:*"
                                        variant="outlined"
                                        :item-props="itemProps"
                                        :items="props.people"
                                        item-value="id"
                                        item-text="name"
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-select
                                        v-model="form.situacao"
                                        label="Situação:"
                                        variant="outlined"
                                        :items="['Ativo', 'Inativo']"
                                    ></v-select>
                                </v-col>
                                <v-col>
                                    <v-card-actions class="justify-end ga-2">
                                        <Link :href="route('properties.index')">
                                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" class="text-light-gray-darken-2" variant="tonal">Sair</v-btn>
                                        </Link>
                                            <v-btn rounded="xs" color="blue" size="large" variant="tonal" type="submit">Salvar</v-btn>
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

    import Menu from '../../Components/Menu.vue'
    import { Head, Link, useForm } from '@inertiajs/vue3'
    import { useToast } from "vue-toast-notification"
    import "vue-toast-notification/dist/theme-sugar.css"
    import { defineProps } from "vue";

    const props = defineProps({
        property: Object,
        people: Object
    })

    const itemProps = (item) => {
    return {
        title: item.name
    }
}

    const form = useForm({
                tipo: props.property.tipo,
                area_terreno: props.property.area_terreno,
                area_edificacao: props.property.area_edificacao,
                logradouro: props.property.logradouro,
                numero: props.property.numero,
                bairro: props.property.bairro,
                complemento: props.property.complemento,
                contribuinte_id: props.property.contribuinte_id,
                situacao: props.property.situacao
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

    const updateProperties = () => {
        form.put(route('properties.update', props.property.ins_municipal), {
            onSuccess: () => {
            showSuccessToast()
        },
            onError: () => {
            showErrorToast()
            }
        })
    }
</script>
