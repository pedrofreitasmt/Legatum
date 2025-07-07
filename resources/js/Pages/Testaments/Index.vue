<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue';

defineProps({
    testaments: Object,
});
const form = useForm({});

const searchForm = useForm({
    title: '',
});

const selectedTestament = ref(null);

const showModal = ref(false);
const openModal = (testament) => {
    showModal.value = true;
    selectedTestament.value = testament;
};
const closeModal = () => {
    showModal.value = false;
    selectedTestament.value = null;
};

const deleteTestament = () => {
    if (selectedTestament.value) {
        form.delete(route('testaments.destroy',  selectedTestament.value.id ), {
            onSuccess: () => {
                closeModal();
            },
            onError: (errors) => {
                console.log('Erro ao excluir:', errors);
            },
        });
    }
};

const filterTestaments = () => {
    searchForm.get(route('testaments.index', { title: searchForm.title }), {
        preserveState: true,
        replace: true,
        onSuccess: () => {
            searchForm.title = '';
        },
    });
}
</script>

<template>
    <AppLayout title="Testamentos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Testamentos
            </h2>
        </template>
        <div class="flex flex-col items-center mt-5 gap-4">
            <section>
                <div class="bg-black/50 rounded-md py-5">
                    <div class="w-[30rem] py-2 rounded-md gap-2">
                        <form @submit.prevent="filterTestaments">
                            <div class="flex flex-col items-center gap-2 ">
                                <label class="text-gray-50 font-semibold" for="title">Pesquisar testamento por título</label>
                                <input placeholder="Digite o título" v-model="searchForm.title" class="rounded-md" name="title" type="text">
                                <button class="bg-green-500 hover:bg-green-600 text-gray-50 py-2 px-4 rounded-full font-semibold" type="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section class="bg-black/50 w-[80rem] py-12 rounded-md">
                <div class="flex justify-center mt-5 font-semibold">
                    <h1 class="text-2xl text-white">Meus Testamentos</h1>
                </div>
                <div class="flex justify-center mt-5 text-gray-200">
                    <div v-if="testaments.data && testaments.data.length">
                        <table class="table-auto w-[70rem]">
                            <thead>
                                <tr>
                                    <th class="w-16 px-2 py-4">#</th>
                                    <th class="w-96 px-2 py-4">Título</th>
                                    <th class="w-60 px-2 py-4">Modificado em</th>
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
                                            <Link
                                                :href="route('testaments.edit', { testament: testament.id, page: testaments.current_page })"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-md font-semibold">
                                            Editar
                                            </Link>
                                            <Link :href="route('testaments.show', testament.id)"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-md font-semibold">
                                            Detalhes
                                            </Link>
                                            <button @click="openModal(testament)"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-md font-semibold">
                                                Excluir
                                            </button>
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
        <DialogModal :show="showModal" @close="closeModal">
            <template #title>
                Confirmar Exclusão
            </template>
            <template #content>
                Você tem certeza que deseja excluir este testamento?
            </template>
            <template #footer>
                <div class="flex justify-end space-x-3">
                    <button @click="closeModal" :disabled="form.processing"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-semibold">
                        Cancelar
                    </button>

                    <button @click="deleteTestament" :disabled="form.processing"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 disabled:bg-red-400 flex items-center">
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span v-if="form.processing">Excluindo...</span>
                        <span v-else class="font-semibold">Excluir</span>
                    </button>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>
