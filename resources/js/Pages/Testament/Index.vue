<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    user: Object,
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
        <section class="bg-black/50 w-[40rem] h-96 rounded-md">
            <div class="flex justify-center mt-5 font-semibold">
                <h1 class="text-2xl text-white">Meus Testamentos</h1>
            </div>
            <div class="flex justify-center mt-5 text-gray-200">
                <table v-if="user.testaments && user.testaments.length" class="table-auto">
                <thead>
                    <tr>
                        <th class="px-2 py-4">#</th>
                        <th class="px-2 py-4">Título</th>
                        <th class="px-2 py-4">Enviado em</th>
                    </tr>
                </thead>
                <tbody class="border-t">
                    <tr v-for="testament in user.testaments" :key="testament.id">
                        <td class="px-2 py-4 border-b">{{ testament.id }}</td>
                        <td class="px-2 py-4 border-b">{{ testament.title }}</td>
                        <td class="px-2 py-4 border-b">{{ testament.send_at }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="flex justify-center">
                <p class="text-gray-400">Nenhum testamento encontrado.</p>
            </div>
            </div>
        </section>
    </div>
</AppLayout>
</template>
