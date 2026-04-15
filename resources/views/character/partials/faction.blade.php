<div class="border border-base-content/5 scrollbar-thin scrollbar-thumb-accent scrollbar-track-base-300 overflow-y-auto max-h-dvh">
    <table class="table table-auto md:table-fixed w-full table-zebra">
        <thead class="text-xs uppercase bg-base-300 sticky top-0">
            <tr>
                <th scope="col" class="w-[30%]">Name</th>
                <th scope="col" class="w-[10%]">Faction</th>
                @if (config('everquest.faction.display.values'))
                    <th scope="col" class="w-[10%]">Base</th>
                    <th scope="col" class="w-[10%]">Char</th>
                    <th scope="col" class="w-[10%]">Class</th>
                    <th scope="col" class="w-[10%]">Race</th>
                    <th scope="col" class="w-[10%]">Deity</th>
                    <th scope="col" class="w-[10%]">Total</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($factions as $faction)
                <tr>
                    <td scope="row">
                        {{ $faction->factionList->name }} ({{ $faction->factionList->id }})
                    </td>
                    <td class="">{!! factionValue($faction->total) !!}</td>
                    @if (config('everquest.faction.display.values'))
                        <td class="">{{ $faction->factionList->base ?? 0 }}</td>
                        <td class="">{{ $faction->char_value }}</td>
                        <td class="">{{ $faction->cmod }}</td>
                        <td class="">{{ $faction->rmod }}</td>
                        <td class="">{{ $faction->dmod }}</td>
                        <td class="">{{ $faction->total }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
