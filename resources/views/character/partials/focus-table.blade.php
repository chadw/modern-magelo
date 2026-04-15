@forelse ($focusItems as $category => $group)
    <h3 class="text-lg font-bold mt-8 mb-2">{{ $category }}</h3>

    <div class="border border-base-content/5 overflow-x-auto mb-6">
        <table class="table table-sm md:table-md table-auto table-zebra md:table-fixed w-full">
            <thead class="text-xs uppercase bg-base-300">
                <tr>
                    <th scope="col" width="40%">Focus</th>
                    <th scope="col" width="40%">Item</th>
                    <th scope="col" width="20%">Slot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group as $foci)
                    <tr>
                        <td scope="row">
                            <x-spell-link
                                :spell_id="$foci['focus']->id"
                                :spell_name="$foci['focus']->name"
                                :spell_icon="$foci['focus']->new_icon"
                                spell_class="inline-flex"
                                :effects_only="1"
                            />
                        </td>
                        <td>{{ $foci['name'] }}</td>
                        <td>{{ $foci['slot_label'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@empty
    <div class="text-sm text-base-content/70">No focus items found</div>
@endforelse
