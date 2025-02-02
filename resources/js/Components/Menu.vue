<template>
    <div>
        <v-navigation-drawer v-model="IsDrawerOpen">
            <!-- Conteúdo da sidebar -->
            <v-list>
                <v-list-item prepend-icon="mdi-home-city-outline" class="text-h5">
                    CadImob
                </v-list-item>
                <Link :href="route('home')">
                    <v-list-item prepend-icon="mdi-home" class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">Home</v-list-item>
                </Link>
                <Link :href="route('people.index')">
                    <v-list-item prepend-icon="mdi-folder-account-outline" class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">Pessoas</v-list-item>
                </Link>
                <Link :href="route('properties.index')">
                    <v-list-item prepend-icon="mdi-office-building" class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">Imóveis</v-list-item>
                </Link>
                <Link v-if="user.profile == 'T' || user.profile == 'S'" :href="route('users.index')">
                <v-list-item prepend-icon="mdi-account-box" class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">Usuários</v-list-item>
                </Link>
                <Link v-if="user.profile == 'T' || user.profile == 'S'" :href="route('audits.index')">
                <v-list-item prepend-icon="mdi-magnify" 
                class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">Auditoria</v-list-item>
                </Link>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar flat class="border-b" color="blue">
            <v-app-bar-nav-icon @click="IsDrawerOpen = !IsDrawerOpen"></v-app-bar-nav-icon>
            <v-app-bar-title></v-app-bar-title>

            <template #append>
                <v-menu>
                    <template #activator="{ props }">
                        <v-avatar v-bind="props" class="mx-2">
                            <v-btn icon="mdi-account-circle" variant="flat"></v-btn>
                        </v-avatar>
                    </template>
                    <!-- Conteúdo do Menu Dropdown -->
                    <v-card>
                        <v-list :lines="false" nav>
                            <Link :href="route('logout')" method="post"> 
                                <v-list-item prepend-icon="mdi-logout"
                                class="transition duration-200 ease-out hover:bg-gray-200 hover:text-gray-900">
                                    <v-list-item-title>Sair</v-list-item-title>
                                </v-list-item>
                            </Link>
                        </v-list>
                    </v-card>
                </v-menu>
            </template>
        </v-app-bar>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { defineProps, ref } from "vue"
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user

const IsDrawerOpen = ref(false)

</script>
