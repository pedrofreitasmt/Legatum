<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';

defineProps({
    testament: Object,
});

const goBack = () => {
    window.history.back();
};

const breadcrumbItems = [
    { label: 'Dashboard', href: route('dashboard') },
    { label: 'Meus Testamentos', href: route('testaments.index') },
    { label: 'Detalhes do Testamento' }
]

</script>

<template>
    <AppLayout title="Detalhes do Testamento">
        <Breadcrumb :items="breadcrumbItems"></Breadcrumb>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Detalhes do Testamento
            </h2>
        </template>
        <div class="flex justify-center mt-8">
            <div class="bg-black/50 w-full max-w-4xl rounded-lg shadow-lg text-gray-200">
                <div class="p-8">
                    <!-- Título -->
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-50">{{ testament.title }}</h1>
                    </div>

                    <!-- Divisor -->
                    <hr class="border-gray-600 mb-6">

                    <!-- Conteúdo Principal -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-50 mb-2">Conteúdo do Testamento</h2>
                        <p class="text-gray-300 whitespace-pre-wrap break-words bg-black/20 p-4 rounded-md">{{ testament.content }}</p>
                    </div>

                    <!-- Grid de Metadados -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                        <div>
                            <p class="text-md font-semibold text-gray-50">Enviar Para</p>
                            <p class="text-lg">{{ testament.recipient_email }}</p>
                        </div>
                        <div>
                            <p class="text-md font-semibold text-gray-50">Status</p>
                            <p class="text-lg">
                                <span :class="testament.status ? 'font-semibold text-green-400' : 'font-semibold text-yellow-400'">
                                    {{ testament.status ? 'Ativo' : 'Inativo' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-md font-semibold text-gray-50">Criado Em</p>
                            <p class="text-lg">{{ testament.created_at }}</p>
                        </div>
                        <div>
                            <p class="text-md font-semibold text-gray-50">Última Modificação</p>
                            <p class="text-lg">{{ testament.updated_at }}</p>
                        </div>
                    </div>

                    <!-- Seção de Anexos -->
                    <div v-if="testament.testament_attachments && testament.testament_attachments.length > 0">
                        <hr class="border-gray-600 mb-6">
                        <h2 class="text-lg font-semibold text-gray-300 mb-2">Anexos</h2>
                        <ul class="space-y-2 list-disc list-inside">
                            <li v-for="attachment in testament.testament_attachments" :key="attachment.id">
                                <a :href="`/storage/${attachment.path}`" target="_blank" class="text-blue-400 hover:underline">
                                    {{ attachment.original_name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Rodapé com Botão de Voltar -->
                <div class="bg-black/20 px-8 py-4 rounded-b-lg flex justify-end">
                    <button @click="goBack" type="button"
                        class="bg-yellow-500 hover:bg-yellow-600 font-semibold py-2 px-4 rounded-full">
                        Voltar
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
