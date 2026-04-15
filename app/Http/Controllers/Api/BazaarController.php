<?php

namespace App\Http\Controllers\Api;

use App\Models\Trader;
use App\Filters\BazaarFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BazaarResource;

class BazaarController extends Controller
{
    protected array $allowSortBy = ['item', 'qty', 'price', 'seller'];
    protected array $allowSortDir = ['asc', 'desc'];

    public function listings(Request $request)
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
                                       ->orderBy('trader.item_cost')
                                       ->orderBy('character_data.name'),
            'qty'       => $traderQuery->orderBy('trader.item_charges', $direction),
            'price'     => $traderQuery->orderBy('trader.item_cost', $direction),
            'seller'    => $traderQuery->orderBy('character_data.name', $direction),
            default     => $traderQuery->orderBy('items.Name')
                                       ->orderBy('trader.item_cost')
                                       ->orderBy('character_data.name'),
        };

        $paginated = $traderQuery->paginate(100)->appends($request->query());

        return BazaarResource::collection($paginated);
    }
}
