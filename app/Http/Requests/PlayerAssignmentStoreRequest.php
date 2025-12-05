<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class PlayerAssignmentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'teams' => ['required', 'array'],
            'teams.*.id' => ['required', 'exists:teams,id'],
            'teams.*.players' => ['array'],
            'teams.*.players.*.id' => ['required', 'exists:players,id'],
            'teams.*.players.*.sort_order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function validatedWithUniqueness(): array
    {
        $data = $this->validated();

        $data['teams'] = collect($data['teams'])
            ->map(function (array $team): array {
                return [
                    'id' => $team['id'],
                    'players' => $team['players'] ?? [],
                ];
            })
            ->all();

        $playerIds = collect($data['teams'])
            ->pluck('players')
            ->flatten(1)
            ->pluck('id');

        $this->ensurePlayersAreUnique($playerIds);

        return $data;
    }

    private function ensurePlayersAreUnique(Collection $playerIds): void
    {
        $duplicates = $playerIds->duplicates();

        if ($duplicates->isNotEmpty()) {
            throw ValidationException::withMessages([
                'teams' => 'Players may only be assigned to one team.',
            ]);
        }
    }
}
