<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerAssignmentStoreRequest;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PlayerAssignmentController extends Controller
{
    public function index(): Response
    {
        $teams = Team::with('players')->orderBy('name')->get();
        $unassignedPlayers = Player::whereDoesntHave('teams')
            ->orderBy('name')
            ->get();

        return Inertia::render('PlayerAssignments/Index', [
            'teams' => $teams,
            'unassignedPlayers' => $unassignedPlayers,
        ]);
    }

    public function store(PlayerAssignmentStoreRequest $request): RedirectResponse
    {
        $data = $request->validatedWithUniqueness();

        DB::transaction(function () use ($data): void {
            DB::table('player_team')->delete();

            foreach ($data['teams'] as $teamData) {
                $teamId = $teamData['id'];

                foreach ($teamData['players'] as $player) {
                    DB::table('player_team')->insert([
                        'player_id' => $player['id'],
                        'team_id' => $teamId,
                        'sort_order' => $player['sort_order'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return back()->with('success', 'Assignments saved successfully.');
    }
}
