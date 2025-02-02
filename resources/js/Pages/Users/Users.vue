<template>
    <Head title="Usuários"/>
        <v-app>
            <Menu />
            <v-main class="bg-grey-lighten-4" >
                <v-container class="mx-auto">
                    <v-card class="mt-2 pa-8 border">
                        <div class="d-flex align-center justify-space-between">
                            <v-card-title class="text-h4">Usuários</v-card-title>
                            <v-card-title>
                            <Link :href="route('users.create')">
                                <v-btn rounded="xs" color="blue"
                                size="large" 
                                variant="tonal" class="me-2">Registrar Usuário</v-btn>
                            </Link>
                        </v-card-title>
                        </div>
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 text-center">ID</th>
                                    <th class="py-2 px-4 text-center">Nome</th>
                                    <th class="py-2 px-4 text-center">E-mail</th>
                                    <th class="py-2 px-4 text-center">Perfil</th>
                                    <th class="py-2 px-4 text-center">Atividade</th>
                                    <th class="py-2 px-4 text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="py-2 px-4 text-center">{{ user.id }}</td>
                                    <td class="py-2 px-4 text-center">{{ user.name }}</td>
                                    <td class="py-2 px-4 text-center">{{ user.email }}</td>
                                    <td class="py-2 px-4 text-center">{{ viewProfileName(user.profile) }}</td>
                                    <td class="py-2 px-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <v-icon v-if="user.active == 'S'" color="green" size="x-small" class="me-1">mdi-circle</v-icon>
                                            <v-icon v-else color="red" size="x-small" class="me-1">mdi-circle</v-icon>
                                            <span>{{ viewProfileStatus(user.active) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 me-2 text-center">
                                    <Link :href="route('profile.edit', user.id)">
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-pencil" variant="tonal" class="me-2">Visualizar</v-btn>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
                <v-pagination
                    v-model="currentPage"
                    :length="users.last_page"
                    :total-visible="5"
                    @update:modelValue="fetchPage"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"/>
            </v-container>
        </v-main>
      </v-app>
</template>
    
<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link, router } from "@inertiajs/vue3"
import { defineProps, ref } from "vue"
    
const props = defineProps ({
        users: Object,
})
    
const viewProfileName = (profile) => {
    if (profile === 'T'){
        return 'Administrador da TI'
    }else if(profile === 'S'){
        return 'Administrador do Sistema'
    }else{
        return 'Atendente'
    }
}

const viewProfileStatus = (active) => {
    if (active === 'S'){
        return 'Ativo'
    }else{
        return 'Inativo'
    }
}

// Paginação

const currentPage = ref(props.users.current_page);

const fetchPage = (page) => {
    router.get(route('users.index', { page }));
};
</script>
    