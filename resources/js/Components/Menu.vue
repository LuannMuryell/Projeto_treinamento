<template>
    <div>
        <v-navigation-drawer v-model="IsDrawerOpen">
            <!-- Conteúdo da sidebar -->
            <v-list>
                <v-list-subheader class="text-h6"></v-list-subheader>
                <Link :href="route('home')">
                    <v-list-item prepend-icon="mdi-home">Home</v-list-item>
                </Link>
                <Link :href="route('people.index')">
                    <v-list-item prepend-icon="mdi-folder-account-outline">Pessoas</v-list-item>
                </Link>
                <Link :href="route('properties.index')">
                    <v-list-item prepend-icon="mdi-office-building">Imóveis</v-list-item>
                </Link>
                <v-list-item prepend-icon="mdi-account-box">Usuários</v-list-item>
                <v-list-item prepend-icon="mdi-cog">Configurações</v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar flat class="border-b">
            <v-app-bar-nav-icon @click="IsDrawerOpen = !IsDrawerOpen"></v-app-bar-nav-icon>
            <v-app-bar-title></v-app-bar-title>

            <template #append>
                <v-menu>
                    <template #activator="{ props }">
                        <v-avatar v-bind="props" class="mx-2">
                            <v-btn icon="mdi-account-circle" variant="tonal"></v-btn>
                        </v-avatar>
                    </template>
                    <!-- Conteúdo do Menu Dropdown -->
                    <v-card min-width="150px">
                        <v-list :lines="false" density="compact" nav>
                            <v-list-item prepend-icon="mdi-account">
                                <v-list-item-title>Perfil</v-list-item-title>
                            </v-list-item>
                            <v-list-item prepend-icon="mdi-logout">
                                <v-list-item-title>Sair</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-menu>
            </template>
        </v-app-bar>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: 'Menu',
    components: {
        Link,
    },
    data() {
        return {
            IsDrawerOpen: false,
        };
    },
};
</script>
