@extends('layouts.default')
@section('title', "Comparing - {$left->name} vs {$right->name}")

@section('content')
    <div class="mb-4">
        <h2 class="text-2xl font-bold">
            <a href="{{ route('character.show', strtolower($left->name)) }}" class="link-accent link-hover">
                {{ $left->name }}
            </a>
            <span class="mx-2">vs</span>
            <a href="{{ route('character.show', strtolower($right->name)) }}" class="link-accent link-hover">
                {{ $right->name }}
            </a>
        </h2>
        <div class="text-sm text-base-content/50">Comparing equipped items and augments</div>
    </div>

    <h3 class="text-lg font-semibold mt-8 mb-4 divider divider-start">Equipped Items</h3>

    <div class="border border-base-content/5 overflow-x-auto mb-6">
        <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
            <thead class="text-xs uppercase bg-base-300">
                <tr>
                    <th class="w-[10%]">Slot</th>
                    <th>{{ $left->name }}</th>
                    <th>{{ $right->name }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($slots as $slot)
                    @php
                        $label = $slotLabels[$slot] ?? $slot;
                        $l = $leftGear->get($slot);
                        $r = $rightGear->get($slot);
                    @endphp
                    <tr>
                        <td class="align-top"><strong>{{ $label }}</strong></td>
                        <td class="align-top">@include('character.partials.compare-item', ['inv' => $l])</td>
                        <td class="align-top">@include('character.partials.compare-item', ['inv' => $r])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h3 class="text-lg font-semibold mt-8 mb-4 divider divider-start">Augments</h3>

    <div class="border border-base-content/5 overflow-x-auto mb-6">
        <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
            <thead class="text-xs uppercase bg-base-300">
                <tr>
                    <th>Aug</th>
                    <th class="w-[10%]">{{ $left->name }}</th>
                    <th class="w-[10%]">{{ $right->name }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($augOrder as $aug)
                    <tr>
                        <td class="align-top">
                            <x-item-link-normal
                                :item_id="$aug->id"
                                :item_name="$aug->Name"
                                :item_icon="$aug->icon"
                                item_class="flex truncate"
                            />
                        </td>
                        <td class="align-top">
                            @if($leftAugs->pluck('id')->contains($aug->id))
                                <span class="text-sm text-success">Owned</span>
                            @else
                                <span class="text-sm text-error">Missing</span>
                            @endif
                        </td>
                        <td class="align-top">
                            @if($rightAugs->pluck('id')->contains($aug->id))
                                <span class="text-sm text-success">Owned</span>
                            @else
                                <span class="text-sm text-error">Missing</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
