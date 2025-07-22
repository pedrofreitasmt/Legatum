<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { ref } from 'vue';

const props = defineProps({
    testament: Object,
});

const fileInput = ref(null);

const form = useForm({
    _method: 'PUT',
    title: props.testament?.title || '',
    content: props.testament?.content || '',
    recipient_email: props.testament?.recipient_email || '',
    attachments: [],
    attachments_to_delete: [],
});

const existingAttachments = ref(props.testament?.testament_attachments || []);

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

// Marca um anexo existente para remoção
const removeExistingAttachment = (attachmentId) => {
    // Adiciona o ID à lista de exclusão
    if (!form.attachments_to_delete.includes(attachmentId)) {
        form.attachments_to_delete.push(attachmentId);
    }
    // Remove da lista visível
    existingAttachments.value = existingAttachments.value.filter(att => att.id !== attachmentId);
}

// Remove um novo anexo da lista de upload
const removeNewAttachment = (index) => {
    form.attachments.splice(index, 1);
}

const submit = () => {
    const queryParams = new URLSearchParams(window.location.search);
    const page = queryParams.get('page');

    // Usar form.post para lidar corretamente com FormData (multipart/form-data)
    form.post(route('testaments.update', {
        testament: props.testament.id,
        page: page
    }), {
        onError: (errors) => {
            const hasAttachmentError = Object.keys(errors).some(key => key.startsWith('attachments'));
            if (hasAttachmentError) {
                form.reset('attachments');
                if (fileInput.value) {
                    fileInput.value.value = null;
                }
            }
        },
    });
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
                    <div class="grid grid-cols-1 items-center gap-6">
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

                        <div class="flex flex-col gap-2 items-center">
                            <label for="attachments" class="font-semibold">Anexos</label>

                            <!-- Anexos Existentes -->
                            <div v-if="existingAttachments.length > 0" class="w-96 mb-4">
                                <h3 class="font-semibold mb-2">Anexos atuais:</h3>
                                <div class="bg-black/30 rounded-md p-3">
                                    <ul class="space-y-2">
                                        <li v-for="attachment in existingAttachments" :key="attachment.id"
                                            class="flex justify-between items-center">
                                            <div class="flex items-center gap-2">
                                                <a :href="`/storage/${attachment.path}`" target="_blank"
                                                   class="text-blue-400 hover:underline">
                                                    {{ attachment.original_name }}
                                                </a>
                                                <span class="text-xs text-gray-500">
                                                    ({{ (attachment.size / 1024).toFixed(1) }} KB)
                                                </span>
                                            </div>
                                            <button type="button" @click="removeExistingAttachment(attachment.id)"
                                                class="font-bold text-red-500 hover:text-red-400 text-lg px-2"
                                                title="Remover arquivo">
                                                &times;
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Input para novos anexos -->
                            <input id="attachments" ref="fileInput" type="file" multiple
                                accept=".pdf, .png, .jpg, .jpeg"
                                class="w-96 text-sm text-slate-400 hover:cursor-pointer file:hover:bg-gray-300 file:cursor-pointer file:rounded-md file:p-2"
                                @change="handleFileChange"/>
                            <InputError :message="form.errors.attachments || form.errors['attachments.0']" class="mt-2"></InputError>

                            <!-- Novos anexos selecionados -->
                            <div v-if="form.attachments.length > 0"
                                class="mt-2 w-96 rounded-md bg-black/30 p-3 text-sm text-gray-300">
                                <p class="font-semibold mb-2">Novos arquivos selecionados:</p>
                                <ul class="space-y-2">
                                    <li v-for="(file, index) in form.attachments" :key="index"
                                        class="flex justify-between items-center">
                                        <span>- {{ file.name }}</span>
                                        <button type="button" @click="removeNewAttachment(index)"
                                            class="font-bold text-red-500 hover:text-red-400 text-lg px-2"
                                            title="Remover arquivo">
                                            &times;
                                        </button>
                                    </li>
                                </ul>
                            </div>
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
