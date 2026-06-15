<div class="border border-base-content/5 scrollbar-thin scrollbar-thumb-accent scrollbar-track-base-300 overflow-y-auto max-h-dvh">
    <table class="table table-auto md:table-fixed w-full table-zebra">
        <thead class="text-xs uppercase bg-base-300 sticky top-0">
            <tr>
                <th scope="col" class="w-[60%]">Name</th>
                <th scope="col" class="w-[20%]">Faction</th>
                @if (config('everquest.faction.display.values'))
                    <th scope="col" class="w-[20%]">Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($factions as $faction)
                <tr>
                    <td scope="row">
                        @if ($faction->factionList)
                            {{ $faction->factionList->name }} ({{ $faction->factionList->id }})
                        @else
                            {{ $faction->faction ?? $faction->id ?? 'Unknown' }}
                        @endif
                    </td>
                    <td class="">{!! factionValue($faction->total) !!}</td>
                    @if (config('everquest.faction.display.values'))
                        <td class="">{{ $faction->total }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
