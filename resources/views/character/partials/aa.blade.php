<div class="flex flex-col sm:flex-row sm:items-start gap-6">
    <div class="flex-1">
        <div class="tabs tabs-box w-full">
            @foreach (config('everquest.aa_types') as $type => $name)
                <input type="radio" name="character_aa_tabs" class="tab" aria-label="{{ $name }}"
                    {{ $loop->first ? 'checked="checked"' : '' }} />
                <div class="tab-content bg-base-100 border-base-300 p-6">
                    @foreach ($aas->get($type, []) as $item)
                        @php
                            $showGrantOnly = config('everquest.aa.display.grant_only');
                            $shouldShow = !$showGrantOnly || ($item['GRANT_ONLY'] == 0) || ($item['GRANT_ONLY'] == 1 && ($item['CUR'] ?? 0) >= 1);
                        @endphp

                        @if ($shouldShow)
                            <div class="flex justify-between w-full p-1.5 pl-2 pr-2{{ $loop->iteration % 2 == 0 ? ' bg-base-200' : '' }} hover:bg-base-300 hover:text-base-content">
                                <span class="grow text-left text-sm sm:text-base w-8/12 truncate">{{ $item['NAME'] }}</span>
                                <span class="shrink-0 w-2/12 text-sm sm:text-base text-right text-nowrap">{{ $item['CUR'] }}/{{ $item['MAX'] }}</span>
                                <span class="shrink-0 w-2/12 text-sm sm:text-base text-right">{{ $item['COST']['display'] }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="hidden sm:flex flex-col sticky top-18 text-sm bg-base-200 border border-base-content/20 rounded-md p-4 shadow-md min-w-[200px]">
        <div class="flex justify-between">
            <span class="text-left"><strong>AA Points:</strong></span>
            <span class="text-right">{{ $character->aa_points }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-left"><strong>Total Spent:</strong></span>
            <span class="text-right">{{ $character->aa_points_spent }}</span>
        </div>
    </div>
</div>
