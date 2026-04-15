<div class="tabs overflow-x-auto whitespace-nowrap no-scrollbar tabs-box">
    @foreach (config('everquest.skills') as $k => $v)
        <input type="radio" name="character_skills_tabs" class="tab" aria-label="{{ ucfirst($k) }}"
            {{ $loop->first ? 'checked="checked"' : '' }} />
        <div class="tab-content bg-base-100 border-base-300 p-6">
            @foreach ($v as $key => $val)
                <div
                    class="flex justify-between text-sm sm:text-base w-full p-1.5 pl-2 pr-2{{ $loop->iteration % 2 == 0 ? ' bg-base-200' : '' }} hover:bg-base-300 hover:text-base-content">
                    <span class="grow text-left w-10/12">{{ $val }}</span>
                    @php
                        $value = $k === 'languages' ? $character->languages[$key]['value'] ?? 0 : $skills[$key] ?? 0;
                    @endphp
                    <span class="shrink-0 w-2/12 text-right">{{ $value }}</span>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
