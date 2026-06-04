@if (!empty($priceStats))
    <div class="mb-4">
        <div class="bg-emerald-900 border border-base-content/5 rounded p-3">
            <div class="overflow-x-auto">
                <table class="table table-compact table-zebra w-full text-sm">
                    <thead class="bg-emerald-950">
                        <tr>
                            <th class="text-left text-emerald-400">Period</th>
                            <th class="text-right text-emerald-400">Lowest Price</th>
                            <th class="text-right text-emerald-400">Median Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priceStats as $row)
                            <tr>
                                <td>{{ $row['label'] }}</td>
                                <td class="text-right">
                                    @if ($row['min'] !== null)
                                        <x-currency :value="$row['min']" />
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($row['median'] !== null)
                                        <x-currency :value="$row['median']" />
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
