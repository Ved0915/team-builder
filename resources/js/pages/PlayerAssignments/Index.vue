<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import { ref, watch } from 'vue';

type Player = {
    id: number;
    name: string;
    email: string;
    date_of_birth?: string | null;
};

type Team = {
    id: number;
    name: string;
    state?: string | null;
    country?: string | null;
    players: Player[];
};

const props = defineProps<{
    teams: Team[];
    unassignedPlayers: Player[];
}>();

const playerAssignmentsPath = '/player-assignments';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Player assignments',
        href: playerAssignmentsPath,
    },
];

const sortableGroup = { name: 'players', pull: true, put: true };

const unassigned = ref<Player[]>([...props.unassignedPlayers]);
const teams = ref<Team[]>(
    props.teams.map((team) => ({
        ...team,
        players: [...(team.players ?? [])],
    })),
);

watch(
    () => props.unassignedPlayers,
    (nextPlayers) => {
        unassigned.value = [...nextPlayers];
    },
    { deep: true },
);

watch(
    () => props.teams,
    (nextTeams) => {
        teams.value = nextTeams.map((team) => ({
            ...team,
            players: [...(team.players ?? [])],
        }));
    },
    { deep: true },
);

const saving = ref(false);

const saveAssignments = (): void => {
    saving.value = true;

    const payload = {
        teams: teams.value.map((team) => ({
            id: team.id,
            players: team.players.map((player, index) => ({
                id: player.id,
                sort_order: index + 1,
            })),
        })),
    };

    router.post(playerAssignmentsPath, payload, {
        preserveScroll: true,
        onFinish: () => {
            saving.value = false;
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Player assignments" />

        <div class="mx-auto flex max-w-6xl flex-col gap-6 py-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-foreground">
                        Player team builder
                    </p>
                    <p class="text-sm text-muted-foreground">
                        Drag players into teams, reorder them, and save the
                        lineup.
                    </p>
                </div>
                <button
                    class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground shadow disabled:opacity-60"
                    @click="saveAssignments"
                    :disabled="saving"
                >
                    {{ saving ? 'Saving…' : 'Save assignments' }}
                </button>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <p class="text-sm font-semibold text-foreground">
                        Unassigned players
                    </p>
                    <span
                        class="rounded-full bg-muted px-2 py-0.5 text-xs text-muted-foreground"
                    >
                        {{ unassigned.length }}
                    </span>
                </div>
                <div
                    class="min-h-[96px] rounded-xl border border-sidebar-border/70 bg-muted/60 p-3 dark:border-sidebar-border"
                >
                    <draggable
                        v-model="unassigned"
                        :group="sortableGroup"
                        item-key="id"
                        class="flex flex-wrap gap-2"
                    >
                        <template #item="{ element }">
                            <div
                                class="flex cursor-move flex-col gap-1 rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm shadow-sm dark:border-sidebar-border"
                            >
                                <div class="font-medium">{{ element.name }}</div>
                                <div class="text-xs text-muted-foreground">
                                    {{ element.email }} •
                                    {{ element.date_of_birth ?? 'DOB N/A' }}
                                </div>
                            </div>
                        </template>

                        <template #empty>
                            <span class="text-xs text-muted-foreground">
                                No unassigned players
                            </span>
                        </template>
                    </draggable>
                </div>
                <p class="text-xs text-muted-foreground">
                    Drag from here into a team. Drop back here to remove a player
                    from a team.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div
                    v-for="team in teams"
                    :key="team.id"
                    class="flex min-h-[180px] flex-col gap-2 rounded-xl border border-sidebar-border/70 bg-background p-3 shadow-sm dark:border-sidebar-border"
                >
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-semibold text-foreground">
                                {{ team.name }}
                            </p>
                            <p class="text-xs text-muted-foreground">
                                {{ team.state ?? 'N/A' }},
                                {{ team.country ?? 'N/A' }}
                            </p>
                        </div>
                        <span
                            class="rounded-full bg-muted px-2 py-0.5 text-xs text-muted-foreground"
                        >
                            {{ team.players.length }}
                        </span>
                    </div>

                    <draggable
                        v-model="team.players"
                        :group="sortableGroup"
                        item-key="id"
                        class="flex-1 space-y-2 rounded-lg border border-sidebar-border/70 bg-muted/60 p-2 dark:border-sidebar-border"
                    >
                        <template #item="{ element, index }">
                            <div
                                class="flex cursor-move justify-between gap-3 rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm shadow-sm dark:border-sidebar-border"
                            >
                                <div>
                                    <div class="font-medium text-foreground">
                                        {{ element.name }}
                                    </div>
                                    <div class="text-xs text-muted-foreground">
                                        {{ element.email }} •
                                        {{ element.date_of_birth ?? 'DOB N/A' }}
                                    </div>
                                </div>
                                <span class="self-center text-xs text-muted-foreground"
                                    >#{{ index + 1 }}</span
                                >
                            </div>
                        </template>

                        <template #empty>
                            <span class="text-xs text-muted-foreground">
                                Drop players here
                            </span>
                        </template>
                    </draggable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
