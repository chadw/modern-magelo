@extends('layouts.default')
@section('title', 'Barter')

@section('content')
<div class="flex gap-6">
    <div class="w-1/5 min-w-[300px] sticky top-24">
        <div class="sticky top-24">
            @include('barter.partials.search')
            @include('barter.partials.seller_inventory')
        </div>
    </div>
    <div class="w-4/5">
        <div class="border border-base-content/5 overflow-x-auto mb-6">
            <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
                <thead class="text-xs uppercase bg-base-300">
                    <tr>
                        <th scope="col" width="40%">{!! sortLink('item', 'Item') !!}</th>
                        <th scope="col" width="10%">{!! sortLink('qty', 'Qty') !!}</th>
                        <th scope="col" width="20%">{!! sortLink('price', 'Price') !!}</th>
                        <th scope="col" width="30%" class="text-right">{!! sortLink('buyer', 'Buyer') !!}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buyerListings as $buyer)
                        @php $ttid = tooltip_uid(); @endphp
                        <tr>
                            <td scope="row">
                                <x-item-link-normal
                                    :item_id="$buyer->item->id"
                                    :item_name="$buyer->item->Name"
                                    :item_icon="$buyer->item->icon"
                                    item_class="flex"
                                    :instance="$ttid"
                                />
                            </td>
                            <td>{{ number_format($buyer->item_qty == -1 ? 1 : $buyer->item_qty) }}</td>
                            <td>{{ number_format($buyer->item_price / 1000, 0) }} pp</td>
                            <td class="text-right">
                                <a href="{{ route('character.show', strtolower($buyer->character->name)) }}"
                                    class="text-base link-info link-hover">
                                    {{ $buyer->character->name ?? 'Unknown' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                No results found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $buyerListings->onEachSide(2)->links() }}
    </div>
</div>
@endsection
