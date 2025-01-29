<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useToast } from "vue-toast-notification"

const passwordInput = ref(null);

const user = usePage().props.user;



const form = useForm({
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update', { id: user.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset(),
            showSuccessToast()
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
                showErrorToast()
            }
        },
    });
};

const toast = useToast()

const showSuccessToast = () => {
    toast.success('Senha atualizada com sucesso!', {
        position: 'top-right',
    })
}

const showErrorToast = () => {
        toast.error('Não foi possível atualizar a senha.', {
            position: 'top-right',
    })
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Atualizar senha
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Certifique-se de que se sua conta está utilizando uma senha forte e segura
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
        
            <div>
                <InputLabel for="password" value="Nova senha" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar senha"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                </Transition>
            </div>
        </form>
    </section>
</template>
