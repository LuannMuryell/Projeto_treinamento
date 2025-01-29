<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toast-notification"

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.user;

const form = useForm({
    name: user.name,
    email: user.email,
    cpf: user.cpf,
    profile: user.profile,
    active: user.active
});

const updateProfile = () => {
    form.patch(route('profile.update', { id: user.id }), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccessToast();
        },
        onError: () => {
            showErrorToast();
        }
    })
}


const toast = useToast()

const showSuccessToast = () => {
    toast.success('Perfil atualizado com sucesso!', {
        position: 'top-right',
    })
}

const showErrorToast = () => {
        toast.error('Não foi possível atualizar o perfil.', {
            position: 'top-right',
    })
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações do Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Atualize as informações do seu perfil
            </p>
        </header>

        <form
            @submit.prevent="updateProfile"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="profile" value="Perfil" />

                <select
                    id="profile"
                    class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                    v-model="form.profile"
                >
                    <option disabled value="">Selecione um perfil</option>
                    <option value="T">Administrador da TI</option>
                    <option value="S">Administrador do Sistema</option>
                    <option value="A">Atendente</option>
                    
                </select>
                <InputError class="mt-2" :message="form.errors.profile" />
            </div>

            <div>
                <InputLabel for="email" value="Email" class="opacity-60" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full opacity-60 cursor-not-allowed border-gray-300"
                    v-model="form.email"
                    disabled
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="cpf" value="CPF" class="opacity-60" />

                <TextInput
                    id="cpf"
                    type="text"
                    class="mt-1 block w-full opacity-60 cursor-not-allowed border-gray-300"
                    v-model="form.cpf"
                    disabled
                    autofocus
                    autocomplete="cpf"
                />

                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="mt-4">
                    <InputLabel for="active" value="Atividade" />

                    <p class="mt-2 mb-2 text-sm text-gray-800">
                    Atenção: uma vez que essa conta for desativada, todos os seus dados permanecerão intactos, mas 
                    não poderá mais ser utilizada até que seja ativada novamente.
                    </p>

                    <select
                        id="active"
                        class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                        v-model="form.active"
                    >
                        <option value="S">Ativo</option>
                        <option value="N">Inativo</option>
                        
                    </select>
                </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                </Transition>
            </div>
        </form>
    </section>
</template>
