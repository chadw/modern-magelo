<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\ViewModels\ItemViewModel;
use Illuminate\Support\Facades\Cache;

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
}
