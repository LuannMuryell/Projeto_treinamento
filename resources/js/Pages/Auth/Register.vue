<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia'
import { useToast } from "vue-toast-notification"
import "vue-toast-notification/dist/theme-sugar.css"

const form = useForm("post", route('users.store'),{
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    cpf: '',
    profile: ''
});

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
        form.reset();
        showSuccessToast()
        },
        onError: () => {
            showErrorToast()
        }
    });
};

const toast = useToast()

const showSuccessToast = () => {
    toast.success('Usuário registrado com sucesso!', {
    position: 'top-right',
    })
}

const showErrorToast = () => {
    toast.error('Não foi possível registrar o usuário', {
    position: 'top-right',
    })
        }

</script>

<template>
    <GuestLayout>
        <Head title="Registro" />
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autocomplete="name"
                    @change="form.validate('name')"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="username"
                    @change="form.validate('email')"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    autocomplete="new-password"
                    @change="form.validate('password')"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar senha"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    @change="form.validate('password_confirmation')"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4">
                <InputLabel for="cpf" value="CPF" />

                <TextInput
                    id="cpf"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cpf"
                    autocomplete="cpf"
                    v-mask="'###.###.###-##'"
                    @change="form.validate('cpf')"
                />

                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div class="mt-4">
                <InputLabel for="profile" value="Perfil" />

                <select
                    id="profile"
                    class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                    v-model="form.profile"
                    @change="form.validate('profile')"
                >
                    <option disabled value="">Selecione um perfil</option>
                    <option value="T">Administrador da TI</option>
                    <option value="S">Administrador do Sistema</option>
                    <option value="A">Atendente</option>
                    
                </select>
                <InputError class="mt-2" :message="form.errors.profile" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('users.index')"
                    class="rounded-md text-sm text-gray-600 underline"
                >
                    Voltar
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
