<?php

namespace App\Services;

use App\Models\AaRank;
use App\Models\AaAbility;
use Illuminate\Support\Collection;

class CharacterAa
{
    public function getAbilities($character): Collection
    {
        $rankMap = AaRank::select('id', 'cost', 'next_id')->get()->keyBy('id');
        $charAaMap = $character->aa->pluck('aa_value', 'aa_id')->map(fn($v) => (int) $v);
        $classBit = 2 ** ($character->class - 1);

        // Helpers
        $getFirstRankId = function ($id) use ($rankMap) {
            while (isset($rankMap[$id]) && $rankMap[$id]->prev_id) {
                $id = $rankMap[$id]->prev_id;
            }
            return $id;
        };

        $getTotalRanks = function ($id) use ($rankMap) {
            $count = 1;
            while (isset($rankMap[$id]) && $rankMap[$id]->next_id && isset($rankMap[$rankMap[$id]->next_id])) {
                $count++;
                $id = $rankMap[$id]->next_id;
            }
            return $count;
        };

        $getRankCost = function ($id, $value) use ($rankMap) {
            $currentId = $id;
            while ($value > 0 && isset($rankMap[$currentId])) {
                $nextId = $rankMap[$currentId]->next_id;
                if (!isset($rankMap[$nextId])) return null;
                $currentId = $nextId;
                $value--;
            }
            //return (int) ($rankMap[$currentId]->cost ?? 0);
            return $rankMap[$currentId]->cost ?? null;
        };

        $getSpentCost = function ($id, $value) use ($rankMap) {
            $total = 0;
            $currentId = $id;

            while ($value > 0 && isset($rankMap[$currentId])) {
                $total += $rankMap[$currentId]->cost ?? 0;

                $nextId = $rankMap[$currentId]->next_id;
                if (!isset($rankMap[$nextId])) break;

                $currentId = $nextId;
                $value--;
            }

            return $total;
        };

        /* $totalAssigned = 0;
        foreach ($charAaMap as $firstId => $ranksTrained) {
            if ($ranksTrained > 0) {
                $totalAssigned += $getSpentCost($firstId, $ranksTrained);
            }
        } */

        return AaAbility::select('first_rank_id', 'name', 'type', 'grant_only')
            ->classBit($classBit)
            ->where('enabled', 1)
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->filter(fn($aa) =>
                isset($rankMap[$aa->first_rank_id]) &&
                !str_contains(strtolower($aa->name), 'unknown aa')
            )
            ->map(function ($aa) use ($charAaMap, $getTotalRanks, $getRankCost) {
                $cur = $charAaMap[$aa->first_rank_id] ?? 0;
                $cost = $getRankCost($aa->first_rank_id, $cur);

                return [
                    'TYPE' => $aa->type,
                    'NAME' => $aa->name,
                    'MAX' => $getTotalRanks($aa->first_rank_id),
                    'CUR' => $cur,
                    'GRANT_ONLY' => $aa->grant_only,
                    'COST' => [
                        'raw' => $cost ?? 0,
                        'display' => is_numeric($cost) ? $cost : '--',
                    ],
                ];
            })
            ->values();

        /* return [
            'abilities' => $abilities,
            'total_assigned' => $totalAssigned,
        ]; */
    }
}
