<script setup>
import { Head, Link } from '@inertiajs/vue3';
import WelcomeLayout from '@/Layouts/WelcomeLayout.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <WelcomeLayout>
        <Head title="Bem-vindo(a)" />
            <div class="w-full">
                <div class="flex flex-col items-center justify-center bg-white rounded px-4 py-4">
                    <h1 class="text-h4 text-blue">Seja bem-vindo(a) ao</h1>
                    <h1 class="text-h4 text-blue"><strong>Cadastro Imobiliário</strong></h1>
                        <p class="mt-4 text-black text-justify">Este sistema permite registrar imóveis de São Leopoldo e gerenciar as informações dos respectivos proprietários de maneira <strong>simples</strong>, <strong>organizada</strong> e <strong>eficiente</strong>.</p> 
                        <p class="mt-4 text-base text-black">Para acesso, entre em contato com o administrador e solicite suas credenciais de login.</p>
                    <div class="mt-4 flex items-center justify-center">
                        <Link :href="route('login')" 
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-400 focus:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-blue-500"
                        >Acessar login
                        </Link>
                    </div>
                </div>
            </div>
    </WelcomeLayout>
</template>
