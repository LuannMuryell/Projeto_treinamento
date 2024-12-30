<template>
    <v-app theme="dark">
        <v-navigation-drawer v-model="IsDrawerOpen">
            <!-- Conteúdo da sidebar -->
            <v-list>
                <v-list-subheader>Menu</v-list-subheader>
                <v-list-item prepend-icon="mdi-home">Home</v-list-item>
                <v-list-item prepend-icon="mdi-account">Pessoas</v-list-item>
                <v-list-item prepend-icon="mdi-office-building">Imóveis</v-list-item>
                <v-list-item prepend-icon="mdi-cog">Configurações</v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar flat class="border-b">
            <v-app-bar-nav-icon @click="IsDrawerOpen = !IsDrawerOpen"></v-app-bar-nav-icon>
            <v-app-bar-title></v-app-bar-title>

            <template #append>
                <v-avatar>
                    <v-img cover src="https://cdn-icons-png.flaticon.com/512/2706/2706962.png"></v-img>
                </v-avatar>
            </template>
        </v-app-bar>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';

const IsDrawerOpen = ref(false);
</script>
