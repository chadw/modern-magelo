<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\Models\CharacterData;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class LdonFilter
{
    protected Request $request;

    protected array $filters = [
        'name',
        'type',
        'rank',
    ];

    protected string $success;
    protected string $failure;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(): EloquentBuilder
    {
        $this->resolveType($this->request->get('type', 'all'));

        $baseQuery = CharacterData::query()
            ->selectRaw("
                character_data.id,
                character_data.name,
                character_data.deleted_at,
                guilds.id as guild_id,
                guilds.name as guild_name,
                IFNULL({$this->success}, 0) as success,
                IFNULL({$this->failure}, 0) as failure,
                IFNULL((IFNULL({$this->success}, 0) / (IFNULL({$this->success}, 0) + IFNULL({$this->failure}, 0))) * 100, 0) as percent
            ")
            ->leftJoin('adventure_stats', 'character_data.id', '=', 'adventure_stats.player_id')
            ->leftJoin('guild_members', 'character_data.id', '=', 'guild_members.char_id')
            ->leftJoin('guilds', 'guild_members.guild_id', '=', 'guilds.id');

        $rankedQuery = CharacterData::fromSub($baseQuery, 'ranked')
            ->selectRaw('RANK() OVER (ORDER BY success DESC, percent DESC, failure ASC) as rank, ranked.*');

        $builder = CharacterData::query()->fromSub($rankedQuery, 'final')
            ->select('*')
            ->where('rank', '<=', 100)
            ->whereNull('deleted_at');

        foreach ($this->filters as $filter) {
            if (method_exists($this, $filter) && $this->request->filled($filter)) {
                $this->{$filter}($builder, $this->request->get($filter));
            }
        }

        $allowedSorts = ['name', 'rank', 'success', 'failure', 'percent'];
        $sort = $this->request->get('sort');
        $direction = strtolower($this->request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($sort && in_array($sort, $allowedSorts)) {
            $builder->orderBy($sort, $direction);
        } else {
            $builder->orderBy('rank', 'asc');
        }

        return $builder;
    }

    protected function resolveType($value): void
    {
        $map = [
            'guk' => ['guk_wins', 'guk_losses'],
            'mir' => ['mir_wins', 'mir_losses'],
            'mmc' => ['mmc_wins', 'mmc_losses'],
            'ruj' => ['ruj_wins', 'ruj_losses'],
            'tak' => ['tak_wins', 'tak_losses'],
            'all' => [
                'guk_wins + mir_wins + mmc_wins + ruj_wins + tak_wins',
                'guk_losses + mir_losses + mmc_losses + ruj_losses + tak_losses',
            ],
        ];

        [$this->success, $this->failure] = $map[strtolower($value)] ?? $map['all'];
    }

    protected function name($builder, $value): void
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    protected function rank($builder, $value): void
    {
        $builder->having('rank', '<=', (int) $value);
    }
}
