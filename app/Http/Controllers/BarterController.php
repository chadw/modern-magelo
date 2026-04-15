<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\BuyerBuyLine;
use Illuminate\Http\Request;
use App\Filters\BarterFilter;
use App\Models\CharacterData;
use App\Models\CharacterInventory;
use Illuminate\Support\Facades\DB;

class BarterController extends Controller
{
    protected array $allowSortBy = ['item', 'qty', 'price', 'buyer'];
    protected array $allowSortDir = ['asc', 'desc'];

    public function index(Request $request)
    {
        $seller = $request->get('seller');

        $sort = $request->get('sort', 'item');
        $direction = $request->get('direction', 'asc');

        $sort = in_array($sort, $this->allowSortBy) ? $sort : 'item';
        $direction = in_array($direction, $this->allowSortDir) ? $direction : 'asc';

        // buyers
        $buyerQuery = BuyerBuyLine::query()
            ->join('items', 'buyer_buy_lines.item_id', '=', 'items.id')
            ->join('character_data', 'buyer_buy_lines.char_id', '=', 'character_data.id')
            ->with([
                'buyer:id,char_id',
                'buyer.character:id,name',
                'character:id,name',
                'item:id,Name,icon'
            ])
            ->select('buyer_buy_lines.*');

        $buyerQuery = (new BarterFilter($request))->apply($buyerQuery);

        match ($sort) {
            'item'      => $buyerQuery->orderBy('items.Name', $direction)
                                      ->orderBy('buyer_buy_lines.item_price', 'asc')
                                      ->orderBy('character_data.name', 'asc'),
            'qty'       => $buyerQuery->orderBy('buyer_buy_lines.item_qty', $direction),
            'price'     => $buyerQuery->orderBy('buyer_buy_lines.item_price', $direction),
            'buyer'     => $buyerQuery->orderBy('character_data.name', $direction),
            default     => $buyerQuery->orderBy('items.Name', 'asc')
                                      ->orderBy('buyer_buy_lines.item_price', 'asc')
                                      ->orderBy('character_data.name', 'asc'),
        };

        $buyerListings = $buyerQuery->paginate(25)->withQueryString();

        // seller inventory
        $seller_items = collect();
        if ($seller) {
            // get all buyer items
            $allBuyerItems = BuyerBuyLine::pluck('item_id')->unique();

            // seller character name
            $sellerCharacter = CharacterData::where('name', $seller)
                ->select('id', 'name')->first();

            // seller items available
            $sellerItems = CharacterInventory::select([
                'item_id',
                'character_id',
                DB::raw('count(character_id) as qty'),
                DB::raw('sum(charges) as charges'),
            ])
            ->with(['item:id,Name,icon'])
            ->whereHas('character', function ($query) use ($seller) {
                $query->where('name', $seller);
            })
            ->whereIn('item_id', $allBuyerItems)
            ->where('instnodrop', 0)
            ->groupBy('item_id')
            ->get()
            ->map(function ($inv) {
                return (object) [
                    'item_id' => $inv->item_id,
                    'qty'     => $inv->qty,
                    'charges' => $inv->charges,
                    'item'    => $inv->item,
                    'source'  => 'inventory',
                ];
            });

            // seller alt currency?
            $sellerAltCurrency = CharacterData::select('id')
                ->where('id', $sellerCharacter->id)
                ->with('altCurrency.altCurrency.item:id,Name,icon')
                ->get()
                ->flatMap(function ($character) use($allBuyerItems) {
                    return $character->altCurrency
                        ->filter(fn ($entry) =>
                            $entry->amount > 0 &&
                            in_array($entry->altCurrency->item_id, $allBuyerItems->all())
                        )
                        ->map(function ($entry) {
                            return (object) [
                                'item_id' => $entry->altCurrency->item_id,
                                'qty'     => $entry->amount,
                                'charges' => $entry->amount,
                                'item'    => $entry->altCurrency->item,
                                'source'  => 'alt_currency',
                            ];
                        });
                });

            $seller_items = $sellerItems->merge($sellerAltCurrency)
                ->sortBy(fn ($item) => $item->item->Name ?? '')
                ->values();
        }

        // buyers for search select
        $buyers = CharacterData::whereIn('id', Buyer::select('char_id'))->orderBy('name')->pluck('name', 'name');

        return view('barter.index', [
            'buyerListings' => $buyerListings,
            'buyers' => $buyers,
            'sellerItems' => $seller_items,
            'sellerCharacter' => $sellerCharacter ?? '',
            'metaTitle' => config('app.name') . ' - Barter',
        ]);
    }
}
