<?php

namespace App\Http\Controllers;

use App\Models\CharacterData;
use App\Services\CharacterMain;
use Illuminate\Http\Request;

class CharacterCompareController extends Controller
{
    public function index(Request $request)
    {
        $leftName = $request->query('a');
        $rightName = $request->query('b');

        if (!$leftName || !$rightName) {
            return redirect()->back()->with('error', 'Please select two characters to compare.');
        }

        $left = CharacterData::where('name', $leftName)
            ->where('gm', 0)
            ->with(['inventory', 'account'])
            ->firstOrFail();

        $right = CharacterData::where('name', $rightName)
            ->where('gm', 0)
            ->with(['inventory', 'account'])
            ->firstOrFail();

        $main = new CharacterMain();
        $leftItems = $main->prepareInventory($left);
        $rightItems = $main->prepareInventory($right);

        $leftGear = $leftItems['gear']->keyBy('slot_id');
        $rightGear = $rightItems['gear']->keyBy('slot_id');

        $leftAugs = collect($leftItems['gear'])->flatMap(function ($inv) {
            $out = collect();
            for ($i = 1; $i <= 6; $i++) {
                $aug = $inv->{'aug' . $i} ?? null;
                if ($aug) $out->push($aug);
            }
            return $out;
        })->unique('id')->values();

        $rightAugs = collect($rightItems['gear'])->flatMap(function ($inv) {
            $out = collect();
            for ($i = 1; $i <= 6; $i++) {
                $aug = $inv->{'aug' . $i} ?? null;
                if ($aug) $out->push($aug);
            }
            return $out;
        })->unique('id')->values();

        $augOrder = $leftAugs->concat($rightAugs)
            ->unique('id')
            ->sortBy('Name')
            ->values();

        $slots = range(config('everquest.slot_equipment_start'), config('everquest.slot_equipment_end'));
        $slotLabels = config('everquest.slots_inv') ?? [];

        return view('character.compare', compact(
            'left', 'right', 'leftItems', 'rightItems', 'leftGear', 'rightGear', 'slots', 'slotLabels',
            'leftAugs', 'rightAugs', 'augOrder'
        ));
    }
}
