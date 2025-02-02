<template>
    <Head title="Pessoas"/>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4" >
            <v-container class="mx-auto">
                <v-card class="mt-2 pa-8 border">
                    <div class="d-flex align-center justify-space-between">
                            <v-card-title class="text-h4" style="position: relative; top: -10px;">Pessoas</v-card-title>
                            <div class="d-flex gap-2">
                            <v-text-field
                            v-model="search"
                            density="compact"
                            label="Buscar"
                            variant="outlined"
                            disable-focus
                            prepend-icon="mdi-magnify"
                            class="me-2"
                            style="width: 250px; margin-top: 2px">
                        </v-text-field>
                                <Link :href="route('people.create')">
                                    <v-btn rounded="xs" color="blue"
                                    size="large" 
                                    variant="tonal" class="me-2">Novo Cadastro</v-btn>
                                </Link>
                        </div>
                    </div>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-center">ID</th>
                                <th class="py-2 px-4 text-center">Nome</th>
                                <th class="py-2 px-4 text-center">CPF</th>
                                <th class="py-2 px-4 text-center">Data Nasc.</th>
                                <th class="py-2 px-4 text-center">Sexo</th>
                                <th class="py-2 px-4 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="person in filteredPeople" :key="person.id">
                                <td class="py-2 px-4 text-center">{{ person.id }}</td>
                                <td class="py-2 px-4 text-center">{{ person.name }}</td>
                                <td class="py-2 px-4 text-center">{{ formattedCpf(person.cpf) }}</td>
                                <td class="py-2 px-4 text-center">{{ formattedDate(person.birth_date) }}</td>
                                <td class="py-2 px-4 text-center">{{ person.gender }}</td>
                                <td class="py-2 me-2 text-center">
                                    <Link :href="route('people.edit', person.id)">
                                        <v-btn rounded="xs" small color="blue" prepend-icon="mdi-pencil" variant="tonal" class="me-2">Visualizar</v-btn>
                                    </Link>
                                    <v-btn
                                        type="submit"
                                        rounded="xs" small color="blue" prepend-icon="mdi-delete" variant="tonal"
                                        @click="confirmDelete(person)"
                                    >Excluir</v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
                <v-pagination
                    v-model="currentPage"
                    :length="people.last_page"
                    :total-visible="5"
                    @update:modelValue="fetchPage"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"/>
            </v-container>
        </v-main>

        <v-dialog v-model="isDialogOpen" max-width="500">
            <v-card>
                <v-card-title class="text-h5">Confirmar Exclusão</v-card-title>
                    <v-card-text>Tem certeza de que deseja excluir este registro?</v-card-text>
                    <v-card-actions>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="isDialogOpen = false">Cancelar</v-btn>
                        <v-btn rounded="xs" small color="blue" variant="tonal" text @click="deletePerson">Excluir</v-btn>
                    </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script setup>
import Menu from '../../Components/Menu.vue'
import { Head, Link, useForm, router } from "@inertiajs/vue3"
import { useToast } from "vue-toast-notification"
import { defineProps, ref, computed } from "vue"

const props = defineProps ({
    people: Object,
})

const formattedDate = (date) => {
    const year = date.slice(0, 4)
    const month = date.slice(5, 7)
    const day = date.slice(8, 10)
    return day + "/" + month + "/" + year
};

const formattedCpf = (cpf) => {
    cpf = cpf.replace(/\D/g, ""); 
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
};
    
const toast = useToast()
const isDialogOpen = ref(false)
const deleteForm = useForm({})
const selectedPerson = ref(null)

const confirmDelete = (person) => {
    selectedPerson.value = person
    isDialogOpen.value = true
}

const showSuccessToast = () => {
    toast.success('Cadastro excluído com sucesso!', {
        position: 'top-right',
    })
}

const showErrorToast = () => {
        toast.error('Não foi possível excluir o cadastro.', {
            position: 'top-right',
    })
}

const deletePerson = () => {
    deleteForm.delete(route('people.destroy', selectedPerson.value.id), {
        onSuccess: () => {
            isDialogOpen.value = false;
            showSuccessToast()
        },
        onError: () => {
            showErrorToast()
        }
    })
}

// Paginação

const currentPage = ref(props.people.current_page);

const fetchPage = (page) => {
    router.get(route('people.index', { page }));
};

// Filtro

const search = ref("");

const filteredPeople = computed(() => {
  return props.people.data.filter((person) => {
    const searchTerm = search.value.toLowerCase();
    return (
      person.name.toLowerCase().includes(searchTerm) ||
      person.cpf.replace(/\D/g, "").includes(searchTerm) || 
      formattedDate(person.birth_date).includes(searchTerm) ||
      person.gender.toLowerCase().includes(searchTerm)
    );
  });
});
</script>