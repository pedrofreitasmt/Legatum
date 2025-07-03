<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    content: '',
    recipient_email: '',
    send_at: '',
});

const submit = () => {
    form.post(route('testaments.store'));
};

</script>

<template>
    <AppLayout title="Novo Testamento">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Novo Testamento Digital
            </h2>
        </template>

        <div class="flex justify-center mt-5">
            <div class="bg-black/50 w-[60rem] rounded-md py-12 text-gray-50">
                <form @submit.prevent="submit">
                    <div class="flex flex-col items-center gap-6">
                        <div class="flex flex-col gap-1 items-center">
                            <label class="font-semibold" for="title">Assunto</label>
                            <input v-model="form.title" placeholder="Digite o assunto"
                                class="bg-slate-200 text-gray-900 rounded-md p-2 w-64" name="title" type="text">
                            <InputError :message="form.errors.title" class="mt-2"></InputError>
                        </div>

                        <div class="flex flex-col gap-1 items-center">
                            <label class="font-semibold" for="content">Conteúdo</label>
                            <textarea v-model="form.content" placeholder="Digite o conteúdo" maxlength="10000"
                                class="bg-slate-200 text-gray-900 rounded-md w-96 h-32" name="content"></textarea>
                            <InputError :message="form.errors.content" class="mt-2"></InputError>
                        </div>

                        <div class="flex flex-col gap-1 items-center">
                            <label class="font-semibold" for="recipient_email">Enviar para</label>
                            <input v-model="form.recipient_email" name="recipient_email" type="email"
                                placeholder="Digite o email" class="bg-slate-200 text-gray-900 rounded-md w-96 py-2">
                            <InputError :message="form.errors.recipient_email" class="mt-2"></InputError>
                        </div>

                        <div class="flex flex-col gap-1 items-center">
                            <label class="font-semibold" for="send_at">Data de envio</label>
                            <input v-model="form.send_at" name="send_at" type="date"
                                class="bg-slate-200 text-gray-900 rounded-md p-2 font-semibold">
                            <InputError :message="form.errors.send_at" class="mt-2"></InputError>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-green-500 rounded-full font-semibold px-6 py-2 hover:bg-green-600 cursor-pointer">Criar
                                Testamento</button>
                            <Link :href="route('dashboard')"
                                class="bg-yellow-500 rounded-full font-semibold px-4 py-2 hover:bg-yellow-600">Voltar</Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
