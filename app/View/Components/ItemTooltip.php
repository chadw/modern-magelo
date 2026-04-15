<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ItemTooltip extends Component
{
    public $item;
    public $augs;
    public string $instance;

    /**
     * Create a new component instance.
     */
    public function __construct($item, $augs = [], string $instance = '')
    {
        $this->item = $item;
        $this->augs = collect($augs)->filter();
        $this->instance = $instance;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.item-tooltip');
    }
}
