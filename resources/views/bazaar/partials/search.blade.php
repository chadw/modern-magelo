<form method="GET" action="{{ route('bazaar.index') }}" class="space-y-6 sticky top-24">
    <div>
        <label for="baz-name" class="floating-label">
            <input type="text" id="baz-name" name="name" value="{{ request('name') }}"
                class="input w-full"
            />
            <span>Item Name</span>
        </label>
    </div>
    <div>
        <label for="baz-seller" class="floating-label">
            <select name="seller" id="baz-seller" class="select w-full">
                <option value="">Any</option>
                @foreach ($sellers as $name => $label)
                    <option value="{{ $name }}" @selected(request('seller') === $name)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <span>Seller</span>
        </label>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div>
            <label for="baz-class" class="floating-label">
                <select name="class" id="baz-class" class="select w-full">
                    @foreach (collect(config('everquest.classes_short'))->sort() as $k => $v)
                        <option value="{{ $k }}" @selected(request('class') == $k)>
                            {{ $v }}
                        </option>
                    @endforeach
                </select>
                <span>Class</span>
            </label>
        </div>
        <div>
            <label for="baz-race" class="floating-label">
                <select name="race" id="baz-race" class="select w-full">
                    @foreach (collect(config('everquest.races_short'))->sort() as $k => $v)
                        <option value="{{ $k }}" @selected(request('race') == $k)>
                            {{ $v }}
                        </option>
                    @endforeach
                </select>
                <span>Race</span>
            </label>
        </div>
    </div>

    <div>
        <label for="baz-slot" class="floating-label">
            <select name="slot" id="baz-slot" class="select w-full">
                <option value="">Any</option>
                @foreach (collect(config('everquest.slots'))->except($removeSlots)->sort() as $id => $islot)
                    <option value="{{ $id }}" @selected(request('slot') == $id)>
                        {{ $islot }}
                    </option>
                @endforeach
            </select>
            <span>Slot</span>
        </label>
    </div>

    <div>
        <label for="baz-type" class="floating-label">
            <select name="type" id="baz-type" class="select w-full">
                <option value="">Any</option>
                @foreach (config('custom_search_fields.item_types_select') as $group => $types)
                    <optgroup label="{{ $group }}">
                        @foreach ($types as $id => $name)
                            <option value="{{ $id }}" @selected(request('type') != '' && request('type') == $id)>
                                {{ $name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <span>Item Type</span>
        </label>
    </div>

    <div>
        <div class="join w-full">
            <label for="baz-stat" class="floating-label grow">
                <select id="baz-stat" name="stat" class="select join-item w-full">
                    <option value="">Any</option>
                    @foreach (config('custom_search_fields.item_stats_select') as $stat_k => $stat_v)
                        <option value="{{ $stat_k }}" @selected(request('stat') == $stat_k)>
                            {{ $stat_v }}
                        </option>
                    @endforeach
                </select>
                <span>Stat</span>
            </label>
            <select name="statcomp" class="select join-item w-[72px]">
                <option value="1" @selected(request('statcomp') == 1)>&gt;=</option>
                <option value="2" @selected(request('statcomp') == 2)>&lt;=</option>
                <option value="5" @selected(request('statcomp') == 5)>&equals;</option>
            </select>
            <input
                type="number"
                name="statval"
                value="{{ request('statval') }}"
                class="input join-item w-[50px]"
                maxlength="3"
                min="0"
                pattern="\d*"
                inputmode="numeric"
            />
        </div>
    </div>

    <div>
        <label for="baz-augslot" class="floating-label">
            <select name="augslot" id="baz-augslot" class="select w-full">
                <option value="">Any</option>
                @foreach (collect(config('everquest.aug_slots')) as $id)
                    <option value="{{ $id }}" @selected(request('augslot') == $id)>
                        {{ $id }}
                    </option>
                @endforeach
            </select>
            <span>Aug Slot</span>
        </label>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div>
            <label for="baz-pricemin" class="floating-label">
                <input
                    type="number"
                    name="pricemin"
                    id="baz-pricemin"
                    class="input w-full"
                    value="{{ old('pricemin', request('pricemin')) }}"
                    min="0"
                    pattern="\d*"
                    inputmode="numeric"
                >
                <span>Min Price</span>
            </label>
        </div>
        <div>
            <label for="baz-pricemax" class="floating-label">
                <input
                    type="number"
                    name="pricemax"
                    id="baz-pricemax"
                    class="input w-full"
                    value="{{ old('pricemax', request('pricemax')) }}"
                    min="0"
                    pattern="\d*"
                    inputmode="numeric"
                >
                <span>Max Price</span>
            </label>
        </div>
    </div>
    <div class="join w-full">
        <button type="submit" class="join-item btn btn-soft btn-success btn-sm flex-1">Search</button>
        <a class="join-item btn btn-soft btn-sm btn-error flex-1" href="{{ route('bazaar.index') }}">Reset</a>
    </div>
</form>
