<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { useSpatiePermissions } from '@/Composables/useSpatiePermissions.js';

const { hasPermission } = useSpatiePermissions();

const searchForm = useForm({
    title: '',
});

const filter = () => {
    searchForm.get(route('users.index', { title: searchForm.title }), {
        preserveState: true,
        replace: true,
        onSuccess: () => {
            searchForm.title = '';
        }
    });
}

defineProps({
    users: Object,
});

</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Usuários
            </h2>
        </template>

        <section class="flex justify-center text-gray-50">
            <div class="flex flex-col items-center bg-black/50 max-w-[80rem] w-full py-12 mt-5 rounded-md">
                <div class="flex justify-center text-2xl mb-5 font-semibold">
                    <h1>Usuários Registrados</h1>
                </div>

                <div class="">
                    <form @submit.prevent="filter">
                        <div class="flex flex-col items-center gap-2 ">
                            <label class="text-gray-50 font-semibold" for="title">
                                Título</label>
                            <input placeholder="Digite o título" v-model="searchForm.title"
                                class="rounded-xl w-[60rem] text-black" name="title" type="text">
                            <button
                                class="bg-green-500 hover:bg-green-600 text-gray-50 py-2 px-4 rounded-full font-semibold"
                                type="submit">Buscar</button>
                        </div>
                    </form>
                </div>

                <div class="flex justify-center">
                    <div v-if="users.data && users.data.length">
                        <hr class="m-5 border-gray-600">
                        <table class="table-auto w-[70rem]">
                            <thead>
                                <tr>
                                    <th class="px-2 py-4 w-1/4">#</th>
                                    <th class="px-2 py-4 w-1/4">Nome Completo</th>
                                    <th class="px-2 py-4 w-1/4">CPF</th>
                                    <th class="px-2 py-4 w-1/4">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="border-t">
                                <tr class="border-b" v-for="(user, index) in users.data" :key="user.id">
                                    <td class="px-2 py-4 text-center">{{ users.from + index }}</td>
                                    <td class="px-2 py-4 text-center truncate max-w-[200xp]" :title="user.name">{{
                                        user.name }}
                                    </td>
                                    <td class="px-2 py-4 text-center">{{ user.cpf }}</td>
                                    <td class="px-2 py-4 text-center">
                                        <div v-if="hasPermission('usuario detalhar')">
                                            <Link :href="route('users.show', { user: user.id })"
                                                class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-semibold rounded-md">
                                            Detalhes
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-6">
                            <Pagination :links="users.links" />
                        </div>

                    </div>
                    <div v-else class="flex justify-center">
                        <p>Nenhum usuário encontrado.</p>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
