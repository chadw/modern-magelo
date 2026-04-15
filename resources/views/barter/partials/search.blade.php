<form method="GET" action="{{ route('barter.index') }}" class="space-y-6">
    <div>
        <label for="barter-name" class="floating-label">
            <input type="text" id="barter-name" name="name" value="{{ request('name') }}"
                class="input w-full"
            />
            <span>Item Name</span>
        </label>
    </div>
    <div>
        <label for="barter-buyer" class="floating-label">
        <select name="buyer" id="barter-buyer" class="select w-full">
            <option value="">Any</option>
            @foreach ($buyers as $name => $label)
                <option value="{{ $name }}" @selected(request('buyer') === $name)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <span>Buyers</span>
        </label>
    </div>
    <div>
        <label for="barter-seller" class="floating-label">
            <input type="text" id="barter-seller" name="seller" value="{{ request('seller') }}"
                class="input w-full"
                pattern="[A-Za-z]*" minlength="3" maxlength="15"
            />
            <span>Seller</span>
        </label>
        @error('seller')
        <p class="validator-hint">
            Must be 3 to 15 characters<br/>
            containing only letters
        </p>
        @enderror
    </div>
    <div class="join w-full">
        <button type="submit" class="join-item btn btn-soft btn-success btn-sm flex-1">Search</button>
        <a class="join-item btn btn-soft btn-sm btn-error flex-1" href="{{ route('barter.index') }}">Reset</a>
    </div>
</form>
