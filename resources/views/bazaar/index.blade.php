@extends('layouts.default')
@section('title', 'Bazaar')

@section('content')
@php
    // slots
    $removeSlots = ['65536', '32768', '1024', '512', '16', '2'];
@endphp
<div class="flex gap-6">
    <div class="w-1/5 min-w-[300px]">
        @include('bazaar.partials.search')
    </div>
    <div class="w-4/5">
        <div class="border border-base-content/5 overflow-x-auto mb-6">
            <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
                <thead class="text-xs uppercase bg-base-300">
                    <tr>
                        <th scope="col" width="40%">{!! sortLink('item', 'Item') !!}</th>
                        <th scope="col" width="10%">{!! sortLink('qty', 'Qty') !!}</th>
                        <th scope="col" width="20%">{!! sortLink('price', 'Price') !!}</th>
                        <th scope="col" width="30%" class="text-right">{!! sortLink('seller', 'Seller') !!}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($traders as $trader)
                        @php $ttid = tooltip_uid(); @endphp
                        <tr>
                            <td scope="row">
                                <x-item-link-normal
                                    :item_id="$trader->item->id"
                                    :item_name="$trader->item->Name"
                                    :item_icon="$trader->item->icon"
                                    item_class="flex"
                                    :instance="$ttid"
                                />
                            </td>
                            <td>{{ number_format($trader->item_charges == -1 ? 1 : $trader->item_charges) }}</td>
                            <td>{{ number_format($trader->item_cost / 1000, 0) }} pp</td>
                            <td class="text-right">
                                <a href="{{ route('character.show', strtolower($trader->character->name)) }}"
                                    class="text-base link-info link-hover">
                                    {{ $trader->character->name ?? 'Unknown' }}
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

        {{ $traders->onEachSide(2)->links() }}
    </div>
</div>
@endsection
