<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use Illuminate\Http\Request;
use App\Models\CharacterData;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        $q = $request->query('q');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = collect();

        $results = $results
            ->merge(
                Guild::where('name', 'like', "%{$q}%")->groupBy('name')->limit(20)->get()->map(function ($guild) {
                    return [
                        'type' => 'guild',
                        'name' => $guild->name,
                        'url' => route('guild.show', strtolower($guild->name)),
                        'id' => 'guild-' . $guild->name
                    ];
                })
            )->merge(
                CharacterData::where('name', 'like', "{$q}%")
                    ->whereNull('deleted_at')
                    ->where('gm', 0)
                    ->limit(20)->get()->map(function ($char) {
                    return [
                        'type' => 'char',
                        'name' => $char->name,
                        'url' => route('character.show', strtolower($char->name)),
                        'id' => 'char-' . $char->name
                    ];
                })
            );

        return response()->json($results->take(40)->values());
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $page = $request->query('page', 1);
        $perPage = 100;

        if (strlen($q) < 2) {
            return view('search.results', [
                'query' => $q,
                'results' => new LengthAwarePaginator([], 0, $perPage),
            ]);
        }

        $characters = CharacterData::where('name', 'like', "{$q}%")
            ->whereNull('deleted_at')
            ->where('gm', 0)
            ->get()
            ->map(function ($char) {
                return [
                    'type' => 'char',
                    'name' => $char->name,
                    'url' => route('character.show', strtolower($char->name)),
                ];
            });

        $guilds = Guild::where('name', 'like', "%{$q}%")
            ->groupBy('name')
            ->get()
            ->map(function ($guild) {
                return [
                    'type' => 'guild',
                    'name' => $guild->name,
                    'url' => route('guild.show', strtolower($guild->name)),
                ];
            });

        $merged = $characters->merge($guilds)->sortBy('name')->values();

        $total = $merged->count();
        $sliced = $merged->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $sliced,
            $total,
            $perPage,
            $page,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        return view('search.results', [
            'query' => $q,
            'results' => $paginated,
        ]);
    }
}
