<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraderAudit;
use App\Filters\TraderAuditFilter;

class TraderAuditController extends Controller
{
    protected array $allowSortBy = ['time', 'seller', 'item'];
    protected array $allowSortDir = ['asc', 'desc'];

    public function index(Request $request) {
        $perPage = 50;

        $sort = $request->get('sort', 'time');
        $direction = $request->get('direction', 'desc');

        $sort = in_array($sort, $this->allowSortBy) ? $sort : 'time';
        $direction = in_array($direction, $this->allowSortDir) ? $direction : 'desc';

        $logsQuery = (new TraderAuditFilter($request))
            ->apply(TraderAudit::query())
            ->with(['item', 'sellerCharacter'])
            ->when(request('item'), function ($query, $item) {
                $query->whereHas('item', function ($q) use ($item) {
                    $q->where('name', 'like', "%{$item}%");
                });
            });

        // Prepare price statistics (min and median) for several time ranges
        $timeRanges = [
            'Past 7 days' => 7,
            'Past 30 days' => 30,
            'Past 90 days' => 90,
            'Past year' => 365,
            'All time' => null,
        ];

        $priceStats = [];
        $baseFilter = new TraderAuditFilter($request);

        // If the filtered results include more than one distinct item, skip median stats
        $distinctItemCount = $baseFilter->apply(TraderAudit::query())
            ->when(request('item'), function ($q) {
                // keep any item name filter applied by the request
            })
            ->distinct()
            ->count('itemname');

        if ($distinctItemCount <= 1) {
            foreach ($timeRanges as $label => $days) {
                $q = $baseFilter->apply(TraderAudit::query());

                if ($days !== null) {
                    $q->where('time', '>=', now()->subDays($days));
                }

                $values = $q->pluck('totalcost')->filter()->map(fn($v) => (float) $v)->values()->all();

                sort($values, SORT_NUMERIC);

                $count = count($values);
                if ($count === 0) {
                    $min = null;
                    $median = null;
                } else {
                    $min = (int) $values[0];

                    $mid = (int) floor(($count - 1) / 2);
                    if ($count % 2) {
                        $median = (int) round($values[$mid]);
                    } else {
                        $median = (int) round(($values[$mid] + $values[$mid + 1]) / 2);
                    }
                }

                $priceStats[] = [
                    'label' => $label,
                    'min' => $min,
                    'median' => $median,
                ];
            }
        }

        match ($sort) {
            'time'  => $logsQuery->orderBy('time', $direction),
            'seller'=> $logsQuery->orderBy('seller', $direction)->orderBy('time', 'desc'),
            'item'  => $logsQuery->orderBy('itemname', $direction)->orderBy('time', 'desc'),
            default => $logsQuery->orderBy('time', 'desc'),
        };

        $logs = $logsQuery->paginate($perPage)->withQueryString();

        return view('history.index', compact('logs', 'priceStats'));
    }
}
