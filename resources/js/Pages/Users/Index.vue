<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { useSpatiePermissions } from '@/composables/useSpatiePermissions.js';

const { hasPermission } = useSpatiePermissions();

const props = defineProps({
    users: Object,
    filters: Object,
});

const searchForm = useForm({
    name: props.filters?.name || '',
    cpf: props.filters?.cpf || '',
});

const filter = () => {
    searchForm.get(route('users.index'), {
        preserveState: true,
        replace: true,
    });
}

const clearFilters = () => {
    searchForm.reset();
    router.get(route('users.index'));
}

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

                <div class="w-full max-w-4xl">
                    <form @submit.prevent="filter">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="flex flex-col">
                                <label class="text-gray-50 font-semibold mb-2" for="name">
                                    Nome Completo
                                </label>
                                <input id="name" v-model="searchForm.name" placeholder="Digite o Nome Completo"
                                    class="rounded-xl text-black px-3 py-2" name="name" type="text">
                            </div>

                            <div class="flex flex-col">
                                <label class="text-gray-50 font-semibold mb-2" for="cpf">
                                    CPF
                                </label>
                                <input id="cpf" v-model="searchForm.cpf" placeholder="Digite o CPF"
                                    class="rounded-xl text-black px-3 py-2" name="cpf" type="text">
                            </div>
                        </div>

                        <div class="flex justify-center gap-4">
                            <button
                                class="bg-green-500 hover:bg-green-600 text-gray-50 py-2 px-6 rounded-full font-semibold"
                                type="submit">
                                Buscar
                            </button>

                            <button type="button" @click="clearFilters"
                                class="bg-gray-500 hover:bg-gray-600 text-gray-50 py-2 px-6 rounded-full font-semibold">
                                Limpar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex justify-center w-full">
                    <div v-if="users.data && users.data.length" class="w-full">
                        <hr class="m-5 border-gray-600">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full min-w-[70rem] mx-auto">
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
                                        <td class="px-2 py-4 text-center truncate max-w-[200px]" :title="user.name">
                                            {{ user.name }}
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
                        </div>
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
