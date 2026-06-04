<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\ViewModels\ItemViewModel;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function popup(Item $item)
    {
        $item = Item::where('id', $item->id)->firstOrFail();
        (new ItemViewModel($item))->withEffects();

        $augs = [];
        if ($augParam = request()->input('augs')) {
            $augIds = array_map('intval', explode(',', $augParam));
            foreach ($augIds as $augId) {
                if ($augId > 0) {
                    $aug = Item::find($augId);
                    if ($aug) {
                        (new ItemViewModel($aug))->withEffects();
                    }
                    $augs[] = $aug;
                } else {
                    $augs[] = null;
                }
            }
        }

        return response()->json([
            'html' => view('partials.items.popup', [
                'item' => $item,
                'augs' => $augs
            ])->render()
        ]);
    }

    public function suggest(Request $request)
    {
        $q = $request->query('q');

        if (!is_string($q) || strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Item::where('Name', 'like', "%{$q}%")
            ->groupBy('Name')
            ->limit(50)
            ->orderBy('Name')
            ->pluck('Name');

        return response()->json($results->values());
    }
}
