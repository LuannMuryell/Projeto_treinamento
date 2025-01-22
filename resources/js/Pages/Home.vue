<template>
    <div>
        <Head title="Home" />
        <v-app>
            <v-container>
                <h1>Home</h1>
                <p>Seja bem-vindo ao Cadastro Imobiliário</p>
                <p>
                    Para se dirigir à página de registro de pessoas clique 
                    <Link :href="route('people.index')" class="text-blue">aqui</Link>
                </p>
                <p>
                    Para ir até a página de registro de imóveis clique
                    <Link :href="route('properties.index')" class="text-blue">aqui</Link>
                </p>
            </v-container>
        </v-app>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";

export default {
    name: 'Home',
    components: {
        Link,
        Head,
    },
};
</script>
