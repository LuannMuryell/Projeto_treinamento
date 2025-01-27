<template>
    <Head title="Cadastro de Imóveis" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto">
                    <v-card-title class="text-h4 my-4">
                        Cadastro
                    </v-card-title>
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-col>
                                    <v-select
                                        v-model="form.tipo"
                                        label="Tipo:*"
                                        variant="outlined"
                                        :items="['Terreno', 'Casa', 'Apartamento']"
                                        @update:model-value="HandleTipoChange">
                                    </v-select>
                                    <span v-if="form.invalid('tipo')" class="text-sm text-red-500">
                                        {{ form.errors.tipo }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                            v-model="form.area_terreno"
                                            label="Área do Terreno: m²"
                                            variant="outlined"
                                            :disabled="!form.tipo || form.tipo === 'Apartamento'"
                                            @change="form.validate('area_terreno')"
                                        ></v-text-field>
                                        <span v-if="form.invalid('area_terreno')" class="text-sm text-red-500">
                                        {{ form.errors.area_terreno }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.area_edificacao"
                                        label="Área da Edificação: m²"
                                        variant="outlined"
                                        :disabled="!form.tipo || form.tipo === 'Terreno'"
                                        @change="form.validate('area_edificacao')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('area_edificacao')" class="text-sm text-red-500">
                                        {{ form.errors.area_edificacao }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.logradouro"
                                        label="Logradouro:*"
                                        variant="outlined"
                                        @change="form.validate('logradouro')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('logradouro')" class="text-sm text-red-500">
                                        {{ form.errors.logradouro }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.numero"
                                        label="Número:*"
                                        variant="outlined"
                                        @change="form.validate('numero')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('numero')" class="text-sm text-red-500">
                                        {{ form.errors.numero }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.bairro"
                                        label="Bairro:*"
                                        variant="outlined"
                                        @change="form.validate('bairro')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('bairro')" class="text-sm text-red-500">
                                        {{ form.errors.bairro }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.complemento"
                                        label="Complemento:"
                                        variant="outlined"
                                        @change="form.validate('complemento')"
                                    ></v-text-field>
                                    <span v-if="form.invalid('complemento')" class="text-sm text-red-500">
                                        {{ form.errors.complemento }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.contribuinte_id"
                                        label="Selecione o Contribuinte:*"
                                        variant="outlined"
                                        :item-props="itemProps"
                                        :items="props.people"
                                        item-value="id"
                                        item-text="name"
                                        @change="form.validate('contribuinte_id')"
                                    ></v-select>
                                    <span v-if="form.invalid('contribuinte_id')" class="text-sm text-red-500">
                                        {{ form.errors.contribuinte_id }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col>
                                    <v-btn
                                        rounded="xs"
                                        size="large"
                                        color="blue"
                                        prepend-icon="mdi-attachment-plus"
                                        variant="tonal"
                                        @click="fileInput.click()"
                                    >
                                        Anexar documentos
                                    </v-btn>
                                    <input
                                        ref="fileInput"
                                        type="file"
                                        accept=".jpg, .jpeg, .png, .pdf"
                                        multiple
                                        class="hidden"
                                        @change="onFileChange"
                                    />
                                    <div v-if="errorMessages.length > 0"
                                        class="ml-1 mt-2 text-base text-sm text-red-500">
                                        <ul>
                                            <li v-for="(message, index) in errorMessages" :key="index">{{ message }}</li>
                                        </ul>
                                    </div>
                                    <div v-if="form.files && form.files.length > 0">
                                        <ul class="d-flex flex-column ga-1 mt-3">
                                            <li v-for="file in form.files" :key="file.name">
                                                <span class="text-base">
                                                    {{ file.name }}
                                                </span>
                                                <v-btn
                                                    @click="deleteFile"
                                                    color="white"
                                                    icon="mdi-close-thick"
                                                    class="text-red-lighten-1 ml-2"
                                                    size="xs-small"
                                                    elevation="0">
                                                </v-btn>
                                            </li>
                                        </ul>
                                    </div>
                                </v-col>
                                <v-col>
                                    <v-card-actions class="justify-end ga-2">
                                        <Link :href="route ('properties.index')">
                                            <v-btn rounded="xs" prepend-icon="mdi-arrow-left" color="light-gray" size="large" variant="tonal">Sair</v-btn>
                                        </Link>
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

<script setup>

import Menu from '../../Components/Menu.vue'
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"

const props = defineProps({
    properties: Object, 
    people: Object,  
})

const itemProps = (item) => {
    return {
        title: item.name
    }
}

const form = useForm("post", route("properties.store"),{
            tipo: '',
            area_terreno: '',
            area_edificacao: '',
            logradouro: '',
            numero: '',
            bairro: '',
            complemento: '',
            contribuinte_id: null,
            files: []
        })

function HandleTipoChange() {
    if (form.tipo === "Terreno") {
        form.area_edificacao = 0;
        form.area_terreno = '';
    }else if(form.tipo === "Apartamento"){
        form.area_terreno = 0; 
        form.area_edificacao = '';
    }else if (form.tipo === "Casa"){
        form.area_terreno = ''; 
        form.area_edificacao = '';
    }
}

const toast = useToast()

const showSuccessToast = () => {
    toast.success('Registro realizado com sucesso!', {
    position: 'top-right',
    })
}

const showErrorToast = () => {
    toast.error('Não foi possível realizar o registro', {
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
        showErrorToast()
        }
    })
}

// Arquivos

const fileInput = ref(null);
const maxFiles = 5; // Máximo de 5 arquivos
const sizeFile = 3 * 1024 * 1024; // Máximo de 3MB por arquivo
const errorMessages = ref([]); 

const onFileChange = (event) => {
    const newFiles = Array.from(event.target.files);

    errorMessages.value = [];

    if (form.files.length + newFiles.length > maxFiles) {
        errorMessages.value.push(`Você pode anexar no máximo 5 arquivos`);
        return;
    }

    const validFiles = newFiles.filter(file => {
        if (file.size > sizeFile) {
            errorMessages.value.push(`O arquivo "${file.name}" não deve exceder 3MB`);
            return false;
        }
        return true;
    });

    if (errorMessages.value.length === 0) {
        form.files = form.files.concat(validFiles);
        form.validate("files");
    }
};

// Para remover baseado no índice dentro do array de arquivos
const deleteFile = (index) => {
    form.files.splice(index, 1);
    form.validate("files");
};

</script>
