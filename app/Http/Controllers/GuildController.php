<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\GuildMember;
use Illuminate\Http\Request;
use App\Models\CharacterData;

class GuildController extends Controller
{
    protected array $allowSortBy = ['name', 'level'];
    protected array $allowSortDir = ['asc', 'desc'];

    public function show(Guild $guild, Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $sortAliases = [
            'name'  => 'c.name',
            'level' => 'c.level',
        ];

        if (!in_array($sort, $this->allowSortBy)) {
            $sort = 'name';
        }

        if (!in_array(strtolower($direction), $this->allowSortDir)) {
            $direction = 'asc';
        }

        $membersQuery = GuildMember::query()
            ->where('guild_id', $guild->id)
            ->with([
                'character' => function ($query) {
                    $query->whereNull('deleted_at')
                        ->select(['id', 'name', 'race', 'class', 'level', 'anon', 'gm']);
                },
                'guildRank' => function ($query) use($guild) {
                    $query->where('guild_id', $guild->id)->select('guild_id', 'rank', 'title');
                }
            ])
            ->join('character_data as c', function ($join) {
                $join->on('guild_members.char_id', '=', 'c.id')
                    ->whereNull('c.deleted_at');
            })
            ->select('guild_members.*')
            ->orderBy($sortAliases[$sort], $direction);

        // Optionally handle request sorting parameters here if you want dynamic sort

        $members = $membersQuery->paginate(100)->withQueryString();

        $guild->load('leaderCharacter');

        $avgLevel = GuildMember::where('guild_id', $guild->id)
            ->join('character_data as c', 'guild_members.char_id', '=', 'c.id')
            ->whereNull('c.deleted_at')
            ->avg('c.level');

        //return response()->json($guild);
        return view('guild.show', [
            'guild' => $guild,
            'members' => $members,
            'avgLevel' => round($avgLevel, 0),
        ]);
    }
}
