<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\CharacterData;
use App\Models\Account;

class CharacterMoverController extends Controller
{
    public function index()
    {
        return view('char_mover.index');
    }

    public function store(Request $request)
    {
        $rows = $request->input('rows', []);
        $allowed = (array) config('everquest.char_mover_zones', []);
        if (!empty($allowed)) {
            $allowedZoneIds = array_map('intval', array_keys($allowed));
        } else {
            $allowedZoneIds = [152, 202];
        }

        $nonEmpty = array_filter($rows, function ($r) {
            $login = trim($r['login'] ?? '');
            $charName = trim($r['character'] ?? '');
            $zoneId = $r['zone_id'] ?? null;
            return $login !== '' || $charName !== '' || $zoneId;
        });

        if (count($nonEmpty) === 0) {
            return redirect()->back()->with('error', 'No rows submitted');
        }
        $results = [];

        foreach ($rows as $i => $row) {
            $login = trim($row['login'] ?? '');
            $charName = trim($row['character'] ?? '');
            $zoneId = $row['zone_id'] ?? null;

            if ($login === '' || $charName === '' || !$zoneId) {
                $results[] = ['row' => $i, 'status' => 'error', 'message' => 'Missing required fields'];
                continue;
            }

            if (!in_array((int)$zoneId, $allowedZoneIds, true)) {
                $results[] = ['row' => $i, 'status' => 'error', 'message' => "Zone {$zoneId} is not allowed"];
                continue;
            }

            $account = Account::where('name', $login)->first();
            if (!$account) {
                $results[] = ['row' => $i, 'status' => 'error', 'message' => "Account {$login} not found"];
                continue;
            }

            $character = CharacterData::where('name', $charName)->where('account_id', $account->id)->first();
            if (!$character) {
                $results[] = ['row' => $i, 'status' => 'error', 'message' => "Character {$charName} not found for {$login}"];
                continue;
            }

            $zone = Zone::resolveZone((int) $zoneId)->first([
                'zoneidnumber', 'short_name', 'safe_x', 'safe_y', 'safe_z', 'safe_heading'
            ]);

            if (!$zone) {
                $results[] = ['row' => $i, 'status' => 'error', 'message' => "Zone {$zoneId} not found"];
                continue;
            }

            $oldZoneShort = optional($character->zone)->short_name ?? $character->zone_id;

            $character->update([
                'zone_id' => $zoneId,
                'zone_instance' => 0,
                'x' => $zone->safe_x ?? $character->x ?? 0,
                'y' => $zone->safe_y ?? $character->y ?? 0,
                'z' => $zone->safe_z ?? $character->z ?? 0,
                'heading' => $zone->safe_heading ?? $character->heading ?? 0,
            ]);
            $newZoneShort = $zone->short_name ?? $zoneId;

            $results[] = ['row' => $i, 'status' => 'ok', 'message' => "{$charName} moved from {$oldZoneShort} to {$newZoneShort}"];
        }

        $processed = collect($results)->where('status', 'ok')->pluck('message')->all();
        if (count($processed) === 0) {
            return redirect()->back()->with('move_results', $results)->with('error', 'No moves processed');
        }

        $successMsg = 'Processed ' . count($processed) . ' moves';
        return redirect()->back()->with('move_results', $results)->with('success', $successMsg);
    }
}
