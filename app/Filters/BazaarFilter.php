<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BazaarFilter
{
    protected $request;
    protected $builder;

    protected array $filters = [
        'name',
        'slot',
        'augslot',
        'type',
        'class',
        'race',
        'stat',
        'pricemin',
        'pricemax',
        'seller',
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters as $filter) {
            if (method_exists($this, $filter) && $this->request->filled($filter)) {
                $this->{$filter}($this->request->get($filter));
            }
        }

        return $this->builder;
    }

    protected function name($value)
    {
        $this->builder->where('items.Name', 'like', "%{$value}%");
    }

    protected function type($value)
    {
        if ($value === null || $value === '') {
            return;
        }

        $value = (int) $value;

        // handle bagslots if custom bag type selected
        $bagSlots = ($this->request->get('bagslots') >= 1 ? $this->request->get('bagslots') : 1);

        if ($value === 7 || $value === 19) {
            // combine throwing
            $this->builder->whereIn('itemtype', [7, 19]);
        } elseif ($value == 56 || $value == 64) {
            // combine augment distillers
            $this->builder->whereIn('itemtype', [56, 64]);
        } elseif ($value == 33 || $value == 39) {
            // combine keys
            $this->builder->whereIn('itemtype', [33, 39]);
        } elseif ($value == 555) {
            // custom bag filter
            $this->builder->where('bagslots', '>=', $bagSlots)
                ->whereIn('bagtype', [0, 1, 2, 3, 4, 5, 6, 7]);
        } elseif ($value == 556) {
            // custom quest bag filter
            $this->builder->where('bagslots', '>=', $bagSlots)
                ->where('bagtype', 13);
        } elseif ($value == 557) {
            // custom ts bags filter
            $this->builder->where('bagslots', '>=', $bagSlots)
                ->where('bagtype', '>=', 9)
                ->where('bagtype', '!=', 13);
        } else {
            $this->builder->where('itemtype', $value);
        }
    }

    protected function bagslots($value)
    {
        if ($value === null || $value === '') {
            return;
        }

        $value = (int) $value;

        // if custom bag itemtype is selected, lets get it
        $hasType = (in_array($this->request->get('type'), [555, 556, 557]));
        if ($hasType) {
            return;
        }

        $this->builder->where('bagslots', '>=', $value);
    }

    protected function slot($value)
    {
        if ($value !== null && is_numeric($value)) {
            $bitmask = (int) $value;

            $this->builder->whereRaw("(slots & ?) != 0", [$bitmask]);
        }
    }

    protected function augslot($value)
    {
        if ($value !== null && is_numeric($value)) {
            $bitmask = 1 << ($value - 1);
            $this->builder->whereRaw("(augtype & ?) != 0", [$bitmask]);
        }
    }

    protected function class($value)
    {
        if ($value !== null && is_numeric($value)) {
            $bitmask = (int) $value;

            $this->builder->whereRaw("(classes & ?) != 0", [$bitmask]);
        }
    }

    protected function stat($value)
    {
        $stat = $this->request->get('stat');
        $comp = $this->request->get('statcomp', 1);
        $val  = $this->request->get('statval');

        if ($stat && $val !== null) {

            // fuck operators in url
            $op = match ((int) $comp) {
                1 => '>=',
                2 => '<=',
                5 => '=',
                default => '>='
            };

            if ($op === '<=') {
                $this->builder->where($stat, '>=', 1);
            }

            $this->builder->where($stat, $op, $val);
        }
    }

    protected function pricemin($value)
    {
        $min = (float) $value;
        $max = (float) $this->request->get('pricemax');

        // Swap values if min > max
        if ($min > 0 && $max > 0 && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        $this->builder->where('item_cost', '>=', $min * 1000);
    }

    protected function pricemax($value)
    {
        $min = (float) $this->request->get('pricemin');
        $max = (float) $value;

        // Swap values if min > max
        if ($min > 0 && $max > 0 && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        $this->builder->where('item_cost', '<=', $max * 1000);
    }

    protected function seller($value)
    {
        $this->builder->whereHas('character', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }
}
