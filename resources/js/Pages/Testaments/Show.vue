<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';

defineProps({
    testament: Object,
});

const page = usePage();

const goBack = () => {
    window.history.back();
};

const getStatusLabel = computed(() => {
    return (statusValue) => {
        const statusItem = page.props.enums.status.find(s => s.value === statusValue);
        return statusItem ? statusItem.label : statusValue;
    };
});

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
        <div class="flex justify-center mt-5">
            <div class="bg-black/50 w-[60rem] py-12 rounded-md">
                <section class="px-16 text-gray-50">
                    <div class="flex justify-center mt-5 font-semibold">
                        <h1 class="text-2xl">{{ testament.title }}</h1>
                    </div>
                    <div class="flex justify-center mt-5">
                        <p>{{ testament.content }}</p>
                    </div>
                    <div class="flex justify-center mt-5">
                        <p><strong>Enviar para:</strong> {{ testament.recipient_email }}</p>
                    </div>
                    <div class="flex justify-center mt-5">
                        <p><strong>Status:</strong> {{ getStatusLabel(testament.status) }}</p>
                    </div>
                    <div class="flex justify-center mt-5">
                        <p><strong>Criado em:</strong> {{ testament.created_at }}</p>
                    </div>
                    <div class="flex justify-center mt-5">
                        <p><strong>Última modificação:</strong> {{ testament.updated_at }}</p>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button @click="goBack" type="button"
                            class="bg-blue-500 hover:bg-blue-600 font-semibold py-2 px-4 rounded-md">
                            Voltar
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
