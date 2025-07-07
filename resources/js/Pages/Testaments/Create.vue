<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'; // Seus imports
import InputError from '@/Components/InputError.vue'; // Seus imports

// A 'ref' para nos dar acesso direto ao <input>
const fileInput = ref(null);

const form = useForm({
    title: '',
    content: '',
    recipient_email: '',
    attachments: [],
});

/**
 * Adiciona novos arquivos à lista, evitando duplicatas.
 * Limpa o input após a seleção para permitir novas seleções.
 */
function handleFileChange(event) {
    const newFiles = [...event.target.files];
    newFiles.forEach(newFile => {
        const alreadyExists = form.attachments.some(
            existingFile => existingFile.name === newFile.name && existingFile.size === newFile.size
        );
        if (!alreadyExists) {
            form.attachments.push(newFile);
        }
    });
    // Limpa o valor do input para permitir selecionar o mesmo arquivo novamente se ele for removido
    if (fileInput.value) {
        fileInput.value.value = null;
    }
}

/**
 * Remove um arquivo da lista.
 */
function removeFile(index) {
    form.attachments.splice(index, 1);
}

/**
 * Submete o formulário e limpa os anexos em caso de erro de validação.
 */
const submit = () => {
    form.post(route('testaments.store'), {
        onError: (errors) => {
            const hasAttachmentError = Object.keys(errors).some(key => key.startsWith('attachments'));
            if (hasAttachmentError) {
                // Limpa o array de arquivos no formulário do Inertia
                form.reset('attachments');
                // Força a limpeza do elemento <input> no DOM
                if (fileInput.value) {
                    fileInput.value.value = null;
                }
            }
        },
    });
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

                        <div class="flex flex-col gap-2 items-center w-full">
                            <label class="font-semibold">Anexos</label>
                            <input id="attachments" ref="fileInput" type="file" multiple
                                accept=".pdf, .png, .jpg, .jpeg"
                                class="w-96 text-sm text-slate-400 hover:cursor-pointer file:hover:bg-gray-300 file:cursor-pointer file:rounded-md file:p-2"
                                @change="handleFileChange"/>
                            <InputError :message="form.errors.attachments || form.errors['attachments.0']" class="mt-2"></InputError>
                            <div v-if="form.attachments.length > 0"
                                class="mt-2 w-96 rounded-md bg-black/30 p-3 text-sm text-gray-300">
                                <p class="font-semibold mb-2">Arquivos selecionados:</p>
                                <ul class="space-y-2">
                                    <li v-for="(file, index) in form.attachments" :key="index"
                                        class="flex justify-between items-center">
                                        <span>- {{ file.name }}</span>
                                        <button type="button" @click="removeFile(index)"
                                            class="font-bold text-red-500 hover:text-red-400 text-lg px-2"
                                            title="Remover arquivo">
                                            &times;
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1 items-center">
                            <label class="font-semibold" for="recipient_email">Enviar para</label>
                            <input v-model="form.recipient_email" name="recipient_email" type="email"
                                placeholder="Digite o email" class="bg-slate-200 text-gray-900 rounded-md w-96 py-2">
                            <InputError :message="form.errors.recipient_email" class="mt-2"></InputError>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-green-500 rounded-full font-semibold px-6 py-2 hover:bg-green-600 cursor-pointer">Criar
                                Testamento</button>
                            <Link :href="route('dashboard')"
                                class="bg-yellow-500 rounded-full font-semibold px-4 py-2 hover:bg-yellow-600">Voltar
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
