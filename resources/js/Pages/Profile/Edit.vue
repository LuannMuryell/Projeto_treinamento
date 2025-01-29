<template>
    <v-app>
        <Head title="Perfil"/>
        <Menu />
        <div class="py-12 mt-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="flex flex-wrap gap-6">
                    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 flex-1">
                        <UpdateProfileInformationForm
                            class="max-w-xl"
                        />
                        <!-- :must-verify-email="mustVerifyEmail"
                             :status="status" -->
                    </div>
                    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 flex-1">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <Link :href="route('users.index')">
                         <v-btn 
                            rounded="xs" 
                            prepend-icon="mdi-arrow-left" 
                            color="light-gray" 
                            small 
                            class="text-light-gray-darken-2" 
                            variant="tonal"
                            >Sair
                        </v-btn>
                    </Link>
                </div>
            </div>
        </div>
    </v-app>
</template>

<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link} from "@inertiajs/vue3"
import DeleteUserForm from '../Profile/Partials/DeleteUserForm.vue';
import UpdatePasswordForm from '../Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '../Profile/Partials/UpdateProfileInformationForm.vue';
</script>