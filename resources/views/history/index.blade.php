@extends('layouts.default')
@section('title', 'Bazaar Sold History')

@section('content')
<div class="flex gap-6">
    <div class="w-1/5 min-w-[300px]">
        @include('history.partials.filters')
    </div>
    <div class="w-4/5">
        @include('history.partials.medians', ['priceStats' => $priceStats])

        <div class="border border-base-content/5 overflow-x-auto mb-6">
            <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
                <thead class="text-xs uppercase bg-base-300">
                    <tr>
                        <th scope="col" class="w-[20%]">{!! sortLink('seller', 'Seller') !!}</th>
                        <th scope="col">Item</th>
                        <th scope="col" class="w-[10%] text-center">Qty</th>
                        <th scope="col" class="w-[15%]">{!! sortLink('totalcost', 'Sold Price') !!}</th>
                        <th scope="col" class="w-[15%]">{!! sortLink('time', 'Date') !!}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        @php $ttid = tooltip_uid(); @endphp
                        <tr>
                            <td>
                                <div class="flex flex-col">
                                    <span>
                                        @if($log->sellerCharacter)
                                            <a href="{{ route('character.show', $log->sellerCharacter) }}"
                                                class="text-base link-info link-hover">
                                                {{ $log->seller }}
                                            </a>
                                        @else
                                            {{ $log->seller }}
                                        @endif
                                    </span>
                                    @if($log->seller_model)
                                        <span class="text-xs text-base-content/60">
                                            Lvl {{ $log->seller_model->level }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($log->item)
                                    <x-item-link-normal
                                        :item_id="$log->item->id"
                                        :item_name="$log->item->Name"
                                        :item_icon="$log->item->icon"
                                        item_class="flex"
                                        :instance="$ttid"
                                    />
                                @endif
                                <div class="text-xs text-base-content/60">
                                    Total Transaction:
                                    <x-currency :value="$log->totalcost" />
                                </div>
                            </td>
                            <td class="text-center">
                                {{ number_format($log->quantity) }}
                            </td>
                            <td>
                                <div class="flex flex-col items-start gap-1 text-sm">
                                    <div class="flex justify-end gap-1">
                                        <x-currency :value="$log->totalcost / $log->quantity" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $log->time?->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-base-content/50">
                                No bazaar history found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
