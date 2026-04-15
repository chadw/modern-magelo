<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BarterFilter
{
    protected $request;
    protected $builder;

    protected array $filters = [
        'name',
        'buyer',
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
        $this->builder->where('Name', 'like', "%{$value}%");
    }

    protected function buyer($value)
    {
        $this->builder->whereHas('buyer.character', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }
}
