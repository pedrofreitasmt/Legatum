<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    testament: Object,
});

const page = usePage();

const goBack = () => {
    window.history.back();
};

const home = ref({
    icon: 'pi pi-home',
    url: route('dashboard'),
});

const items = ref([
    { label: 'Meus Testamentos', url: route('testaments.index') },
    { label: 'Detalhes do Testamento', icon: 'pi pi-file' }
]);

const getStatusLabel = computed(() => {
    return (statusValue) => {
        const statusItem = page.props.enums.status.find(s => s.value === statusValue);
        return statusItem ? statusItem.label : statusValue;
    };
});

const breadcrumbStyle = {
    root: {
        class: 'bg-black bg-opacity-80 mt-4 rounded-md'
    },
    list: {
        class: 'flex justify-center items-center gap-2 p-4'
    },
    separator: {
        class: 'text-yellow-500'
    },
}
</script>

<template>
    <AppLayout title="Detalhes do Testamento">
        <div class="card flex justify-center">
            <Breadcrumb :home="home" :model="items" class="bg-transparent border-none p-0" :pt="breadcrumbStyle">
                <template #item="{ item, props }">
                    <div class="flex items-center gap-2">
                        <!-- Renderiza um Link do Inertia se o item tiver URL -->
                        <Link v-if="item.url" :href="item.url" v-bind="props.action"
                            class="text-gray-400 hover:text-blue-400">
                        <!-- O ícone só aparece se estiver definido no item (não está, então não aparece aqui) -->
                        <span v-if="item.icon" :class="item.icon" />
                        <span class="font-medium">{{ item.label }}</span>
                        </Link>
                        <!-- Renderiza como texto simples se não tiver URL (página atual) -->
                        <span v-else class="text-gray-200 font-medium">
                            {{ item.label }}
                        </span>
                    </div>
                </template>
            </Breadcrumb>
        </div>

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
