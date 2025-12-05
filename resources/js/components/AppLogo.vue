<script setup lang="ts">
import { computed } from 'vue';
import { getInitials } from '@/composables/useInitials';

const appName = import.meta.env.VITE_APP_NAME || 'Team Builder';
const initials = computed(() => getInitials(appName));
</script>

<template>
    <div
        class="flex aspect-square size-8 items-center justify-center rounded-full bg-sidebar-primary text-sidebar-primary-foreground font-semibold uppercase"
    >
        {{ initials }}
    </div>
    <div class="ml-2 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">
            {{ appName }}
        </span>
    </div>
</template>
