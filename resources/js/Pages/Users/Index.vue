<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

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
            <div class="bg-black/50 max-w-[80rem] w-full py-12 mt-5 rounded-md">
                <div class="flex justify-center text-2xl font-semibold">
                    <h1>Usuários Registrados</h1>
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
                                <td class="px-2 py-4 text-center truncate max-w-[200xp]" :title="user.name">{{ user.name }}</td>
                                <td class="px-2 py-4 text-center">{{ user.cpf }}</td>
                                <td class="px-2 py-4 text-center">
                                    <div>
                                        <Link :href="route('users.show', { user: user.id })" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-semibold rounded-md">
                                            Detalhes
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-6">
                        <Pagination :links="users.links"/>
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
