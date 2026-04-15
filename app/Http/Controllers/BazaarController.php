<?php

namespace App\Http\Controllers;

use App\Models\Trader;
use App\Filters\BazaarFilter;
use Illuminate\Http\Request;
use App\Models\CharacterData;

class BazaarController extends Controller
{
    protected array $allowSortBy = ['item', 'qty', 'price', 'seller'];
    protected array $allowSortDir = ['asc', 'desc'];

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'item');
        $direction = $request->get('direction', 'asc');

        $sort = in_array($sort, $this->allowSortBy) ? $sort : 'item';
        $direction = in_array($direction, $this->allowSortDir) ? $direction : 'asc';

        $traderQuery = Trader::query()
            ->select('trader.*')
            ->join('items', 'items.id', '=', 'trader.item_id')
            ->join('character_data', 'character_data.id', '=', 'trader.char_id')
            ->with([
                'item:id,Name,icon,itemtype,ac,hp,damage,delay,augtype,slots,bagslots,bagwr',
                'character:id,name'
            ]);

        $traderQuery = (new BazaarFilter($request))->apply($traderQuery);

        match ($sort) {
            'item'      => $traderQuery->orderBy('items.Name', $direction)
                                       ->orderBy('trader.item_cost', 'asc')
                                       ->orderBy('character_data.name', 'asc'),
            'qty'       => $traderQuery->orderBy('trader.item_charges', $direction),
            'price'     => $traderQuery->orderBy('trader.item_cost', $direction),
            'seller'    => $traderQuery->orderBy('character_data.name', $direction),
            default     => $traderQuery->orderBy('items.Name', 'asc')
                                       ->orderBy('trader.item_cost', 'asc')
                                       ->orderBy('character_data.name', 'asc'),
        };

        $traderListings = $traderQuery->paginate(25)->withQueryString();

        // sellers for search select
        $sellers = CharacterData::whereIn('id', Trader::select('char_id'))->orderBy('name')->pluck('name', 'name');

        return view('bazaar.index', [
            'traders' => $traderListings,
            'sellers' => $sellers,
            'metaTitle' => config('app.name') . ' - Bazaar',
        ]);
    }
}
