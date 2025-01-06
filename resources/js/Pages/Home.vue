<template>
    <v-app>
            <v-container>
                <h1>Home</h1>
                    <p>Seja bem-vindo ao Cadastro Imobiliário</p>
                    <p>Para se dirigir à página de registro de pessoas clique <Link :href="route('pessoas.index')" class="text-blue">aqui</Link></p>
            </v-container>
    </v-app>
</template>

<script>

import { Link } from "@inertiajs/vue3";

export default {
    name: 'Home',
    components:{
        Link
    }
}

</script>