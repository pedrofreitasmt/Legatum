<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    user: Object,
})

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppLayout title="Detalhes do Usuário">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Detalhes do Usuário
            </h2>
        </template>

        <section class="flex flex-col items-center justify-center text-gray-50 mt-5">
            <div class="bg-black/50 max-w-4xl w-full py-12 rounded-md shadow-xl">
                <div class="flex justify-center">
                    <h1 class="font-semibold text-2xl">Usuário: {{ user.name }}</h1>
                </div>

                <hr class="m-2 border-gray-600">

                <div class="grid grid-cols-2 gap-4 max-w-3xl mx-auto p-4">
                    <div class="flex flex-col gap-4 bg-black/50 rounded-2xl px-2 py-4 shadow">
                        <div class="text-center">
                            <p class="font-semibold text-lg">Email:</p>
                            <p class="text-lg">{{ user.email }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-semibold text-lg">Telefone:</p>
                            <p class="text-lg">{{ user.phone }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 bg-black/50 rounded-2xl px-2 py-4 shadow">
                        <div class="text-center">
                            <p class="font-semibold text-lg">CPF:</p>
                            <p class="text-lg">{{ user.cpf }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-semibold text-lg">Data de criação:</p>
                            <p class="text-lg">{{ user.created_at }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-evenly mt-2">
                    <div class="bg-black/50 p-6 rounded-2xl shadow text-center">
                        <p class="font-semibold text-lg">Última Atualização:</p>
                        <p class="text-lg">{{ user.updated_at }}</p>
                    </div>
                    <div class="flex justify-center items-center bg-black px-4 gap-2 rounded-2xl shadow">
                        <p class="font-semibold text-lg">Testamentos Registrados:</p>
                        <p class="text-lg">{{ user.testaments_count }}</p>
                    </div>
                </div>
            </div>
            <div class="max-w-4xl w-full mt-4 text-right">
                <button @click="goBack" class="bg-yellow-500 hover:bg-yellow-600 font-semibold px-4 py-2 rounded-full text-gray-50 cursor-pointer ">
                    Voltar
                </button>
            </div>
        </section>
    </AppLayout>
</template>
