<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import {
    Users,
    Group,
    UserCheck,
    UserX,
    TrendingUp,
    LineChart,
    Clock,
} from 'lucide-vue-next';

type Team = {
    id: number;
    name: string;
    state?: string | null;
    country?: string | null;
    players_count: number;
};

type Stats = {
    players: number;
    teams: number;
    assigned: number;
    unassigned: number;
    assignment_rate: number;
    avg_team_size: number;
    empty_teams: number;
};

type Player = {
    id: number;
    name: string;
    email: string;
    date_of_birth?: string | null;
    created_at?: string;
};

const props = defineProps<{
    stats: Stats;
    teams: Team[];
    unassignedPlayers: Player[];
    recentPlayers: Player[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const statCards = [
    {
        label: 'Players',
        value: props.stats.players,
        icon: Users,
    },
    {
        label: 'Teams',
        value: props.stats.teams,
        icon: Group,
    },
    {
        label: 'Assigned',
        value: props.stats.assigned,
        icon: UserCheck,
    },
    {
        label: 'Unassigned',
        value: props.stats.unassigned,
        icon: UserX,
    },
    {
        label: 'Assignment rate',
        value: `${props.stats.assignment_rate}%`,
        icon: TrendingUp,
    },
    {
        label: 'Avg team size',
        value: props.stats.avg_team_size,
        icon: LineChart,
    },
    {
        label: 'Teams needing players',
        value: props.stats.empty_teams,
        icon: Clock,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-8 p-4 md:p-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-semibold text-foreground">
                    Overview
                </h1>
                <p class="text-sm text-muted-foreground">
                    Track players, teams, and assignments at a glance.
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-5">
                <div
                    v-for="card in statCards"
                    :key="card.label"
                    class="flex items-center gap-3 rounded-xl border border-sidebar-border/70 bg-background p-4 shadow-sm dark:border-sidebar-border"
                >
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"
                    >
                        <component :is="card.icon" class="h-5 w-5" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-muted-foreground">
                            {{ card.label }}
                        </span>
                        <span class="text-xl font-semibold text-foreground">
                            {{ card.value }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div
                    class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 bg-background p-4 shadow-sm dark:border-sidebar-border xl:col-span-2"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-foreground">
                                Team capacity
                            </p>
                            <p class="text-xs text-muted-foreground">
                                Top teams by assigned players
                            </p>
                        </div>
                        <Link
                            href="/player-assignments"
                            class="text-sm font-semibold text-primary"
                        >
                            Manage
                        </Link>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="team in props.teams"
                            :key="team.id"
                            class="flex items-center justify-between rounded-lg border border-sidebar-border/70 bg-muted/60 px-3 py-2 text-sm dark:border-sidebar-border"
                        >
                            <div>
                                <p class="font-medium text-foreground">
                                    {{ team.name }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ team.state ?? 'N/A' }},
                                    {{ team.country ?? 'N/A' }}
                                </p>
                            </div>
                            <span
                                class="rounded-full bg-background px-3 py-1 text-xs font-semibold text-muted-foreground shadow"
                            >
                                {{ team.players_count }} players
                            </span>
                        </div>
                        <p
                            v-if="!props.teams.length"
                            class="text-xs text-muted-foreground"
                        >
                            No teams yet. Start by creating assignments.
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 bg-gradient-to-br from-primary/10 via-background to-background p-4 shadow-sm dark:border-sidebar-border"
                >
                    <p class="text-sm font-semibold text-foreground">
                        Get started quickly
                    </p>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <Link
                            href="/player-assignments"
                            class="flex flex-col gap-1 rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm font-semibold text-foreground shadow-sm transition hover:border-primary hover:text-primary dark:border-sidebar-border"
                        >
                            Assign players
                            <span class="text-xs font-normal text-muted-foreground">
                                Drag and drop players into teams
                            </span>
                        </Link>
                        <Link
                            href="/player-assignments"
                            class="flex flex-col gap-1 rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm font-semibold text-foreground shadow-sm transition hover:border-primary hover:text-primary dark:border-sidebar-border"
                        >
                            Review roster
                            <span class="text-xs font-normal text-muted-foreground">
                                See current team rosters
                            </span>
                        </Link>
                    </div>
                    <div class="rounded-lg border border-sidebar-border/70 bg-background px-3 py-2 text-sm text-muted-foreground shadow-sm dark:border-sidebar-border">
                        Save assignments to keep ordering and team placements
                        in sync. Drag players back to "Unassigned" to remove
                        them from a team.
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 bg-background p-4 shadow-sm dark:border-sidebar-border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-foreground">
                                Unassigned spotlight
                            </p>
                            <p class="text-xs text-muted-foreground">
                                Players currently waiting for a team
                            </p>
                        </div>
                        <span
                            class="rounded-full bg-muted px-2 py-0.5 text-xs text-muted-foreground"
                        >
                            {{ props.unassignedPlayers.length }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div
                            v-for="player in props.unassignedPlayers"
                            :key="player.id"
                            class="flex items-center justify-between rounded-lg border border-sidebar-border/70 bg-muted/60 px-3 py-2 text-sm dark:border-sidebar-border"
                        >
                            <div>
                                <p class="font-medium text-foreground">
                                    {{ player.name }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ player.email }}
                                </p>
                            </div>
                            <Link
                                href="/player-assignments"
                                class="text-xs font-semibold text-primary"
                            >
                                Assign
                            </Link>
                        </div>
                        <p
                            v-if="!props.unassignedPlayers.length"
                            class="text-xs text-muted-foreground"
                        >
                            All players are assigned. Great job!
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 bg-background p-4 shadow-sm dark:border-sidebar-border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-foreground">
                                Recent players
                            </p>
                            <p class="text-xs text-muted-foreground">
                                Latest additions to your roster
                            </p>
                        </div>
                        <span
                            class="rounded-full bg-muted px-2 py-0.5 text-xs text-muted-foreground"
                        >
                            {{ props.recentPlayers.length }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div
                            v-for="player in props.recentPlayers"
                            :key="player.id"
                            class="flex items-center justify-between rounded-lg border border-sidebar-border/70 bg-muted/60 px-3 py-2 text-sm dark:border-sidebar-border"
                        >
                            <div>
                                <p class="font-medium text-foreground">
                                    {{ player.name }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ player.email }}
                                </p>
                            </div>
                            <span class="text-xs text-muted-foreground">
                                New
                            </span>
                        </div>
                        <p
                            v-if="!props.recentPlayers.length"
                            class="text-xs text-muted-foreground"
                        >
                            No recent players yet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
