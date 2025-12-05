<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $playerCount = Player::count();
        $teamCount = Team::count();
        $assignedCount = DB::table('player_team')->distinct('player_id')->count('player_id');
        $unassignedCount = max($playerCount - $assignedCount, 0);

        $teamsWithCounts = Team::withCount('players')
            ->orderByDesc('players_count')
            ->orderBy('name')
            ->get();

        $avgTeamSize = $teamsWithCounts->avg('players_count') ?? 0;
        $emptyTeams = $teamsWithCounts->where('players_count', 0)->count();

        $unassignedPlayers = Player::whereDoesntHave('teams')
            ->orderBy('name')
            ->take(8)
            ->get(['id', 'name', 'email', 'date_of_birth']);

        $recentPlayers = Player::latest()
            ->take(6)
            ->get(['id', 'name', 'email', 'created_at']);

        return Inertia::render('Dashboard', [
            'stats' => [
                'players' => $playerCount,
                'teams' => $teamCount,
                'assigned' => $assignedCount,
                'unassigned' => $unassignedCount,
                'assignment_rate' => $playerCount > 0 ? round(($assignedCount / $playerCount) * 100) : 0,
                'avg_team_size' => round($avgTeamSize, 1),
                'empty_teams' => $emptyTeams,
            ],
            'teams' => $teamsWithCounts->take(6),
            'unassignedPlayers' => $unassignedPlayers,
            'recentPlayers' => $recentPlayers,
        ]);
    }
}
