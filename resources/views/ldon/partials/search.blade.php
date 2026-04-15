@php
    $labels = [
        'all' => 'Total wins',
        'all_pct' => 'Total win %',
        'guk' => 'Deepest Guk (guk) wins',
        'guk_pct' => 'Deepest Guk (guk) win %',
        'mir' => "Miragul's (mir) wins",
        'mir_pct' => "Miragul's (mir) win %",
        'mmc' => 'Mistmoore (mmc) wins',
        'mmc_pct' => 'Mistmoore (mmc) win %',
        'ruj' => 'Rujarkian (ruj) wins',
        'ruj_pct' => 'Rujarkian (ruj) win %',
        'tak' => 'Takish (tak) wins',
        'tak_pct' => 'Takish (tak) win %',
    ];
@endphp
<form method="GET" action="{{ route('ldon.index') }}" class="space-y-6">
    <div>
        <label for="ldon-type" class="floating-label">
        <select name="type" id="ldon-type" class="select w-full">
            @foreach ($labels as $key => $label)
                <option value="{{ $key }}" @selected(request('type') === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <span>Type</span>
        </label>
    </div>
    <div class="join w-full">
        <button type="submit" class="join-item btn btn-soft btn-success btn-sm flex-1">Search</button>
        <a class="join-item btn btn-soft btn-sm btn-error flex-1" href="{{ route('ldon.index') }}">Reset</a>
    </div>
</form>
