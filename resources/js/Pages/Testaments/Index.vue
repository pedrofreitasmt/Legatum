<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    testaments: Object,
})
</script>

<template>
    <AppLayout title="Testamentos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Testamentos
            </h2>
        </template>
        <div class="flex justify-center mt-5">
            <section class="bg-black/50 w-[60rem] py-12 rounded-md">
                <div class="flex justify-center mt-5 font-semibold">
                    <h1 class="text-2xl text-white">Meus Testamentos</h1>
                </div>
                <div class="flex justify-center mt-5 text-gray-200">
                    <div v-if="testaments.data && testaments.data.length">
                        <table class="table-auto w-[55rem]">
                            <thead>
                                <tr>
                                    <th class="px-2 py-4">#</th>
                                    <th class="px-2 py-4">Título</th>
                                    <th class="px-2 py-4">Modificado em</th>
                                    <th class="px-2 py-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="border-t">
                                <tr v-for="testament in testaments.data" :key="testament.id">
                                    <td class="px-2 py-4 border-b text-center">{{ testament.id }}</td>
                                    <td class="px-2 py-4 border-b text-center">{{ testament.title }}</td>
                                    <td class="px-2 py-4 border-b text-center">{{ testament.updated_at }} (UTC-3)</td>
                                    <td class="px-2 py-4 border-b space-x-2 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <Link :href="route('testaments.edit', {testament: testament.id, page: testaments.current_page})"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-md font-semibold">
                                            Editar
                                            </Link>
                                            <Link :href="route('testaments.show', testament.id)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-md font-semibold">
                                            Detalhes
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6">
                            <Pagination :links="testaments.links" />
                        </div>
                    </div>

                    <div v-else class="flex justify-center">
                        <p class="text-gray-400">Nenhum testamento encontrado.</p>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
