<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});

const translateLabel = (label) => {
    if (label.includes('Previous')) return 'Anterior';
    if (label.includes('Next')) return 'Próximo';
    return label;
};
</script>

<template>
    <nav v-if="links && links.length > 3" class="flex justify-center">
        <div class="flex space-x-1">
            <template v-for="(link, index) in links" :key="index">
                <!-- Link desabilitado -->
                <div v-if="link.url === null" class="px-3 py-2 text-gray-500 cursor-not-allowed bg-gray-800 rounded">
                    <span>{{ translateLabel(link.label) }}</span>
                </div>

                <!-- Link ativo -->
                <Link v-else :href="link.url" class="px-3 py-2 rounded transition-colors" :class="{
                    'bg-yellow-500 text-white': link.active,
                    'bg-gray-700 text-gray-200 hover:bg-gray-600': !link.active
                }">
                <span>{{ translateLabel(link.label) }}</span>
                </Link>
            </template>
        </div>
    </nav>
</template>
