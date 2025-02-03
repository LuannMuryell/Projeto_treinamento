<template>
    <Head title="Edição" />
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <v-card class="mx-auto">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-4">
                            Edição
                        </v-card-title>
                        <v-card-title>
                                <v-btn 
                                    rounded="xs" 
                                    color="blue"
                                    size="large"
                                    prepend-icon="mdi-file-download-outline"
                                    variant="tonal" 
                                    class="me-2"
                                    :href="route('analytical.report', props.property.ins_municipal)" 
                                    target="_blank">
                                    Relatório Detalhado
                                </v-btn>
                            <Link :href="route('averbacoes.index', props.property.ins_municipal )">
                                <v-btn 
                                    rounded="xs" 
                                    color="blue"
                                    size="large" 
                                    variant="tonal" 
                                    class="me-2">
                                    Visualizar Averbações
                                </v-btn>
                            </Link>
                        </v-card-title>
                    </div>
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row >
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
                            </v-row>
                            <v-row>
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
                                <v-col>
                                    <v-select
                                        v-model="form.situacao"
                                        label="Situação:"
                                        variant="outlined"
                                        :items="['Ativo', 'Inativo']"
                                        readonly
                                    ></v-select>
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
                                    <div v-if="formFiles.files && formFiles.files.length > 0">
                                        <h4 class="text-sm mt-4"><strong>Anexar novos arquivos:</strong></h4>
                                        <ul class="d-flex flex-column ga-1 mt-3">
                                            <li v-for="file in formFiles.files" :key="file.name">
                                                <span class="text-base text-sm">
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
                                    <div v-if="props.files && props.files.length > 0" class="mt-3">
                                    <h4 class="text-sm"><strong>Arquivos anexados</strong></h4>
                                    <ul class="d-flex flex-column ga-1 mt-2">
                                        <li v-for="(file, index) in props.files" :key="index" class="d-flex align-center">
                                            <span class="text-base text-sm">
                                                {{ file.file_name }}
                                            </span>
                                            <v-btn
                                                @click="removeFile(file)"
                                                color="white"
                                                icon="mdi-close-thick"
                                                class="text-red-lighten-1 ml-2"
                                                size="xs-small"
                                                elevation="0">
                                            </v-btn>
                                            <v-btn
                                                @click="downloadFile(file.file_path, file.file_name)"
                                                color="white"
                                                icon="mdi-download"
                                                class="text-blue-lighten-1 ml-2"
                                                size="xs-small"
                                                elevation="0">
                                            </v-btn>
                                        </li>
                                    </ul>
                                </div>
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
         <v-dialog v-model="isDialogOpen" max-width="500">
            <v-card>
                <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
                    <v-card-text>Tem certeza de que deseja excluir este arquivo?</v-card-text>
                    <v-card-actions>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="isDialogOpen = false">Cancelar</v-btn>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="deleteExistingFile">Excluir</v-btn>
                    </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>



<script setup>

import Menu from '../../Components/Menu.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"
import { defineProps, ref } from "vue"


const props = defineProps({
    property: Object,
    people: Object,
    files: Object,
    averbacao: Object
})

console.log(props.files)

const itemProps = (item) => {
return {
    title: item.name
    }
}

const form = useForm("put", route('properties.update', props.property.ins_municipal),{
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

const formFiles = useForm("post", route("files.upload", props.property.ins_municipal),
    {
        files: [],
    }
);

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
    toast.success('Registro editado com sucesso!', {
    position: 'top-right',
    })
}

const showErrorToast = () => {
    toast.error('Não foi possível editar o registro', {
    position: 'top-right',
    })
}

const showErrorFileToast = () => {
    toast.error('Não foi possível anexar o arquivo', {
    position: 'top-right',
    })
}

const showSuccessDeleteFileToast = () => {
    toast.success('Arquivo deletado com sucesso', {
    position: 'top-right',
    })
}

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            formFiles.submit({
                preserveScroll: true,
                onSuccess: () => {
                    showSuccessToast();
                    formFiles.files = [];
                },
                onError: () => {
                    showErrorFileToast();
                }
            });
        },
        onError: () => {
            showErrorToast();
        }
    });
};

// Arquivos

const fileInput = ref(null);
const maxFiles = 5; // Máximo de 5 arquivos
const sizeFile = 3 * 1024 * 1024; // Máximo de 3MB por arquivo
const errorMessages = ref([]); 

const onFileChange = (event) => {
    const newFiles = Array.from(event.target.files)

    errorMessages.value = []

    const totalFiles = props.files.length + formFiles.files.length + newFiles.length

    if (totalFiles > maxFiles) {
        errorMessages.value.push(`Você pode anexar no máximo 5 arquivos`)
        return
    }

    const validFiles = newFiles.filter(file => {
        if (file.size > sizeFile) {
            errorMessages.value.push(`O arquivo "${file.name}" não deve exceder 3MB`)
            return false
        }
        return true
    })

    if (errorMessages.value.length === 0) {
        formFiles.files = formFiles.files.concat(validFiles)
        formFiles.validate("files")
    }
}

const deleteFile = (index) => {
    formFiles.files.splice(index, 1)
    formFiles.validate("files")
}

// Deletando arquivos existentes

const selectedFileToRemove = ref(null);
const deleteForm = ref(null);
const isDialogOpen = ref(false);

const removeFile = (fileToRemove) => {
    selectedFileToRemove.value = fileToRemove;
    isDialogOpen.value = true;
    deleteForm.value = useForm("delete", route("files.destroy", fileToRemove.id), { id: fileToRemove.id,});
};

const deleteExistingFile = () => {
    deleteForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            isDialogOpen.value = false;
            showSuccessDeleteFileToast()
        },
        onError: () => {
            toast.error("Erro ao excluir arquivo!", {
                position: "top-right",
            });
        },
    });
};

const downloadFile = (filePath, fileName) => {
    const fullPath = `/storage/${filePath}`;

    // Criando um link temporário para forçar o download
    const link = document.createElement('a');
    link.href = fullPath;
    link.setAttribute('download', fileName); // Define o nome do arquivo no download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};
 
</script>
