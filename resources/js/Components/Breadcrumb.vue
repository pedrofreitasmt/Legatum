<!-- BreadcrumbCustom.vue -->
<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <nav class="flex justify-center mt-4">
        <div class="bg-black/80 rounded-md px-6 py-3">
            <ol class="flex items-center space-x-2 text-sm">
                <li v-for="(item, index) in items" :key="index" class="flex items-center">
                    <!-- Separador -->
                    <svg v-if="index > 0" class="w-3 h-3 text-yellow-500 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Link ou texto -->
                    <Link v-if="item.href" :href="item.href"
                        class="flex items-center gap-1 text-gray-400 hover:text-blue-400 transition-colors">
                        <span v-if="item.icon">{{ item.icon }}</span>
                        <span class="font-medium">{{ item.label }}</span>
                    </Link>

                    <span v-else class="flex items-center gap-1 text-gray-200 font-medium">
                        <span v-if="item.icon">{{ item.icon }}</span>
                        {{ item.label }}
                    </span>
                </li>
            </ol>
        </div>
    </nav>
</template>
