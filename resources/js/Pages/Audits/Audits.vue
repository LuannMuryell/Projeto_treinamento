<template>
    <Head title="Auditoria"/>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4" >
            <v-container class="mx-auto">
                <v-card class="mt-2 pa-8 border">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4" style="position: relative; top: -10px;">Auditoria</v-card-title>
                        <div class="d-flex gap-2">
                            <v-text-field
                                v-model="search"
                                density="compact"
                                label="Buscar"
                                variant="outlined"
                                disable-focus
                                prepend-icon="mdi-magnify"
                                class="me-2"
                                style="width: 250px; margin-top: 2px">
                            </v-text-field>
                        </div>
                    </div>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-center">ID</th>
                                <th class="py-2 px-4 text-center">Usuário</th>
                                <th class="py-2 px-4 text-center">Evento</th>
                                <th class="py-2 px-4 text-center">Data e Horário</th>
                                <th class="py-2 px-4 text-center">Tabela</th>
                                <th class="py-2 px-4 text-center">ID Auditado</th>
                                <th class="py-2 px-4 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="audit in filteredAudits" :key="audit.id">
                                <td class="py-2 px-4 text-center">{{ audit.id }}</td>
                                <td class="py-2 px-4 text-center">{{ audit.user ? audit.user.name : 'Desconhecido' }}</td>
                                <td class="py-2 px-4 text-center">{{ viewEvent(audit.event) }}</td>
                                <td class="py-2 px-4 text-center">{{ formatDateTime(audit.created_at) }}</td>
                                <td class="py-2 px-4 text-center">{{ viewTable(audit.auditable_type) }}</td>
                                <td class="py-2 px-4 text-center">{{ audit.auditable_id }}</td>
                                <td class="py-2 me-2 text-center">
                                    
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-information-outline" variant="tonal" class="me-2"
                                        @click="showAuditDetails(audit)">Detalhes</v-btn>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
                <v-pagination
                    v-model="currentPage"
                    :length="audits.last_page"
                    :total-visible="5"
                    @update:modelValue="fetchPage"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"/>
            </v-container>
        </v-main>
        <v-dialog v-model="dialog" max-width="600">
            <v-card>
                <v-card-title class="text-center text-h5 pa-4">
                    <v-icon left size="24" class="me-1" style="margin-top: -3px">mdi-information-outline</v-icon>
                    Detalhes da Auditoria</v-card-title>
                    <v-card-text>
                    <v-list lines="one" density="compact" readonly>
                        <v-list-item>
                            <v-list-item-title><strong>ID:</strong> {{ selectedAudit.id }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>Data e Horário:</strong> {{ formatDateTime(selectedAudit.created_at) }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>Usuário:</strong> {{ selectedAudit.user ? selectedAudit.user.name : 'Desconhecido' }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>Evento:</strong> {{ viewEvent(selectedAudit.event) }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>Tabela:</strong> {{ viewTable(selectedAudit.auditable_type) }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>ID Auditado:</strong> {{ selectedAudit.auditable_id }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                        <v-list-item-title><strong>Dados Anteriores:</strong></v-list-item-title>
                        <v-list-item-subtitle v-if="Object.keys(selectedAudit.old_values).length">
                            <v-list>
                                <v-list-item v-for="(value, key) in selectedAudit.old_values" :key="key">
                                    <strong>{{ key }}:</strong> {{ value }}
                                </v-list-item>
                            </v-list>
                        </v-list-item-subtitle>
                        <v-list-item-subtitle v-else>
                            Nenhuma informação anterior.
                        </v-list-item-subtitle>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-title><strong>Dados Novos:</strong></v-list-item-title>
                        <v-list-item-subtitle v-if="Object.keys(selectedAudit.new_values).length">
                            <v-list dense>
                                <v-list-item v-for="(value, key) in selectedAudit.new_values" :key="key">
                                    <strong>{{ key }}:</strong> {{ value }}
                                </v-list-item>
                            </v-list>
                        </v-list-item-subtitle>
                        <v-list-item-subtitle v-else>
                            Nenhuma alteração registrada.
                        </v-list-item-subtitle>
                    </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>URL:</strong> {{ selectedAudit.url }}</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title><strong>IP:</strong> {{ selectedAudit.ip_address }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                    <v-card-actions>
                        <v-btn 
                            rounded="xs" 
                            prepend-icon="mdi-close" 
                            color="light-gray" 
                            small 
                            class="text-light-gray-darken-2" 
                            variant="tonal"
                            @click="dialog = false">
                            Fechar
                        </v-btn>
                    </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link, router } from "@inertiajs/vue3"
import { defineProps, ref, computed } from "vue"

const props = defineProps ({
    audits: Object
})
console.log(props.audits)

// Dialog

const dialog = ref(false);
const selectedAudit = ref({});

const showAuditDetails = (audit) => {
    selectedAudit.value = audit;
    dialog.value = true;
};

const formatDateTime = (dateString) => {
    return new Date(dateString).toLocaleString();
};

// Formatação da exibição dos dados na tabela

const viewEvent = (event) => {
    if (event === 'updated'){
        return 'Alteração'
    }else if(event === 'created'){
        return 'Criação'
    }else if(event === 'deleted'){
        return 'Exclusão'
    }
}

const viewTable = (auditable_type) => {
    if (auditable_type === 'App\\Models\\File'){
        return 'Arquivos'
    }else if(auditable_type === 'App\\Models\\Property'){
        return 'Imóveis'
    }else if(auditable_type === 'App\\Models\\Person'){
        return 'Pessoas'
    }else if(auditable_type === 'App\\Models\\User'){
        return 'Usuários'
    }else{
        return 'Averbações'
    }
}

// Paginação

const currentPage = ref(props.audits.current_page);

const fetchPage = (page) => {
    router.get(route('audits.index', { page }));
};

// Filtro

const search = ref("");

const filteredAudits = computed(() => {
    return props.audits.data.filter((audit) => {
        const searchTerm = search.value.toLowerCase();
        return (
            audit.user.name.toLowerCase().includes(searchTerm) ||
            audit.event.toLowerCase().includes(searchTerm) ||
            viewEvent(audit.event).toLowerCase().includes(searchTerm) ||
            formatDateTime(audit.created_at).includes(searchTerm) ||
            viewTable(audit.auditable_type).toLowerCase().includes(searchTerm)
        )
    })
})
</script>