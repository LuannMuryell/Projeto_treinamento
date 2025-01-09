<template>
    <Head title="Cadastro" />
    <v-app>
        <Menu />
    </v-app>
    
</template>

<script>
import Menu from '../../Components/Menu.vue'
import { Head, Link } from "@inertiajs/vue3";

export default {
    name: 'RegisterPeople',
    components: {
        Menu,
        Link,
        Head
    }
}

</script>