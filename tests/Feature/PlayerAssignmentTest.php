<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('saves assignments and preserves sort order', function (): void {
    actingAs(User::factory()->create());

    $teams = Team::factory()->count(2)->create();
    $players = Player::factory()->count(3)->create();

    $payload = [
        'teams' => [
            [
                'id' => $teams[0]->id,
                'players' => [
                    ['id' => $players[1]->id, 'sort_order' => 1],
                    ['id' => $players[0]->id, 'sort_order' => 2],
                ],
            ],
            [
                'id' => $teams[1]->id,
                'players' => [
                    ['id' => $players[2]->id, 'sort_order' => 1],
                ],
            ],
        ],
    ];

    post('/player-assignments', $payload)->assertRedirect();

    $this->assertDatabaseCount('player_team', 3);
    $this->assertDatabaseHas('player_team', [
        'player_id' => $players[1]->id,
        'team_id' => $teams[0]->id,
        'sort_order' => 1,
    ]);

    expect($teams[0]->fresh()->players->pluck('id')->all())->toEqual([
        $players[1]->id,
        $players[0]->id,
    ]);
});

it('prevents assigning the same player to multiple teams', function (): void {
    actingAs(User::factory()->create());

    $teams = Team::factory()->count(2)->create();
    $player = Player::factory()->create();

    $payload = [
        'teams' => [
            [
                'id' => $teams[0]->id,
                'players' => [
                    ['id' => $player->id, 'sort_order' => 1],
                ],
            ],
            [
                'id' => $teams[1]->id,
                'players' => [
                    ['id' => $player->id, 'sort_order' => 1],
                ],
            ],
        ],
    ];

    post('/player-assignments', $payload)
        ->assertSessionHasErrors('teams');

    $this->assertDatabaseCount('player_team', 0);
});
