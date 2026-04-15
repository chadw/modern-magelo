@foreach (config('character_flags.flags') as $section)
    <h2 class="card-title mb-6 flex items-center gap-2 divider divider-start">
        {{ $section['title'] }}
    </h2>

    @foreach ($section['steps'] as $step)
        @php
            $analysis = $flags->analyzeStep($step);
        @endphp
        <div class="collapse collapse-arrow bg-base-300 mb-2">
            <input type="checkbox" />
            <div class="collapse-title font-medium">
                @if ($analysis['hasZoneFlag'])
                    <span class="text-success inline-block items-center mr-2" title="All prerequisites complete">
                        <x-ui.icon name="square-check" />
                    </span>
                    <span>{{ $step['title'] }}</span>
                @elseif (!empty($step['optional']) && $analysis['allMatched'])
                    <span class="text-success inline-block items-center mr-2" title="All prerequisites complete">
                        <x-ui.icon name="square-check" />
                    </span>
                    <span class="text-base-content/50">{{ $step['title'] }}</span>
                @elseif ($analysis['allMatched'])
                    <span class="text-success inline-block items-center mr-2" title="All prerequisites complete">
                        <x-ui.icon name="square-check" />
                    </span>
                    {{ $step['title'] }}
                @else
                    {{ $step['title'] }}
                @endif
            </div>
            <div class="collapse-content">
                <ul class="list-none list-inside">
                    @foreach ($analysis['matchDetails'] as $match)
                        @php
                            $descKey = $match['description_key'];
                            $description = config('character_flags.flag_description.' . $descKey, str_replace('_', ' ', $descKey));
                        @endphp

                        @if ($match['matched'])
                            <li class="text-accent">{{ $description }}</li>
                        @elseif ($match['optional'])
                            <li class="text-base-content/50">{{ $description }}</li>
                        @else
                            <li>{{ $description }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
    @if (!$loop->last)
        <div class="mt-10"></div>
    @endif
@endforeach
