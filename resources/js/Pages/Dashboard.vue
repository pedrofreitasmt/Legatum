<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    user: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-50 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="flex justify-center mt-5 text-gray-50">
            <section class="bg-black/50 w-[40rem] h-[18rem] rounded-md">
                <div class="flex justify-center mt-5 font-semibold">
                    <h1 class="text-2xl text-white">Bem-vindo ao Legatum, {{ user.name }}!</h1>
                </div>

                <div class="flex flex-col items-center gap-4 mt-5">
                    <Link class="bg-slate-500 hover:bg-slate-600 cursor-pointer px-6 py-3 w-[14rem] text-center rounded-md font-semibold text-xl"
                        :href="route('testaments.index')">Meus Testamentos</Link>
                    <Link class="bg-slate-500 hover:bg-slate-600 cursor-pointer px-6 py-3 w-[14rem] text-center rounded-md font-semibold text-xl"
                        :href="route('testaments.create')">Criar Testamento</Link>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
