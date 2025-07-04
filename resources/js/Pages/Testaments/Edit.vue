<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';

const props = defineProps({
    testament: Object,
});

const form = useForm({
    title: props.testament?.title || '',
    content: props.testament?.content || '',
    recipient_email: props.testament?.recipient_email || '',
});

const submit = () => {
    const queryParams = new URLSearchParams(window.location.search);
    const page = queryParams.get('page');

    form.put(route('testaments.update', {
        testament: props.testament.id,
        page: page
    }));
}

const goBack = () => {
    window.history.back();
}

const breadcrumbItems = [
    { label: 'Dashboard', href: route('dashboard') },
    { label: 'Meus Testamentos', href: route('testaments.index') },
    { label: 'Editar Testamento' }
];
</script>

<template>
    <AppLayout title="Editar Testamento">
        <Breadcrumb :items="breadcrumbItems"></Breadcrumb>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Editar Testamento
            </h2>
        </template>

        <div class="flex justify-center mt-5">
            <div class="bg-black/50 w-[60rem] py-12 rounded-md text-gray-50">
                <form @submit.prevent="submit">
                    <div class="flex flex-col items-center gap-6">
                        <div class="flex flex-col gap-2 items-center">
                            <label class="font-semibold" for="title">Atualizar assunto</label>
                            <input v-model="form.title" placeholder="Digite o assunto"
                                class="bg-slate-200 text-gray-900 rounded-md p-2 w-64" name="title" type="text">
                            <InputError :message="form.errors.title" class="mt-2"></InputError>
                        </div>

                        <div class="flex flex-col gap-2 items-center">
                            <label class="font-semibold" for="content">Atualizar conteúdo</label>
                            <textarea v-model="form.content" placeholder="Digite o conteúdo" maxlength="10000"
                                class="bg-slate-200 text-gray-900 rounded-md w-96 h-32" name="content"></textarea>
                            <InputError :message="form.errors.content" class="mt-2"></InputError>
                        </div>

                        <div class="flex flex-col gap-2 items-center">
                            <label class="font-semibold" for="recipient_email">Enviar para</label>
                            <input v-model="form.recipient_email" name="recipient_email" type="email"
                                placeholder="Digite o email" class="bg-slate-200 text-gray-900 rounded-md w-96 py-2">
                            <InputError :message="form.errors.recipient_email" class="mt-2"></InputError>
                        </div>
                    </div>
                    <div class="flex justify-center mt-6 gap-2">
                        <button
                            class="bg-green-500 hover:bg-green-600  text-gray-50 rounded-full font-semibold px-6 py-2 cursor-pointer"
                            type="submit">Atualizar Testamento</button>
                        <button @click="goBack" type="button"
                            class="bg-yellow-500 hover:bg-yellow-600 text-gray-50 rounded-full font-semibold px-4 py-2 cursor-pointer">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
